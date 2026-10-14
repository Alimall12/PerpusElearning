<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Buku $buku)
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
                            ->where('buku_id', $buku->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Dihapus dari wishlist');
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'buku_id' => $buku->id,
            ]);
            return back()->with('success', 'Ditambahkan ke wishlist');
        }
    }

    public function index()
    {
        $wishlists = Wishlist::with('buku')
                             ->where('user_id', auth()->id())
                             ->latest()
                             ->get();

        return view('wishlist.index', compact('wishlists'));
    }
}
