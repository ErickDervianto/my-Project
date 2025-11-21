<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->string('division_1');
            $table->string('division_2')->nullable();
            $table->string('division_3')->nullable();
            $table->text('motivation');
            $table->text('organization_experience')->nullable();
            $table->text('skills')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_path')->nullable();
            $table->string('status')->default('pending'); // pending, interview, approved, rejected
            $table->timestamps();

            $table->unique(['user_id', 'organization_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_registrations');
    }
};