<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type'); // Senat, BEM, Himpunan, UKM
            $table->date('deadline');
            $table->unsignedInteger('current_participants')->default(0);
            $table->unsignedInteger('max_participants')->nullable();
            $table->boolean('is_open')->default(true);
            $table->json('available_divisions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};