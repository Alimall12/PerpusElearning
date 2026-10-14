<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('pengarang', 'LIKE', "%{$search}%");
        }

        $buku = $query->latest()->get();
        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Auto-generate kode buku jika genre dipilih
        if ($request->has('genre') && $request->has('judul')) {
            $request->merge([
                'kode_buku' => \App\Services\BukuCodeGenerator::generate($request->genre, $request->judul)
            ]);
        }

        $data = $request->validate([
            'kode_buku'    => 'required|unique:buku',
            'judul'        => 'required',
            'pengarang'    => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok_fisik'   => 'required|numeric',
            'stok_digital' => 'required|numeric',
            'genre'        => ['required', 'string', \Illuminate\Validation\Rule::in(collect(config('genres'))->except('codes')->flatten()->all())],
            'bahasa'       => 'nullable|string|max:50',
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori'     => ['nullable', 'string', \Illuminate\Validation\Rule::in(config('kategori'))],
            'cover_depan'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_buku'    => 'nullable|file|mimes:pdf|max:20480',
        ]);

        if ($request->hasFile('cover_depan')) {
            $data['cover_image'] = $request->file('cover_depan')->store('covers', 'public');
        }

        if ($request->hasFile('cover_belakang')) {
            $data['back_cover'] = $request->file('cover_belakang')->store('covers', 'public');
        }

        if ($request->hasFile('file_buku')) {
            $data['file_path'] = $request->file('file_buku')->store('ebooks');
        }

        unset($data['cover_depan'], $data['cover_belakang'], $data['file_buku']);
        Buku::create($data);

        return redirect()->route('buku.index')
                        ->with('success', 'Data buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $data = $request->validate([
            'judul'        => 'required',
            'pengarang'    => 'required',
            'penerbit'     => 'required',
            'tahun_terbit' => 'required|numeric',
            'stok_fisik'   => 'required|numeric',
            'stok_digital' => 'required|numeric',
            'genre'        => ['nullable', 'string', \Illuminate\Validation\Rule::in(collect(config('genres'))->except('codes')->flatten()->all())],
            'bahasa'       => 'nullable|string|max:50',
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori'     => ['nullable', 'string', \Illuminate\Validation\Rule::in(config('kategori'))],
            'cover_depan'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover_belakang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_buku'    => 'nullable|file|mimes:pdf|max:20480',
            'hapus_cover_depan' => 'nullable|boolean',
            'hapus_cover_belakang' => 'nullable|boolean',
            'hapus_file'   => 'nullable|boolean',
        ]);

        // Handle cover depan deletion
        if ($request->has('hapus_cover_depan') && $request->hapus_cover_depan) {
            if ($buku->cover_image && \Storage::disk('public')->exists($buku->cover_image)) {
                \Storage::disk('public')->delete($buku->cover_image);
            }
            $data['cover_image'] = null;
        }

        // Handle cover belakang deletion
        if ($request->has('hapus_cover_belakang') && $request->hapus_cover_belakang) {
            if ($buku->back_cover && \Storage::disk('public')->exists($buku->back_cover)) {
                \Storage::disk('public')->delete($buku->back_cover);
            }
            $data['back_cover'] = null;
        }

        // Handle file deletion
        if ($request->has('hapus_file') && $request->hapus_file) {
            if ($buku->file_path && \Storage::exists($buku->file_path)) {
                \Storage::delete($buku->file_path);
            }
            $data['file_path'] = null;
        }

        // Handle cover depan upload
        if ($request->hasFile('cover_depan')) {
            if ($buku->cover_image && \Storage::disk('public')->exists($buku->cover_image)) {
                \Storage::disk('public')->delete($buku->cover_image);
            }
            $data['cover_image'] = $request->file('cover_depan')->store('covers', 'public');
        }

        // Handle cover belakang upload
        if ($request->hasFile('cover_belakang')) {
            if ($buku->back_cover && \Storage::disk('public')->exists($buku->back_cover)) {
                \Storage::disk('public')->delete($buku->back_cover);
            }
            $data['back_cover'] = $request->file('cover_belakang')->store('covers', 'public');
        }

        // Handle file upload
        if ($request->hasFile('file_buku')) {
            if ($buku->file_path && \Storage::exists($buku->file_path)) {
                \Storage::delete($buku->file_path);
            }
            $data['file_path'] = $request->file('file_buku')->store('ebooks');
        }

        unset($data['cover_depan'], $data['cover_belakang'], $data['file_buku'], $data['hapus_cover_depan'], $data['hapus_cover_belakang'], $data['hapus_file']);
        $buku->update($data);

        return redirect()->route('buku.index')
                        ->with('success', 'Data buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        // Delete cover images if exist
        if ($buku->cover_image && \Storage::disk('public')->exists($buku->cover_image)) {
            \Storage::disk('public')->delete($buku->cover_image);
        }
        if ($buku->back_cover && \Storage::disk('public')->exists($buku->back_cover)) {
            \Storage::disk('public')->delete($buku->back_cover);
        }
        
        // Delete file if exists
        if ($buku->file_path && \Storage::exists($buku->file_path)) {
            \Storage::delete($buku->file_path);
        }

        $buku->delete();

        return redirect()->route('buku.index')
                        ->with('success', 'Data buku berhasil dihapus');
    }

    public function baca(Buku $buku)
    {
        abort_unless($buku->file_path && \Storage::exists($buku->file_path), 404);

        $user = auth()->user();

        // Check permission: admin OR has active loan
        $hasPermission = $user->isAdmin() || \App\Models\Peminjaman::where('buku_id', $buku->id)
            ->where('anggota_id', $user->anggota_id)
            ->where('status', 'dipinjam')
            ->exists();

        abort_unless($hasPermission, 403, 'Anda harus meminjam buku ini terlebih dahulu untuk membacanya.');

        return response()->file(\Storage::path($buku->file_path), [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . \Illuminate\Support\Str::slug($buku->judul) . '.pdf"'
        ]);
    }
}
