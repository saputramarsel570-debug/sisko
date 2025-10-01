<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_pelajaran', 'jam_ke')) {
                $table->dropColumn('jam_ke');
            }
        });

        Schema::table('jurnal', function (Blueprint $table) {
            if (Schema::hasColumn('jurnal', 'jam_ke')) {
                $table->dropColumn('jam_ke');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            $table->unsignedInteger('jam_ke')->nullable();
        });

        Schema::table('jurnal', function (Blueprint $table) {
            $table->unsignedInteger('jam_ke')->nullable();
        });
    }
};