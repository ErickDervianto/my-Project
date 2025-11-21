<?php

namespace App\Http\Controllers;

use App\Models\OrganizationRegistration;
use App\Models\VolunteerRegistration; // Diperlukan untuk mengambil data volunteer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil pendaftaran organisasi
        $orgRegistrations = OrganizationRegistration::where('user_id', $user->id)
            ->with('organization')
            ->latest()
            ->get();
            
        // Ambil pendaftaran volunteer
        $volRegistrations = VolunteerRegistration::where('user_id', $user->id)
            ->with('event')
            ->latest()
            ->get();

        $profile_completion = $this->calculateProfileCompletion($user);

        return view('mahasiswa.dashboardMahasiswa', [
            'nama' => $user->nama, 'nim' => $user->nim,
            'semester' => $user->semester, 'ipk' => $user->ipk,
            'prodi' => $user->prodi, 'profile_completion' => $profile_completion,
            'orgRegistrations' => $orgRegistrations, // Kirim data organisasi
            'volRegistrations' => $volRegistrations, // Kirim data volunteer
        ]);
    }

    public function editProfile()
    {
        return view('mahasiswa.profileEdit', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'telepon' => 'nullable|string|max:20',
            'fakultas' => 'nullable|string|max:100',
            'prodi' => 'nullable|string|max:100',
            'semester' => 'nullable|integer|min:1|max:14',
            'ipk' => 'nullable|numeric|min:0|max:4.00',
        ]);
        $user->update($validated);
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    private function calculateProfileCompletion($user): int
    {
        $fields = ['nama', 'email', 'nim', 'prodi', 'semester', 'ipk', 'telepon', 'fakultas'];
        $filledCount = 0;
        foreach ($fields as $field) {
            if (!empty($user->{$field})) {
                $filledCount++;
            }
        }
        return (int) round(($filledCount / count($fields)) * 100);
    }

    public function showRegistrationDetail($id)
    {
        $registration = OrganizationRegistration::with('organization')
                            ->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('mahasiswa.pendaftaran.detail', compact('registration'));
    }

    public function showVolunteerRegistrationDetail($id)
    {
        $registration = VolunteerRegistration::with('event')
                            ->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('mahasiswa.pendaftaran.vol_detail', compact('registration'));
    }
}