<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Buku $buku)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Check if already reviewed
        $existing = Review::where('user_id', auth()->id())
                          ->where('buku_id', $buku->id)
                          ->first();

        if ($existing) {
            // Update existing review
            $existing->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return back()->with('success', 'Review diperbarui');
        }

        Review::create([
            'user_id' => auth()->id(),
            'buku_id' => $buku->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review berhasil ditambahkan');
    }

    public function destroy(Review $review)
    {
        // Check ownership
        if ($review->user_id !== auth()->id()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Review dihapus');
    }
}
