<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            if (!Schema::hasColumn('jadwal_pelajaran', 'jam_ke')) {
                $table->unsignedInteger('jam_ke')->after('hari');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jadwal_pelajaran', function (Blueprint $table) {
            if (Schema::hasColumn('jadwal_pelajaran', 'jam_ke')) {
                $table->dropColumn('jam_ke');
            }
        });
    }
};