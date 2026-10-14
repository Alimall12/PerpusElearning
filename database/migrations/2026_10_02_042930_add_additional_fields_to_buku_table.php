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
        Schema::table('buku', function (Blueprint $table) {
            $table->string('bahasa', 50)->default('Indonesia')->after('genre');
            $table->integer('jumlah_halaman')->nullable()->after('bahasa');
            $table->string('kategori', 50)->nullable()->after('jumlah_halaman');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['bahasa', 'jumlah_halaman', 'kategori']);
        });
    }
};
