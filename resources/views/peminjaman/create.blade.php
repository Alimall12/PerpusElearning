<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="buku_id" class="block font-medium text-sm text-gray-700 mb-1">Buku</label>
                        <select name="buku_id" id="buku_id" required
                                class="w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('buku_id') ? 'border-red-500' : 'border-gray-300' }}">
                            <option value="">Pilih Buku</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}
                                        data-stok-fisik="{{ $b->stok_fisik }}" data-stok-digital="{{ $b->stok_digital }}">
                                    {{ $b->kode_buku }} - {{ $b->judul }} (Fisik: {{ $b->stok_fisik }}, Digital: {{ $b->stok_digital }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-2">Tipe Copy <span class="text-red-500">*</span></label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="copy_type" value="fisik" {{ old('copy_type', 'fisik') === 'fisik' ? 'checked' : '' }}
                                       class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500" required>
                                <span class="ml-2 text-sm text-gray-700">Buku Fisik</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="copy_type" value="digital" {{ old('copy_type') === 'digital' ? 'checked' : '' }}
                                       class="rounded-full border-gray-300 text-indigo-600 focus:ring-indigo-500" required>
                                <span class="ml-2 text-sm text-gray-700">E-Book (Digital)</span>
                            </label>
                        </div>
                        @error('copy_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="anggota_id" class="block font-medium text-sm text-gray-700 mb-1">Anggota</label>
                        <select name="anggota_id" id="anggota_id" required
                                class="w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('anggota_id') ? 'border-red-500' : 'border-gray-300' }}">
                            <option value="">Pilih Anggota</option>
                            @foreach($anggota as $a)
                                <option value="{{ $a->id }}" {{ old('anggota_id') == $a->id ? 'selected' : '' }}>
                                    {{ $a->kode_anggota }} - {{ $a->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('anggota_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal_pinjam" class="block font-medium text-sm text-gray-700 mb-1">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required
                               class="w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('tanggal_pinjam') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('tanggal_pinjam')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Pinjamkan Buku</button>
                        <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>