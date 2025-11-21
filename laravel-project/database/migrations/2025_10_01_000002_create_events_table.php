<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date('event_date');
            $table->date('deadline');
            $table->unsignedInteger('current_volunteers')->default(0);
            $table->unsignedInteger('max_volunteers')->nullable();
            $table->boolean('is_open')->default(true);
            $table->json('available_roles')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};