<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Data Anggota') }}
            </h2>
            <a href="{{ route('anggota.create') }}" class="px-4 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                + Tambah Anggota
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Kode Anggota</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">NIS</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Alamat</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">No. Telepon</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#038666]">
                        @forelse ($anggota as $item)
                            <tr class="hover:bg-[#EBF2FA] even:bg-[#EBF2FA]">
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->kode_anggota }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->nis ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-[#081C15]">{{ $item->nama }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->alamat }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->no_telepon }}</td>
                                <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->tanggal_daftar ? \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') : '-' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if($item->status == 'aktif')
                                        <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('anggota.edit', $item->id) }}" class="px-3 py-1 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Edit</a>
                                        <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-[#038666]">
                                    <i class="bi bi-people text-[#038666] text-4xl block mb-2"></i>
                                    Belum ada data anggota.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>