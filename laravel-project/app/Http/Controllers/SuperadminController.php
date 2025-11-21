<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SuperadminController extends Controller
{
    /**
     * Menampilkan dashboard utama Superadmin.
     */
    public function dashboard()
    {
        return view('superadmin.dashboard');
    }

    // --- MANAJEMEN ADMIN ---

    public function adminsIndex()
    {
        $admins = User::where('role', 'admin')->with('organization')->orderBy('nama')->get();
        return view('superadmin.admins.index', compact('admins'));
    }

    public function adminsCreate()
    {
        $organizations = Organization::orderBy('name')->get();
        return view('superadmin.admins.create', compact('organizations'));
    }

    public function adminsStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'organization_id' => 'required|exists:organizations,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
            'organization_id' => $validated['organization_id'],
        ]);

        return redirect()->route('superadmin.admins.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function adminsEdit(User $admin)
    {
        $organizations = Organization::orderBy('name')->get();
        return view('superadmin.admins.edit', compact('admin', 'organizations'));
    }

    public function adminsUpdate(Request $request, User $admin)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($admin->id)],
            'organization_id' => 'required|exists:organizations,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->nama = $validated['nama'];
        $admin->email = $validated['email'];
        $admin->organization_id = $validated['organization_id'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->save();

        return redirect()->route('superadmin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function adminsDestroy(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }
        $admin->delete();
        return redirect()->route('superadmin.admins.index')->with('success', 'Admin berhasil dihapus.');
    }

    // --- MANAJEMEN ORGANISASI ---

    public function organizationsIndex()
    {
        $organizations = Organization::latest()->paginate(10);
        return view('superadmin.organizations.index', compact('organizations'));
    }

    public function organizationsCreate()
    {
        return view('superadmin.organizations.create');
    }

    public function organizationsStore(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:organizations',
            'type' => 'required|string',
            'deadline' => 'required|date',
            'description' => 'required|string',
            'available_divisions' => 'required|string',
            'is_open' => 'required|boolean',
        ]);

        $validatedData['available_divisions'] = array_map('trim', explode(',', $validatedData['available_divisions']));
        Organization::create($validatedData);

        return redirect()->route('superadmin.organizations.index')->with('success', 'Organisasi berhasil ditambahkan!');
    }

    public function organizationsEdit(Organization $organization)
    {
        return view('superadmin.organizations.edit', compact('organization'));
    }

    public function organizationsUpdate(Request $request, Organization $organization)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:organizations,name,' . $organization->id,
            'type' => 'required|string',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'available_divisions' => 'required|string',
            'is_open' => 'required|boolean',
        ]);

        $validatedData['available_divisions'] = array_map('trim', explode(',', $validatedData['available_divisions']));
        $organization->update($validatedData);

        return redirect()->route('superadmin.organizations.index')->with('success', 'Organisasi berhasil diperbarui!');
    }

    public function organizationsDestroy(Organization $organization)
    {
        if ($organization->registrations()->count() > 0) {
            return back()->with('error', 'Organisasi tidak dapat dihapus karena sudah memiliki pendaftar.');
        }
        $organization->delete();
        return redirect()->route('superadmin.organizations.index')->with('success', 'Organisasi berhasil dihapus!');
    }
}