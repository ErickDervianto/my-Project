<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Cari organisasi yang akan menjadi penyelenggara event
        $organizer = Organization::where('name', 'BEM Fakultas Ilmu Komputer')->first();

        // Pastikan organisasi ditemukan sebelum membuat event
        if ($organizer) {
            Event::create([
                'organization_id' => $organizer->id, // Hubungkan event ke organisasi
                'name' => 'ORION Digital Festival 2025',
                'description' => 'Festival teknologi tahunan yang diselenggarakan oleh BEM FIKOM. Mencari volunteer untuk berbagai divisi.',
                'event_date' => '2025-11-20',
                'deadline' => '2025-11-01',
                'is_open' => true,
                'available_roles' => ['Acara', 'Humas', 'Dokumentasi', 'Perlengkapan', 'Sponsorship']
            ]);

            Event::create([
                'organization_id' => $organizer->id,
                'name' => 'Workshop Web Development',
                'description' => 'Pelatihan intensif pembuatan website modern untuk pemula.',
                'event_date' => '2025-10-30',
                'deadline' => '2025-10-25',
                'is_open' => false, // Contoh pendaftaran ditutup
                'available_roles' => ['Mentor', 'Asisten Mentor', 'Panitia']
            ]);
        }
    }
}