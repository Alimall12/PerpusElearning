<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Lengkapi Data Keanggotaan</h2>
        <p class="text-sm text-gray-600">Isi formulir di bawah untuk melanjutkan ke dashboard</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-md bg-red-100 text-red-800">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('keanggotaan.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required maxlength="100"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nis" class="block text-sm font-medium text-gray-700 mb-1">NIS (Nomor Induk Siswa)</label>
            <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required maxlength="15"
                   placeholder="Contoh: 26.123456"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <p class="mt-1 text-xs text-gray-500">Format: XX.XXXXXX (2 digit tahun angkatan, titik, 6 digit nomor)</p>
            @error('nis')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}" required maxlength="200"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
            <input id="no_telepon" type="text" name="no_telepon" value="{{ old('no_telepon') }}" required maxlength="20"
                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('no_telepon')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Genre Favorit (Opsional)</label>
            <div class="space-y-3">
                @foreach ($genres as $group => $items)
                    <div class="border rounded-md p-3 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-600 mb-2 uppercase">{{ $group }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach ($items as $genre)
                                <label class="flex items-center">
                                    <input type="checkbox" name="genre_favorit[]" value="{{ $genre }}"
                                           {{ in_array($genre, old('genre_favorit', [])) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700">{{ $genre }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            @error('genre_favorit')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-2">
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700">
                Daftar
            </button>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                    Log Out
                </button>
            </form>
        </div>
    </form>
</x-guest-layout>
