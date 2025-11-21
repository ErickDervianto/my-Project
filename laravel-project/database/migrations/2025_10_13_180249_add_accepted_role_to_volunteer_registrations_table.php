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
        Schema::table('volunteer_registrations', function (Blueprint $table) {
            $table->string('accepted_role')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('volunteer_registrations', function (Blueprint $table) {
            $table->dropColumn('accepted_role');
        });
    }
};