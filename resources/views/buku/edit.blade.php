<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    @php
        $genres = collect(config('genres'))->except('codes')->toArray();
    @endphp

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

                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Kode Buku</label>
                        <input type="text" name="kode_buku" value="{{ old('kode_buku', $buku->kode_buku) }}" maxlength="20" readonly
                               class="w-full rounded-md border-gray-300 bg-gray-100 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" maxlength="150"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Pengarang</label>
                        <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" maxlength="100"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Penerbit</label>
                        <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" maxlength="100"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Genre</label>
                        <select name="genre" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Genre --</option>
                            @foreach ($genres as $group => $items)
                                <optgroup label="{{ $group }}">
                                    @foreach ($items as $g)
                                        <option value="{{ $g }}" {{ old('genre', $buku->genre) == $g ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Bahasa</label>
                        <input type="text" name="bahasa" value="{{ old('bahasa', $buku->bahasa ?? 'Indonesia') }}" maxlength="50"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Indonesia, Inggris, dll">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Kategori (opsional)</label>
                        <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach (config('kategori') as $kat)
                                <option value="{{ $kat }}" {{ old('kategori', $buku->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" min="1900" max="2100"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" min="1"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Stok Fisik</label>
                            <input type="number" name="stok_fisik" value="{{ old('stok_fisik', $buku->stok_fisik) }}" min="0"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-1">Stok Digital</label>
                            <input type="number" name="stok_digital" value="{{ old('stok_digital', $buku->stok_digital) }}" min="0"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Cover Depan -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Cover Depan (opsional)</label>
                            @if($buku->cover_image)
                                <div class="mb-3 p-3 border border-gray-200 rounded-lg bg-gray-50">
                                    <img src="{{ Storage::url($buku->cover_image) }}" class="max-h-[150px] mx-auto rounded-lg shadow-sm mb-2">
                                    <label class="flex items-center justify-center">
                                        <input type="checkbox" name="hapus_cover_depan" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Hapus cover depan</span>
                                    </label>
                                </div>
                            @endif
                            <div class="relative border-2 border-dashed border-indigo-300 rounded-xl p-4 bg-indigo-50 hover:bg-indigo-100 transition">
                                <input type="file" id="cover_depan_edit" name="cover_depan" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewImage(event, 'preview_depan_edit')">
                                <label for="cover_depan_edit" class="cursor-pointer block">
                                    <div id="preview_depan_edit" class="flex flex-col items-center justify-center min-h-[200px]">
                                        <svg class="w-12 h-12 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-700 font-medium">Klik untuk upload cover depan baru</p>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG (maks 2MB)</p>
                                    </div>
                                </label>
                            </div>
                            @error('cover_depan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Belakang -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700 mb-2">Cover Belakang (opsional)</label>
                            @if($buku->back_cover)
                                <div class="mb-3 p-3 border border-gray-200 rounded-lg bg-gray-50">
                                    <img src="{{ Storage::url($buku->back_cover) }}" class="max-h-[150px] mx-auto rounded-lg shadow-sm mb-2">
                                    <label class="flex items-center justify-center">
                                        <input type="checkbox" name="hapus_cover_belakang" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Hapus cover belakang</span>
                                    </label>
                                </div>
                            @endif
                            <div class="relative border-2 border-dashed border-indigo-300 rounded-xl p-4 bg-indigo-50 hover:bg-indigo-100 transition">
                                <input type="file" id="cover_belakang_edit" name="cover_belakang" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewImage(event, 'preview_belakang_edit')">
                                <label for="cover_belakang_edit" class="cursor-pointer block">
                                    <div id="preview_belakang_edit" class="flex flex-col items-center justify-center min-h-[200px]">
                                        <svg class="w-12 h-12 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-gray-700 font-medium">Klik untuk upload cover belakang baru</p>
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG (maks 2MB)</p>
                                    </div>
                                </label>
                            </div>
                            @error('cover_belakang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">File Buku (PDF, opsional, maks 20 MB)</label>
                        @if($buku->file_path)
                            <p class="text-sm text-gray-600 mb-2">✓ File sudah diunggah</p>
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="hapus_file" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Hapus file</span>
                            </label>
                        @endif
                        <input type="file" name="file_buku" accept="application/pdf"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('file_buku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
                        <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="relative">
                            <img src="${e.target.result}" class="max-h-[250px] mx-auto rounded-lg shadow-md object-cover">
                            <div class="mt-2 text-center">
                                <p class="text-xs text-gray-600">${input.files[0].name}</p>
                                <p class="text-xs text-gray-500">${(input.files[0].size / 1024).toFixed(2)} KB</p>
                            </div>
                        </div>
                    `;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>