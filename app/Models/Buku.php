<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = ['kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok_fisik', 'stok_digital', 'genre', 'bahasa', 'jumlah_halaman', 'kategori', 'cover_image', 'back_cover', 'blurb', 'file_path'];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function getStokAttribute()
    {
        return $this->stok_fisik + $this->stok_digital;
    }
}