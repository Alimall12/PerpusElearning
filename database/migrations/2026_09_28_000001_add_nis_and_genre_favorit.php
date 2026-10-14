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
        Schema::table('anggota', function (Blueprint $table) {
            if (!Schema::hasColumn('anggota', 'nis')) {
                $table->string('nis', 30)->nullable()->unique()->after('kode_anggota');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'genre_favorit')) {
                $table->json('genre_favorit')->nullable()->after('anggota_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            if (Schema::hasColumn('anggota', 'nis')) {
                $table->dropUnique(['nis']);
                $table->dropColumn('nis');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'genre_favorit')) {
                $table->dropColumn('genre_favorit');
            }
        });
    }
};
