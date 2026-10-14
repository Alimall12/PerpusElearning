<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-md bg-red-100 text-red-800">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Kode Anggota</label>
                        <input type="text" name="kode_anggota" value="{{ old('kode_anggota', $anggota->kode_anggota) }}" maxlength="20" readonly
                               class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">NIS (Opsional)</label>
                        <input type="text" name="nis" value="{{ old('nis', $anggota->nis) }}" maxlength="15"
                               placeholder="Contoh: 26.123456"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-xs text-gray-500">Format: XX.XXXXXX (2 digit tahun angkatan, titik, 6 digit nomor)</p>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $anggota->nama) }}" maxlength="100"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $anggota->alamat) }}" maxlength="200"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon', $anggota->no_telepon) }}" maxlength="20"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Tanggal Daftar</label>
                            <input type="date" name="tanggal_daftar"
                                   value="{{ old('tanggal_daftar', $anggota->tanggal_daftar ? \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="aktif" {{ old('status', $anggota->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $anggota->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
                        <a href="{{ route('anggota.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>