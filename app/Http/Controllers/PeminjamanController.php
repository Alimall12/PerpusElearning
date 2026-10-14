<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Anggota;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $aktif = Peminjaman::with('buku', 'anggota')
                ->where('status', 'dipinjam')
                ->latest()
                ->get();
            $riwayat = Peminjaman::with('buku', 'anggota')
                ->where('status', 'dikembalikan')
                ->latest()
                ->get();
        } else {
            $aktif = Peminjaman::with('buku', 'anggota')
                ->where('anggota_id', $user->anggota_id)
                ->where('status', 'dipinjam')
                ->latest()
                ->get();
            $riwayat = Peminjaman::with('buku', 'anggota')
                ->where('anggota_id', $user->anggota_id)
                ->where('status', 'dikembalikan')
                ->latest()
                ->get();
        }
        
        return view('peminjaman.index', compact('aktif', 'riwayat'));
    }

    public function create()
    {
        $buku = Buku::where(function($q) {
            $q->where('stok_fisik', '>', 0)->orWhere('stok_digital', '>', 0);
        })->get();
        $anggota = Anggota::where('status', 'aktif')->get();
        return view('peminjaman.create', compact('buku', 'anggota'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'anggota_id' => 'required|exists:anggota,id',
            'copy_type' => 'required|in:fisik,digital',
            'tanggal_pinjam' => 'required|date',
        ]);

        $buku = Buku::find($validated['buku_id']);

        $tanggal_pinjam = \Carbon\Carbon::parse($validated['tanggal_pinjam']);
        $tanggal_kembali = $tanggal_pinjam->copy()->addDays(7);

        $peminjaman = \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $buku, $tanggal_pinjam, $tanggal_kembali) {
            if ($validated['copy_type'] === 'fisik') {
                $ok = Buku::where('id', $buku->id)
                    ->where('stok_fisik', '>', 0)
                    ->decrement('stok_fisik');

                if (! $ok) {
                    return null;
                }
            }

            return Peminjaman::create([
                'buku_id' => $validated['buku_id'],
                'anggota_id' => $validated['anggota_id'],
                'copy_type' => $validated['copy_type'],
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_kembali,
                'status' => 'dipinjam',
            ]);
        });

        if (! $peminjaman) {
            return back()->with('error', 'Stok buku fisik habis');
        }

        return redirect()->route('peminjaman.index')
                        ->with('success', 'Data peminjaman berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
        ]);

        $expected = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->addDays(7);
        $actual = \Carbon\Carbon::parse($request->tanggal_kembali);
        $keterlambatan = $actual->gt($expected) ? $actual->diffInDays($expected) : 0;

        $peminjaman->update([
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dikembalikan',
            'keterlambatan' => $keterlambatan,
        ]);

        if ($peminjaman->copy_type === 'fisik') {
            $buku = Buku::find($peminjaman->buku_id);
            $buku->increment('stok_fisik');
        }

        return redirect()->route('peminjaman.index')
                        ->with('success', 'Buku berhasil dikembalikan');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
                        ->with('success', 'Data peminjaman berhasil dihapus');
    }

    // User self-borrow from katalog
    public function userStore(Request $request, Buku $buku)
    {
        $copyType = $request->input('copy_type', 'fisik');

        $user = auth()->user();

        if ($user->isAdmin()) {
            return back()->with('error', 'Admin tidak dapat meminjam buku');
        }
        
        if (! $user->anggota_id) {
            return redirect()->route('keanggotaan.create')
                ->with('error', 'Lengkapi profil keanggotaan dulu');
        }

        $existing = Peminjaman::where('anggota_id', $user->anggota_id)
                              ->where('buku_id', $buku->id)
                              ->where('copy_type', $copyType)
                              ->where('status', 'dipinjam')
                              ->exists();

        if ($existing) {
            return back()->with('error', 'Anda sudah meminjam buku ini');
        }

        $tanggal_pinjam = now();

        $peminjaman = \Illuminate\Support\Facades\DB::transaction(function () use ($buku, $user, $copyType, $tanggal_pinjam) {
            if ($copyType === 'fisik') {
                $ok = Buku::where('id', $buku->id)
                    ->where('stok_fisik', '>', 0)
                    ->decrement('stok_fisik');

                if (! $ok) {
                    return null;
                }
            }

            return Peminjaman::create([
                'buku_id' => $buku->id,
                'anggota_id' => $user->anggota_id,
                'copy_type' => $copyType,
                'tanggal_pinjam' => $tanggal_pinjam,
                'tanggal_kembali' => $tanggal_pinjam->copy()->addDays(7),
                'status' => 'dipinjam',
            ]);
        });

        if (! $peminjaman) {
            return back()->with('error', 'Buku fisik tidak tersedia');
        }

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    // User return book
    public function userReturn(Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if ($peminjaman->anggota_id !== $user->anggota_id) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan');
        }

        $expected = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->addDays(7);
        $now = now();
        $keterlambatan = $now->gt($expected) ? $now->diffInDays($expected) : 0;

        \Illuminate\Support\Facades\DB::transaction(function () use ($peminjaman, $now, $keterlambatan) {
            $peminjaman->update([
                'tanggal_kembali' => $now,
                'status' => 'dikembalikan',
                'keterlambatan' => $keterlambatan,
            ]);

            if ($peminjaman->copy_type === 'fisik') {
                $buku = Buku::find($peminjaman->buku_id);
                $buku->increment('stok_fisik');
            }
        });

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
