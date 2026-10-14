<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class LandingController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::where('status', 'aktif')->count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        // Total buku dengan stok > 0 (buku yang bisa dipinjam)
        $bukuTersedia = Buku::where(function($q) {
            $q->where('stok_fisik', '>', 0)->orWhere('stok_digital', '>', 0);
        })->count();
        $bukuTerbaru = Buku::orderBy('created_at', 'desc')->take(6)->get();

        return view('landing.index', compact('totalBuku', 'totalAnggota', 'bukuDipinjam', 'bukuTersedia', 'bukuTerbaru'));
    }
}

