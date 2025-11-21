<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VolunteerRegistration;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class VolunteerRegistrationController extends Controller
{
    private function mergeWithSession(array $data, Request $request): array
    {
        $sessionData = $request->session()->get('volunteer_data', []);
        return array_merge($sessionData, $data);
    }

    public function createStep1(Request $request)
    {
        $user = Auth::user();
        $registrationData = $this->mergeWithSession([
            'nama' => $user->nama, 'email' => $user->email, 'nim' => $user->nim,
            'telepon' => $user->telepon, 'fakultas' => $user->fakultas,
            'prodi' => $user->prodi, 'semester' => $user->semester, 'ipk' => $user->ipk,
        ], $request);
        return view('mahasiswa.pendaftaran.vol.step1_data_pribadi', compact('registrationData'));
    }

    public function postStep1(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100', 'nim' => 'required|string|max:20',
            'email' => 'required|email|max:100', 'telepon' => 'required|string|max:15',
            'fakultas' => 'required|string', 'prodi' => 'required|string',
            'semester' => 'required|integer', 'ipk' => 'required|numeric|min:0|max:4',
        ]);
        $request->session()->put('volunteer_data', $validatedData);
        return redirect()->route('mahasiswa.vol.step2');
    }

    public function createStep2(Request $request)
    {
        if (!$request->session()->has('volunteer_data')) {
            return redirect()->route('mahasiswa.vol.step1');
        }
        $registrationData = $request->session()->get('volunteer_data');
        $events = Event::where('is_open', true)->get();
        return view('mahasiswa.pendaftaran.vol.step2_pilih_event', compact('registrationData', 'events'));
    }
    
    public function postStep2(Request $request)
    {
        $validatedData = $request->validate(['event_id' => 'required|exists:events,id']);
        $data = $request->session()->get('volunteer_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('volunteer_data', $data);
        return redirect()->route('mahasiswa.vol.step3');
    }

    public function createStep3(Request $request)
    {
        $registrationData = $request->session()->get('volunteer_data');
        if (!isset($registrationData['event_id'])) {
            return redirect()->route('mahasiswa.vol.step2');
        }
        $event = Event::find($registrationData['event_id']);
        $roles = $event ? $event->available_roles : [];

        return view('mahasiswa.pendaftaran.vol.step3_motivasi', compact('registrationData', 'roles'));
    }

    public function postStep3(Request $request)
    {
        $validatedData = $request->validate([
            'role_1' => 'required|string',
            'role_2' => 'nullable|string|different:role_1',
            'motivation' => 'required|string',
            'volunteer_experience' => 'nullable|string',
            'skills' => 'nullable|string',
        ]);
        $data = $request->session()->get('volunteer_data', []);
        $data = array_merge($data, $validatedData);
        $request->session()->put('volunteer_data', $data);
        return redirect()->route('mahasiswa.vol.step4');
    }

    public function createStep4(Request $request)
    {
        $data = $request->session()->get('volunteer_data');
        if (!isset($data['event_id'])) {
            return redirect()->route('mahasiswa.vol.step1')->with('error', 'Sesi tidak lengkap, silakan mulai lagi.');
        }
        $event = Event::find($data['event_id']);
        $data['event_name'] = $event->name ?? 'N/A';
        return view('mahasiswa.pendaftaran.vol.step4_konfirmasi', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->session()->get('volunteer_data');
        if (!$data) {
            return redirect()->route('mahasiswa.vol.step1')->with('error', 'Sesi pendaftaran berakhir.');
        }

        $request->validate([
            'cv' => 'nullable|file|mimes:pdf|max:2048',
            'portfolio' => 'nullable|file|mimes:pdf|max:5120',
            'agree-terms' => 'required',
            'agree-privacy' => 'required',
        ]);

        $cvPath = $request->hasFile('cv') ? $request->file('cv')->store('cvs', 'public') : null;
        $portfolioPath = $request->hasFile('portfolio') ? $request->file('portfolio')->store('portfolios', 'public') : null;

        VolunteerRegistration::create([
            'user_id' => Auth::id(), 'event_id' => $data['event_id'], 'role_1' => $data['role_1'],
            'role_2' => $data['role_2'] ?? null, 'motivation' => $data['motivation'],
            'volunteer_experience' => $data['volunteer_experience'] ?? null,
            'skills' => $data['skills'] ?? null, 'cv_path' => $cvPath, 'portfolio_path' => $portfolioPath,
            'status' => 'pending',
        ]);

        $request->session()->forget('volunteer_data');
        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pendaftaran volunteer berhasil dikirim!');
    }
}