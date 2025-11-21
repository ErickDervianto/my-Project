<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('faculty')->nullable();
            $table->string('study_program')->nullable();
            $table->integer('semester')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->text('organization_experience')->nullable();
            $table->text('skills')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('portfolio_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};