<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (!Schema::hasColumn('buku', 'file_path')) {
                $table->string('file_path')->nullable()->after('blurb');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            if (Schema::hasColumn('buku', 'file_path')) {
                $table->dropColumn('file_path');
            }
        });
    }
};
