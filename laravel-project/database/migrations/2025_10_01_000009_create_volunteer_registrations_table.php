<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('role_1');
            $table->string('role_2')->nullable();
            $table->string('role_3')->nullable();
            $table->text('motivation');
            $table->text('volunteer_experience')->nullable();
            $table->text('skills')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_path')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_registrations');
    }
};