<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Superadmin (tidak terikat organisasi)
        User::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@unika.ac.id',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
        ]);

        // 2. Admin untuk setiap organisasi
        $admins = [
            [
                'name' => 'Admin SMU',
                'email' => 'admin.smu@unika.ac.id',
                'password' => 'smu123',
                'org_name' => 'Senat Mahasiswa Universitas'
            ],
            [
                'name' => 'Admin BEMU',
                'email' => 'admin.bemu@unika.ac.id',
                'password' => 'bemu123',
                'org_name' => 'Badan Eksekutif Mahasiswa Universitas'
            ],
            [
                'name' => 'Admin SM FIKOM',
                'email' => 'admin.smfikom@unika.ac.id',
                'password' => 'smfikom123',
                'org_name' => 'Senat Mahasiswa FIKOM'
            ],
            [
                'name' => 'Admin BEM FIKOM',
                'email' => 'admin.bemfikom@unika.ac.id',
                'password' => 'bemfikom123',
                'org_name' => 'BEM Fakultas Ilmu Komputer'
            ],
            [
                'name' => 'Admin HMTI',
                'email' => 'admin.hmti@unika.ac.id',
                'password' => 'hmti123',
                'org_name' => 'Himpunan Mahasiswa Teknik Informatika'
            ],
            [
                'name' => 'Admin HMPSSI',
                'email' => 'admin.hmpssi@unika.ac.id',
                'password' => 'hmpssi123',
                'org_name' => 'Himpunan Mahasiswa Program Studi Sistem Informasi'
            ],
        ];

        foreach ($admins as $adminData) {
            // Cari ID organisasi berdasarkan nama untuk memastikan relasi benar
            $organization = Organization::where('name', $adminData['org_name'])->first();

            if ($organization) {
                User::create([
                    'nama' => $adminData['name'],
                    'email' => $adminData['email'],
                    'password' => Hash::make($adminData['password']),
                    'role' => 'admin',
                    'organization_id' => $organization->id, // Hubungkan admin ke organisasi
                ]);
            }
        }
    }
}