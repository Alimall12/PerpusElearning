<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Tambah Buku') }}
        </h2>
    </x-slot>

    @php
        $genres = collect(config('genres'))->except('codes')->toArray();
    @endphp

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

                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Kode Buku</label>
                        <input type="text" name="kode_buku" value="{{ old('kode_buku') }}" maxlength="255"
                               class="w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-[#038666] focus:ring-[#038666]"
                               readonly
                               placeholder="Kode akan dibuat otomatis setelah memilih genre dan judul">
                        <p class="text-xs text-gray-500 mt-1">Kode dibuat otomatis berdasarkan genre dan judul buku</p>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Judul <span class="text-red-600">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul') }}" maxlength="150" required
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Pengarang <span class="text-red-600">*</span></label>
                        <input type="text" name="pengarang" value="{{ old('pengarang') }}" maxlength="100" required
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Penerbit <span class="text-red-600">*</span></label>
                        <input type="text" name="penerbit" value="{{ old('penerbit') }}" maxlength="100" required
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Genre <span class="text-red-600">*</span></label>
                        <select name="genre" required class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                            <option value="">-- Pilih Genre --</option>
                            @foreach ($genres as $group => $items)
                                <optgroup label="{{ $group }}">
                                    @foreach ($items as $g)
                                        <option value="{{ $g }}" {{ old('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Bahasa</label>
                        <input type="text" name="bahasa" value="{{ old('bahasa', 'Indonesia') }}" maxlength="50"
                               class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]"
                               placeholder="Indonesia, Inggris, dll">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-[#081C15] mb-1">Kategori (opsional)</label>
                        <select name="kategori" class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach (config('kategori') as $kat)
                                <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1900" max="2100"
                                   class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}" min="1"
                                   class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]"
                                   placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Stok Fisik</label>
                            <input type="number" name="stok_fisik" value="{{ old('stok_fisik', 0) }}" min="0"
                                   class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-1">Stok Digital</label>
                            <input type="number" name="stok_digital" value="{{ old('stok_digital', 0) }}" min="0"
                                   class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Cover Depan -->
                        <div>
                            <label class="block font-medium text-sm text-[#081C15] mb-2">Cover Depan (opsional)</label>
                            <div class="relative border-2 border-dashed border-[#038666] rounded-xl p-4 bg-[#EBF2FA] hover:bg-[#dfeaf5] transition">
                                <input type="file" id="cover_depan" name="cover_depan" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewImage(event, 'preview_depan')">
                                <label for="cover_depan" class="cursor-pointer block">
                                    <div id="preview_depan" class="flex flex-col items-center justify-center min-h-[200px]">
                                        <svg class="w-12 h-12 text-[#038666] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-[#081C15] font-medium">Klik untuk upload cover depan</p>
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
                            <label class="block font-medium text-sm text-[#081C15] mb-2">Cover Belakang (opsional)</label>
                            <div class="relative border-2 border-dashed border-[#038666] rounded-xl p-4 bg-[#EBF2FA] hover:bg-[#dfeaf5] transition">
                                <input type="file" id="cover_belakang" name="cover_belakang" accept="image/jpeg,image/png,image/jpg" class="hidden" onchange="previewImage(event, 'preview_belakang')">
                                <label for="cover_belakang" class="cursor-pointer block">
                                    <div id="preview_belakang" class="flex flex-col items-center justify-center min-h-[200px]">
                                        <svg class="w-12 h-12 text-[#038666] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm text-[#081C15] font-medium">Klik untuk upload cover belakang</p>
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
                        <label class="block font-medium text-sm text-[#081C15] mb-1">File Buku (PDF, opsional, maks 20 MB)</label>
                        <label for="file_buku" class="block border-2 border-dashed border-[#038666] bg-[#EBF2FA] text-[#081C15] rounded-xl p-8 text-center cursor-pointer hover:bg-[#dfeaf5]">
                            <input id="file_buku" type="file" name="file_buku" accept="application/pdf">
                        </label>
                        @error('file_buku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Simpan</button>
                        <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-white border border-[#038666] text-[#038666] rounded-md hover:bg-[#EBF2FA]">Kembali</a>
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