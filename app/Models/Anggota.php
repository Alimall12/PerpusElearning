<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = ['kode_anggota', 'nama', 'nis', 'alamat', 'no_telepon', 'tanggal_daftar', 'status'];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}

