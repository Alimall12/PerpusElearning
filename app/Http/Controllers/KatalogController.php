<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'LIKE', "%{$request->search}%")
                  ->orWhere('pengarang', 'LIKE', "%{$request->search}%");
            });
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereIn('genre', (array) $request->genre);
        }

        // Filter by pengarang
        if ($request->filled('pengarang')) {
            $query->whereIn('pengarang', (array) $request->pengarang);
        }

        // Filter by penerbit
        if ($request->filled('penerbit')) {
            $query->whereIn('penerbit', (array) $request->penerbit);
        }

        $buku = $query->latest()->paginate(12)->withQueryString();

        // Get unique values for filters
        $pengarangs = Buku::select('pengarang')->distinct()->orderBy('pengarang')->pluck('pengarang');
        $penerbits = Buku::select('penerbit')->distinct()->orderBy('penerbit')->pluck('penerbit');

        $filters = [
            'Kategori Buku' => [
                'type' => 'nested',
                'data' => [
                    'Fiksi' => ['Romansa', 'Fantasi', 'Misteri / Detektif', 'Fiksi Ilmiah (Sci-Fi)'],
                    'Non-Fiksi' => ['Pengembangan Diri', 'Biografi & Sejarah', 'Bisnis & Keuangan', 'Sains & Teknologi'],
                    'Referensi & Akademik' => ['Jurnal Ilmiah', 'Buku Pelajaran / Diktat', 'Ensiklopedia'],
                ],
            ],
            'Pengarang' => [
                'type' => 'list',
                'data' => $pengarangs,
            ],
            'Penerbit' => [
                'type' => 'list',
                'data' => $penerbits,
            ],
        ];

        return view('katalog.index', compact('buku', 'filters'));
    }

    public function show(Buku $buku)
    {
        $buku->load(['reviews.user']);

        // Calculate average rating
        $avgRating = $buku->reviews->avg('rating') ?: 0;
        $totalReviews = $buku->reviews->count();

        // Check if user already reviewed
        $userReview = $buku->reviews->where('user_id', auth()->id())->first();

        // Check if in wishlist
        $inWishlist = Wishlist::where('user_id', auth()->id())
                               ->where('buku_id', $buku->id)
                               ->exists();

        // Check if user can read the book
        $user = auth()->user();
        $canRead = $buku->file_path && ($user->isAdmin() || \App\Models\Peminjaman::where('buku_id', $buku->id)
            ->where('anggota_id', $user->anggota_id)
            ->where('copy_type', 'digital')
            ->where('status', 'dipinjam')
            ->exists());

        return view('katalog.show', compact('buku', 'avgRating', 'totalReviews', 'userReview', 'inWishlist', 'canRead'));
    }
}
