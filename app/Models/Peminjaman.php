<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = ['buku_id', 'anggota_id', 'copy_type', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'keterlambatan'];

    protected $appends = ['hari_keterlambatan'];

    public function getHariKeterlambatanAttribute()
    {
        if ($this->status === 'dikembalikan') {
            return $this->keterlambatan;
        }
        
        $expected = \Carbon\Carbon::parse($this->tanggal_pinjam)->addDays(7);
        $now = \Carbon\Carbon::now();
        
        if ($now->gt($expected)) {
            return $now->diffInDays($expected);
        }
        
        return 0;
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }
}
