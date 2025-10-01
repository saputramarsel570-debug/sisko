<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurnal', function (Blueprint $table) {
            if (!Schema::hasColumn('jurnal', 'jam_ke')) {
                $table->unsignedInteger('jam_ke')->after('tanggal');
            }

            if (Schema::hasColumn('jurnal', 'mapel_id')) {
                $table->renameColumn('mapel_id', 'mata_pelajaran_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('jurnal', function (Blueprint $table) {
            if (Schema::hasColumn('jurnal', 'jam_ke')) {
                $table->dropColumn('jam_ke');
            }

            if (Schema::hasColumn('jurnal', 'mata_pelajaran_id')) {
                $table->renameColumn('mata_pelajaran_id', 'mapel_id');
            }
        });
    }
};