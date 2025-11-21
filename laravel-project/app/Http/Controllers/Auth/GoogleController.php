<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Exception;
use Laravel\Socialite\Facades\Socialite; 

class GoogleController extends Controller
{
    protected string $allowedDomain = 'student.unika.ac.id';

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Gagal autentikasi dengan Google.');
        }

        $email = strtolower($googleUser->getEmail() ?? '');
        $googleId = $googleUser->getId();

        if (empty($email) || empty($googleId)) {
            return redirect('/login')->with('error', 'Google tidak mengembalikan email atau id.');
        }

        $nim = $this->extractNimFromEmail($email);

        $user = User::where('google_id', $googleId)
                    ->orWhere('email', $email)
                    ->first();

        $isAllowedDomain = str_ends_with($email, '@' . $this->allowedDomain);

        if ($user) {
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                if (!$user->google_id) {
                    $user->google_id = $googleId;
                    $user->save();
                }
                Auth::login($user, true);
                return $user->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('superadmin.dashboard');
            }

            if (!$isAllowedDomain) {
                return redirect('/login')
                    ->with('error', 'Hanya akun @student.unika.ac.id yang diperbolehkan.');
            }

            if (!$user->google_id) $user->google_id = $googleId;
            if (!$user->nim && $nim) $user->nim = $nim;
            $user->save();

            Auth::login($user, true);
            return redirect()->route('mahasiswa.dashboard');
        }

        if (!$isAllowedDomain) {
            return redirect('/login')
                ->with('error', 'Hanya akun @student.unika.ac.id yang diperbolehkan untuk pendaftaran.');
        }

        if (!$nim) {
            return redirect('/login')
                ->with('error', 'Format email tidak valid. Email harus berawalan NIM (contoh: 23n10004@student.unika.ac.id).');
        }

        $name = $googleUser->getName() ?? $googleUser->getNickname() ?? explode('@', $email)[0];

        $newUser = User::create([
            'nama' => $name,
            'email' => $email,
            'nim' => $nim,
            'password' => Hash::make(Str::random(32)),
            'google_id' => $googleId,
            'role' => 'mahasiswa',
        ]);

        Auth::login($newUser, true);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Akun berhasil dibuat! Lengkapi profil Anda.');
    }

    private function extractNimFromEmail(string $email): ?string
    {
        if (!str_ends_with($email, '@student.unika.ac.id')) {
            return null;
        }

        $username = strtoupper(explode('@', $email)[0]);

        if (preg_match('/^(\d{2})(N)(\d{1})(\d{4})$/', $username, $matches)) {
            return $matches[1] . '.' . $matches[2] . $matches[3] . '.' . $matches[4];
        }

        return null;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah keluar.');
    }
}