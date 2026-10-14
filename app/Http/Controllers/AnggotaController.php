<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::latest()->get();
        return view('anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required|unique:anggota',
            'nama' => 'required',
            'nis' => [
                'nullable',
                'string',
                'regex:/^\d{2}\.\d{6}$/',
                'unique:anggota,nis',
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $year = (int)substr($value, 0, 2);
                    $currentYear = (int)date('y');
                    $validYears = [$currentYear, $currentYear - 1, $currentYear - 2];
                    
                    if (!in_array($year, $validYears)) {
                        $fail('NIS hanya berlaku untuk angkatan ' . implode(', ', $validYears) . '.');
                    }
                },
            ],
            'alamat' => 'required',
            'no_telepon' => 'required|unique:anggota,no_telepon',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Anggota::create($validated);

        return redirect()->route('anggota.index')
                        ->with('success', 'Data anggota berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'kode_anggota' => 'required|unique:anggota,kode_anggota,' . $anggota->id,
            'nama' => 'required',
            'nis' => [
                'nullable',
                'string',
                'regex:/^\d{2}\.\d{6}$/',
                'unique:anggota,nis,' . $anggota->id,
                function ($attribute, $value, $fail) {
                    if (!$value) return;
                    $year = (int)substr($value, 0, 2);
                    $currentYear = (int)date('y');
                    $validYears = [$currentYear, $currentYear - 1, $currentYear - 2];
                    
                    if (!in_array($year, $validYears)) {
                        $fail('NIS hanya berlaku untuk angkatan ' . implode(', ', $validYears) . '.');
                    }
                },
            ],
            'alamat' => 'required',
            'no_telepon' => 'required|unique:anggota,no_telepon,' . $anggota->id,
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')
                        ->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroy(Anggota $anggota)
    {
        // Nullify user anggota_id to prevent orphaned users
        \App\Models\User::where('anggota_id', $anggota->id)->update(['anggota_id' => null]);
        
        $anggota->delete();

        return redirect()->route('anggota.index')
                        ->with('success', 'Data anggota berhasil dihapus');
    }
}
