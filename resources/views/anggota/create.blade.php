<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Tambah Anggota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6 border border-[#038666]">

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-md bg-red-100 text-red-800">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('anggota.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Kode Anggota</label>
                        <input type="text" name="kode_anggota" value="{{ old('kode_anggota') }}" maxlength="20"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">NIS (Opsional)</label>
                        <input type="text" name="nis" value="{{ old('nis') }}" maxlength="15"
                               placeholder="Contoh: 26.123456"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                        <p class="mt-1 text-xs text-gray-500">Format: XX.XXXXXX (2 digit tahun angkatan, titik, 6 digit nomor)</p>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" maxlength="100"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat') }}" maxlength="200"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" maxlength="20"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Tanggal Daftar</label>
                            <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar', now()->format('Y-m-d')) }}"
                                   class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Simpan</button>
                        <a href="{{ route('anggota.index') }}" class="px-4 py-2 bg-white border border-[#038666] text-[#038666] rounded-md hover:bg-[#EBF2FA]">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>