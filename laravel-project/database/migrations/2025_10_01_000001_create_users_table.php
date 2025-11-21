<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('telepon', 100)->nullable();
            $table->string('fakultas', 100)->nullable();
            $table->string('nim', 20)->nullable()->unique();
            $table->string('password')->nullable();
            $table->string('google_id')->nullable()->unique();
            $table->string('role')->default('mahasiswa'); // superadmin, admin, mahasiswa
            $table->string('prodi', 100)->nullable();
            $table->integer('semester')->nullable();
            $table->decimal('ipk', 3, 2)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};