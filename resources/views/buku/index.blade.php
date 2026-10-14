<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Data Buku') }}
            </h2>
            <a href="{{ route('buku.create') }}" class="px-4 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <form action="{{ route('buku.index') }}" method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari berdasarkan judul atau pengarang..."
                           class="flex-1 rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    <button type="submit" class="px-6 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-white border border-[#038666] text-[#038666] rounded-md hover:bg-[#EBF2FA]">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 rounded-md bg-green-100 text-green-800 flex justify-between items-center" x-data="{ show: true }" x-show="show">
                    <span>{{ session('success') }}</span>
                    <button type="button" @click="show = false" class="text-xl leading-none">&times;</button>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-x-auto border border-[#038666]">
                <table class="min-w-full divide-y divide-[#038666]">
                    <thead class="bg-[#1B4322]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Kode Buku</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Pengarang</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Penerbit</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Tahun</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Stok</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#038666]">
                        @forelse ($buku as $item)
                            <tr class="hover:bg-[#EBF2FA] even:bg-[#EBF2FA]">
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">
                                    {{ $item->kode_buku }}
                                    @if($item->file_path)
                                        <span class="ml-2 text-xs px-2 py-0.5 rounded bg-[#038666] text-[#EBF2FA]">PDF</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-[#081C15]">{{ $item->judul }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->pengarang }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->penerbit }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->tahun_terbit }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="text-xs px-2 py-1 rounded {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('buku.edit', $item->id) }}" class="px-3 py-1 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Edit</a>
                                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-[#038666]">
                                    <i class="bi bi-book text-[#038666] text-4xl block mb-2"></i>
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>