<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->renameColumn('stok', 'stok_fisik');
        });
        
        Schema::table('buku', function (Blueprint $table) {
            $table->integer('stok_digital')->default(0)->after('stok_fisik');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('copy_type', ['fisik', 'digital'])->default('fisik')->after('anggota_id');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('copy_type');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('stok_digital');
        });
        
        Schema::table('buku', function (Blueprint $table) {
            $table->renameColumn('stok_fisik', 'stok');
        });
    }
};
