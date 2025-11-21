<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizationRegistration;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationRegistrationController extends Controller
{
    private function mergeWithSession(array $data, Request $request): array
    {
        $sessionData = $request->session()->get('registration_data', []);
        return array_merge($sessionData, $data);
    }

    public function createStep1(Request $request)
    {
        $user = Auth::user();
        $registrationData = $this->mergeWithSession([
            'nama' => $user->nama,
            'email' => $user->email,
            'nim' => $user->nim,
            'telepon' => $user->telepon,
            'fakultas' => $user->fakultas,
            'prodi' => $user->prodi,
            'semester' => $user->semester,
            'ipk' => $user->ipk,
        ], $request);
        return view('mahasiswa.pendaftaran.org.step1_data_pribadi', compact('registrationData'));
    }

    public function postStep1(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'nim' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'telepon' => 'required|string|max:15',
            'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'semester' => 'required|integer',
            'ipk' => 'required|numeric|min:0|max:4',
        ]);
        $request->session()->put('registration_data', $validatedData);
        return redirect()->route('mahasiswa.org.step2');
    }

    public function createStep2(Request $request)
    {
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('mahasiswa.org.step1');
        }
        $registrationData = $request->session()->get('registration_data');
        $organizations = Organization::where('is_open', true)->get();
        return view('mahasiswa.pendaftaran.org.step2_pilih_organisasi', compact('registrationData', 'organizations'));
    }
    
    public function postStep2(Request $request)
    {
        $validatedData = $request->validate(['organization_id' => 'required|exists:organizations,id']);
        $data = $request->session()->get('registration_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('registration_data', $data);
        return redirect()->route('mahasiswa.org.step3');
    }

    public function createStep3(Request $request)
    {
        $registrationData = $request->session()->get('registration_data');
        if (!isset($registrationData['organization_id'])) {
            return redirect()->route('mahasiswa.org.step2');
        }
        $organization = Organization::find($registrationData['organization_id']);
        $divisions = $organization ? $organization->available_divisions : [];

        return view('mahasiswa.pendaftaran.org.step3_motivasi', compact('registrationData', 'divisions'));
    }

    public function postStep3(Request $request)
    {
        $validatedData = $request->validate([
            'division_1' => 'required|string',
            'division_2' => 'nullable|string|different:division_1',
            'division_3' => 'nullable|string|different:division_1|different:division_2',
            'motivation' => 'required|string',
            'organization_experience' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);
        $data = $request->session()->get('registration_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('registration_data', $data);
        return redirect()->route('mahasiswa.org.step4');
    }

    public function createStep4(Request $request)
    {
        $data = $request->session()->get('registration_data');
        if (!isset($data['organization_id'])) {
            return redirect()->route('mahasiswa.org.step1')->with('error', 'Sesi tidak lengkap, silakan mulai lagi.');
        }
        $organization = Organization::find($data['organization_id']);
        $data['organization_name'] = $organization->name ?? 'N/A';
        return view('mahasiswa.pendaftaran.org.step4_konfirmasi', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->session()->get('registration_data');
        if (!$data) {
            return redirect()->route('mahasiswa.org.step1')->with('error', 'Sesi pendaftaran berakhir.');
        }

        $request->validate([
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'portfolio' => 'nullable|file|mimes:pdf|max:5120',
            'agree-terms' => 'required',
            'agree-privacy' => 'required',
        ]);

        $cvPath = $request->hasFile('cv') ? $request->file('cv')->store('cvs', 'public') : null;
        $portfolioPath = $request->hasFile('portfolio') ? $request->file('portfolio')->store('portfolios', 'public') : null;

        OrganizationRegistration::create([
            'user_id' => Auth::id(),
            'organization_id' => $data['organization_id'],
            'division_1' => $data['division_1'],
            'division_2' => $data['division_2'] ?? null,
            'division_3' => $data['division_3'] ?? null,
            'motivation' => $data['motivation'],
            'organization_experience' => $data['organization_experience'] ?? null,
            'skills' => $data['skills'] ?? null,
            'cv_path' => $cvPath,
            'portfolio_path' => $portfolioPath,
            'status' => 'pending',
        ]);
        
        $user = Auth::user();
        $user->update([
            'nama' => $data['nama'], 'nim' => $data['nim'], 'telepon' => $data['telepon'],
            'fakultas' => $data['fakultas'], 'prodi' => $data['prodi'],
            'semester' => $data['semester'], 'ipk' => $data['ipk'],
        ]);

        $request->session()->forget('registration_data');
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pendaftaran Anda berhasil dikirim!');
    }
}