<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationRegistration;
use App\Models\VolunteerRegistration;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard utama Admin dengan filter.
     */
    public function dashboard(Request $request)
    {
        $admin = Auth::user();
        $organization_id = $admin->organization_id;
        $statusFilter = $request->query('status');

        if (!$organization_id) {
            return view('admin.dashboardAdmin', [
                'organization' => null,
                'organizationName' => 'Tidak Terhubung ke Organisasi',
                'orgRegistrations' => collect(),
                'volRegistrations' => collect(),
                'statusFilter' => $statusFilter,
            ]);
        }

        $organization = Organization::find($organization_id);
        $organizationName = $organization->name;

        $orgRegistrations = OrganizationRegistration::with('user')
            ->where('organization_id', $organization_id)
            ->when($statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        $volRegistrations = VolunteerRegistration::with(['user', 'event'])
            ->whereHas('event', function ($query) use ($organization_id) {
                $query->where('organization_id', $organization_id);
            })
            ->when($statusFilter, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();

        return view('admin.dashboardAdmin', compact('organization', 'orgRegistrations', 'volRegistrations', 'organizationName', 'statusFilter'));
    }

    /**
     * Membuka atau menutup pendaftaran untuk organisasi milik admin.
     */
    public function toggleOrganizationStatus(Request $request)
    {
        $admin = Auth::user();
        $organization = Organization::find($admin->organization_id);

        if (!$organization) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak terhubung dengan organisasi manapun.');
        }

        $organization->is_open = !$organization->is_open;
        $organization->save();

        $status = $organization->is_open ? 'dibuka' : 'ditutup';
        return redirect()->route('admin.dashboard')->with('success', "Pendaftaran untuk {$organization->name} berhasil {$status}.");
    }

    /**
     * Memperbarui detail organisasi (deskripsi dan divisi).
     */
    public function updateOrganization(Request $request)
    {
        $admin = Auth::user();
        $organization = Organization::findOrFail($admin->organization_id);

        $validatedData = $request->validate([
            'description' => 'required|string|max:1000',
            'available_divisions' => 'required|string',
        ]);

        $validatedData['available_divisions'] = array_map('trim', explode(',', $validatedData['available_divisions']));
        $organization->update($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Detail organisasi dan divisi berhasil diperbarui.');
    }

    /**
     * Menampilkan form untuk admin mengedit detail organisasinya.
     */
    public function editOrganization()
    {
        $admin = Auth::user();
        if (!$admin->organization_id) {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak terhubung dengan organisasi manapun.');
        }
        
        $organization = Organization::findOrFail($admin->organization_id);
        return view('admin.organization.edit', compact('organization'));
    }

    /**
     * Mengubah status pendaftaran (organisasi atau volunteer).
     */
    public function updateRegistrationStatus(Request $request, $type, $id)
    {
        // Tipe data divalidasi terlebih dahulu
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,interview',
            'accepted_division' => 'nullable|string',
            'accepted_role' => 'nullable|string'
        ]);

        // Jika statusnya adalah 'approved', maka accepted_division/role menjadi wajib
        if ($validated['status'] == 'approved') {
            if ($type == 'organization') {
                $request->validate(['accepted_division' => 'required|string']);
            } elseif ($type == 'volunteer') {
                $request->validate(['accepted_role' => 'required|string']);
            }
        }

        $model = $type === 'organization' ? OrganizationRegistration::class : VolunteerRegistration::class;
        $registration = $model::findOrFail($id);
        
        $registration->status = $validated['status'];

        if ($validated['status'] === 'approved') {
            if ($type === 'organization') {
                $registration->accepted_division = $request->accepted_division;
            } elseif ($type === 'volunteer') {
                $registration->accepted_role = $request->accepted_role;
            }
        } else {
            if ($type === 'organization') $registration->accepted_division = null;
            if ($type === 'volunteer') $registration->accepted_role = null;
        }
        
        $registration->save();

        return redirect()->back()->with('success', 'Status pendaftaran berhasil diubah.');
    }

    /**
     * Menampilkan detail pendaftar ORGANISASI.
     */
    public function showOrgRegistration($id)
    {
        $registration = OrganizationRegistration::with(['user', 'organization'])->findOrFail($id);
        return view('admin.showRegistration', compact('registration'));
    }

    /**
     * Menampilkan detail pendaftar VOLUNTEER.
     */
    public function showVolRegistration($id)
    {
        $registration = VolunteerRegistration::with(['user', 'event'])->findOrFail($id);
        return view('admin.showVolRegistration', compact('registration'));
    }

    /**
     * Menampilkan daftar semua event milik organisasi admin. (GET /admin/events)
     */
    public function index()
    {
        $admin = Auth::user();
        $events = Event::where('organization_id', $admin->organization_id)->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan form untuk membuat event baru. (GET /admin/events/create)
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Menyimpan event baru ke database. (POST /admin/events)
     */
    public function store(Request $request)
    {
        $admin = Auth::user();
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'deadline' => 'required|date',
            'available_roles' => 'required|string',
            'is_open' => 'required|boolean',
        ]);

        $validatedData['organization_id'] = $admin->organization_id;
        $validatedData['available_roles'] = array_map('trim', explode(',', $validatedData['available_roles']));
        
        Event::create($validatedData);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit event. (GET /admin/events/{event}/edit)
     */
    public function edit(Event $event)
    {
        if ($event->organization_id !== Auth::user()->organization_id) {
            abort(403, 'Akses Ditolak');
        }
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Memperbarui data event di database. (PUT/PATCH /admin/events/{event})
     */
    public function update(Request $request, Event $event)
    {
        if ($event->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'deadline' => 'required|date',
            'available_roles' => 'required|string',
            'is_open' => 'required|boolean',
        ]);

        $validatedData['available_roles'] = array_map('trim', explode(',', $validatedData['available_roles']));
        $event->update($validatedData);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Menghapus event dari database. (DELETE /admin/events/{event})
     */
    public function destroy(Event $event)
    {
        if ($event->organization_id !== Auth::user()->organization_id) {
            abort(403);
        }
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus!');
    }
}