<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KeanggotaanController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->anggota_id) {
            return redirect()->route('dashboard');
        }

        $genres = collect(config('genres'))->except('codes')->toArray();

        return view('keanggotaan.create', [
            'genres' => $genres,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->user()->anggota_id) {
            return redirect()->route('dashboard');
        }

        $allGenres = collect(config('genres'))->flatten()->toArray();

        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'nis' => [
                'required',
                'string',
                'regex:/^\d{2}\.\d{6}$/',
                'unique:anggota,nis',
                function ($attribute, $value, $fail) {
                    $year = (int)substr($value, 0, 2);
                    $currentYear = (int)date('y');
                    $validYears = [$currentYear, $currentYear - 1, $currentYear - 2];
                    
                    if (!in_array($year, $validYears)) {
                        $fail('NIS hanya berlaku untuk angkatan ' . implode(', ', $validYears) . '.');
                    }
                },
            ],
            'alamat' => 'required|string|max:200',
            'no_telepon' => 'required|string|max:20|unique:anggota,no_telepon',
            'genre_favorit' => 'nullable|array',
            'genre_favorit.*' => ['string', Rule::in($allGenres)],
        ]);

        DB::transaction(function () use ($request, $data) {
            $anggota = Anggota::create([
                'kode_anggota' => 'AGT-' . $data['nis'],
                'nama' => $data['nama'],
                'nis' => $data['nis'],
                'alamat' => $data['alamat'],
                'no_telepon' => $data['no_telepon'],
                'tanggal_daftar' => now()->toDateString(),
                'status' => 'aktif',
            ]);

            $request->user()->update([
                'name' => $data['nama'],
                'anggota_id' => $anggota->id,
                'genre_favorit' => $data['genre_favorit'] ?? [],
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Selamat! Keanggotaan Anda berhasil didaftarkan.');
    }
}
