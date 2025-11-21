<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 7 Organisasi sesuai permintaan admin
        Organization::create([
            'name' => 'Senat Mahasiswa Universitas',
            'description' => 'Badan legislatif mahasiswa tingkat universitas.',
            'type' => 'Universitas',
            'deadline' => '2025-12-15',
            'is_open' => true,
            'available_divisions' => ['Komisi Legislasi', 'Komisi Aspirasi', 'Badan Kehormatan']
        ]);

        Organization::create([
            'name' => 'Badan Eksekutif Mahasiswa Universitas',
            'description' => 'Badan eksekutif mahasiswa tingkat universitas.',
            'type' => 'Universitas',
            'deadline' => '2025-12-15',
            'is_open' => true,
            'available_divisions' => ['Kementerian Dalam Negeri', 'Kementerian Luar Negeri', 'Kementerian PSDM']
        ]);

        Organization::create([
            'name' => 'Senat Mahasiswa FIKOM',
            'description' => 'Badan legislatif mahasiswa tingkat Fakultas Ilmu Komputer.',
            'type' => 'Fakultas',
            'deadline' => '2025-12-20',
            'is_open' => true,
            'available_divisions' => ['Komisi 1', 'Komisi 2', 'Komisi 3']
        ]);

        Organization::create([
            'name' => 'BEM Fakultas Ilmu Komputer',
            'description' => 'Badan eksekutif mahasiswa Fakultas Ilmu Komputer.',
            'type' => 'Fakultas',
            'deadline' => '2025-12-20',
            'is_open' => true,
            'available_divisions' => ['Divisi Humas', 'Divisi Akademik', 'Divisi Minat Bakat']
        ]);

        Organization::create([
            'name' => 'Himpunan Mahasiswa Teknik Informatika',
            'description' => 'Wadah aspirasi mahasiswa program studi Teknik Informatika.',
            'type' => 'Prodi',
            'deadline' => '2025-12-25',
            'is_open' => true,
            'available_divisions' => ['Divisi Riset', 'Divisi Kewirausahaan', 'Divisi Media']
        ]);

        Organization::create([
            'name' => 'Himpunan Mahasiswa Program Studi Sistem Informasi',
            'description' => 'Wadah aspirasi mahasiswa program studi Sistem Informasi.',
            'type' => 'Prodi',
            'deadline' => '2025-12-25',
            'is_open' => false, // Contoh pendaftaran ditutup
            'available_divisions' => ['Divisi Advokasi', 'Divisi Humas', 'Divisi Akademik']
        ]);
    }
}