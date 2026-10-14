<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $genres = $request->user()->genre_favorit ?? [];

        // Buku terbaru (latest upload)
        $bukuTerbaru = Buku::latest()->limit(6)->get();
        
        // Buku rating tertinggi
        $bukuRatingTertinggi = Buku::withAvg('reviews', 'rating')
            ->having('reviews_avg_rating', '>', 0)
            ->orderByDesc('reviews_avg_rating')
            ->limit(6)
            ->get();
        
        // Buku trending (paling banyak dipinjam bulan ini)
        $bukuTrending = Buku::withCount(['peminjaman' => function($q) {
                $q->whereMonth('tanggal_pinjam', now()->month);
            }])
            ->orderByDesc('peminjaman_count')
            ->limit(6)
            ->get();

        // Rekomendasi based on genre
        $rekomendasi = !empty($genres)
            ? Buku::whereIn('genre', $genres)->where(function($q) {
                $q->where('stok_fisik', '>', 0)->orWhere('stok_digital', '>', 0);
            })->inRandomOrder()->limit(6)->get()
            : collect();

        return view('dashboard', compact('genres', 'rekomendasi', 'bukuTerbaru', 'bukuRatingTertinggi', 'bukuTrending'));
    }
}
