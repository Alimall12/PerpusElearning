<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                @if(Auth::user()->isAdmin())
                    {{ __('Daftar Peminjaman') }}
                @else
                    Riwayat Peminjaman Saya
                @endif
            </h2>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('peminjaman.create') }}" class="px-4 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                    + Tambah Peminjaman
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if (session('success'))
                <div class="p-4 rounded-md bg-green-100 text-green-800 flex justify-between items-center" x-data="{ show: true }" x-show="show">
                    <span>{{ session('success') }}</span>
                    <button type="button" @click="show = false" class="text-xl leading-none">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-md bg-red-100 text-red-800 flex justify-between items-center" x-data="{ show: true }" x-show="show">
                    <span>{{ session('error') }}</span>
                    <button type="button" @click="show = false" class="text-xl leading-none">&times;</button>
                </div>
            @endif

            @if(!Auth::user()->isAdmin())
                <div class="p-4 rounded-md bg-[#EBF2FA] border border-[#038666]">
                    <p class="text-sm text-[#081C15]">
                        <span class="font-semibold">Sedang dipinjam:</span> 
                        {{ $aktif->count() }} buku
                    </p>
                </div>
            @endif

            <!-- Active Borrows -->
            <div>
                <h3 class="text-lg font-semibold text-[#081C15] mb-3">Peminjaman Aktif</h3>

                <div class="bg-white rounded-lg shadow border border-[#038666]">
                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed divide-y divide-[#038666]">
                        <thead class="bg-[#1B4322]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Kode Buku - Judul</th>
                                @if(Auth::user()->isAdmin())
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-48">Nama Anggota</th>
                                @endif
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-24">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-36">Keterlambatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#038666]">
                            @forelse ($aktif as $item)
                                <tr class="{{ $loop->iteration % 2 == 1 ? 'bg-white' : 'bg-[#EBF2FA]' }} hover:bg-[#D4E5D7]">
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-[#081C15]">{{ $item->buku->kode_buku }} - {{ $item->buku->judul }}</td>
                                    @if(Auth::user()->isAdmin())
                                        <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->anggota->nama }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-sm">
                                        <span class="text-xs px-2 py-1 rounded {{ $item->copy_type === 'fisik' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} font-semibold">
                                            {{ $item->copy_type === 'fisik' ? 'Fisik' : 'Digital' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($item->hari_keterlambatan > 0)
                                            <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-800 font-semibold">{{ $item->hari_keterlambatan }} hari</span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-800">Dipinjam</span>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <div class="flex gap-2">
                                            @if(Auth::user()->isAdmin())
                                                <a href="{{ route('peminjaman.edit', $item->id) }}" class="px-3 py-1 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Kembalikan</a>
                                                <form action="{{ route('peminjaman.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">Hapus</button>
                                                </form>
                                            @else
                                                <form action="{{ route('peminjaman.return', $item->id) }}" method="POST" onsubmit="return confirm('Kembalikan buku ini?')">
                                                    @csrf
                                                    <button type="submit" class="px-3 py-1 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">Kembalikan</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="@if(Auth::user()->isAdmin()) 9 @else 8 @endif" class="px-4 py-10 text-center text-[#038666]">
                                        <i class="bi bi-check-circle text-[#038666] text-4xl block mb-2"></i>
                                        Tidak ada peminjaman aktif.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- History -->
            <div>
                <h3 class="text-lg font-semibold text-[#081C15] mb-3">Riwayat Peminjaman</h3>
                <div class="bg-white rounded-lg shadow border border-[#038666]">
                    <div class="overflow-x-auto">
                        <table class="w-full table-fixed divide-y divide-[#038666]">
                        <thead class="bg-[#1B4322]">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-16">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider">Kode Buku - Judul</th>
                                @if(Auth::user()->isAdmin())
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-48">Nama Anggota</th>
                                @endif
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-24">Tipe</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Tanggal Pinjam</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Tanggal Kembali</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-36">Keterlambatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-[#EBF2FA] uppercase tracking-wider w-32">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#038666]">
                            @forelse ($riwayat as $item)
                                <tr class="{{ $loop->iteration % 2 == 1 ? 'bg-white' : 'bg-[#EBF2FA]' }} hover:bg-[#D4E5D7]">
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 text-sm font-medium text-[#081C15]">{{ $item->buku->kode_buku }} - {{ $item->buku->judul }}</td>
                                    @if(Auth::user()->isAdmin())
                                        <td class="px-4 py-3 text-sm text-[#081C15]">{{ $item->anggota->nama }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-sm">
                                        <span class="text-xs px-2 py-1 rounded {{ $item->copy_type === 'fisik' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} font-semibold">
                                            {{ $item->copy_type === 'fisik' ? 'Fisik' : 'Digital' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-[#081C15]">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if($item->keterlambatan > 0)
                                            <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-800 font-semibold">{{ $item->keterlambatan }} hari</span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">Dikembalikan</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="@if(Auth::user()->isAdmin()) 8 @else 7 @endif" class="px-4 py-10 text-center text-[#038666]">
                                        <i class="bi bi-journal-bookmark text-[#038666] text-4xl block mb-2"></i>
                                        Belum ada riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
