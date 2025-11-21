<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Tambahkan kolom ini setelah kolom 'role'
        $table->foreignId('organization_id')
              ->nullable() // Boleh kosong untuk superadmin & mahasiswa
              ->after('role')
              ->constrained('organizations') // Terhubung ke tabel organizations
              ->onDelete('set null'); // Jika organisasi dihapus, admin tidak terhapus
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['organization_id']);
        $table->dropColumn('organization_id');
    });
}
};
