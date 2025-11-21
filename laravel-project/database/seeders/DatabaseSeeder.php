<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Urutan ini penting untuk menjaga relasi data
        $this->call([
            OrganizationSeeder::class, // 1. Buat Organisasi dulu
            AdminSeeder::class,        // 2. Baru buat Admin yang terhubung ke Organisasi
            EventSeeder::class,        // 3. Terakhir buat Event yang terhubung ke Organisasi
        ]);
    }
}