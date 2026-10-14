<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengembalian Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow p-6">

                <h3 class="font-semibold text-lg mb-4">Informasi Peminjaman</h3>
                <dl class="mb-6 divide-y divide-gray-200 border border-gray-200 rounded-md">
                    <div class="flex px-4 py-3">
                        <dt class="w-48 font-medium text-sm text-gray-600">Buku</dt>
                        <dd class="text-sm text-gray-900">{{ $peminjaman->buku->kode_buku }} - {{ $peminjaman->buku->judul }}</dd>
                    </div>
                    <div class="flex px-4 py-3">
                        <dt class="w-48 font-medium text-sm text-gray-600">Anggota</dt>
                        <dd class="text-sm text-gray-900">{{ $peminjaman->anggota->kode_anggota }} - {{ $peminjaman->anggota->nama }}</dd>
                    </div>
                    <div class="flex px-4 py-3">
                        <dt class="w-48 font-medium text-sm text-gray-600">Tanggal Pinjam</dt>
                        <dd class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}</dd>
                    </div>
                </dl>

                <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="tanggal_kembali" class="block font-medium text-sm text-gray-700 mb-1">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                               value="{{ old('tanggal_kembali', now()->format('Y-m-d')) }}" required
                               class="w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('tanggal_kembali') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('tanggal_kembali')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Konfirmasi Pengembalian</button>
                        <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Batal</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>