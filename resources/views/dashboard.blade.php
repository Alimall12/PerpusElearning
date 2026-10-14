<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="p-4 rounded-md bg-green-100 text-green-800 flex justify-between items-center" x-data="{ show: true }" x-show="show">
                    <span>{{ session('success') }}</span>
                    <button type="button" @click="show = false" class="text-xl leading-none">&times;</button>
                </div>
            @endif

            {{-- Buku Terbaru --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#038666]">
                <div class="p-5">
                    <h3 class="text-base font-semibold text-[#1B4322] mb-3">📚 Buku Terbaru</h3>
                    
                    @if ($bukuTerbaru->isNotEmpty())
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($bukuTerbaru as $buku)
                                <a href="{{ route('katalog.show', $buku->id) }}" class="border border-[#038666] rounded-lg overflow-hidden hover:shadow-md transition block bg-white">
                                    @if ($buku->cover_image)
                                        <div class="w-full h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-full h-56 bg-[#EBF2FA] flex items-center justify-center">
                                            <span class="text-[#038666] text-xs">Tidak ada cover</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-[#081C15] mb-1 line-clamp-1" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                        <p class="text-xs text-[#038666] mb-2 truncate">{{ $buku->pengarang }}</p>
                                        @if($buku->genre)
                                            <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-[#038666] text-[#EBF2FA]">{{ $buku->genre }}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-[#038666] text-sm">Belum ada buku tersedia.</p>
                    @endif
                </div>
            </div>

            {{-- Buku Trending --}}
            @if ($bukuTrending->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#038666]">
                    <div class="p-5">
                        <h3 class="text-base font-semibold text-[#1B4322] mb-3">🔥 Sedang Trending</h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($bukuTrending as $buku)
                                <a href="{{ route('katalog.show', $buku->id) }}" class="border border-[#038666] rounded-lg overflow-hidden hover:shadow-md transition block bg-white">
                                    @if ($buku->cover_image)
                                        <div class="w-full h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-full h-56 bg-[#EBF2FA] flex items-center justify-center">
                                            <span class="text-[#038666] text-xs">Tidak ada cover</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-[#081C15] mb-1 line-clamp-1" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                        <p class="text-xs text-[#038666] mb-2 truncate">{{ $buku->pengarang }}</p>
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($buku->genre)
                                                <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-[#038666] text-[#EBF2FA]">{{ $buku->genre }}</span>
                                            @endif
                                            <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-[#FBB02D] text-[#081C15] font-medium">{{ $buku->peminjaman_count }} pinjam</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Buku Rating Tertinggi --}}
            @if ($bukuRatingTertinggi->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#038666]">
                    <div class="p-5">
                        <h3 class="text-base font-semibold text-[#1B4322] mb-3">⭐ Rating Tertinggi</h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($bukuRatingTertinggi as $buku)
                                <a href="{{ route('katalog.show', $buku->id) }}" class="border border-[#038666] rounded-lg overflow-hidden hover:shadow-md transition block bg-white">
                                    @if ($buku->cover_image)
                                        <div class="w-full h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-full h-56 bg-[#EBF2FA] flex items-center justify-center">
                                            <span class="text-[#038666] text-xs">Tidak ada cover</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-[#081C15] mb-1 line-clamp-1" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                        <p class="text-xs text-[#038666] mb-2 truncate">{{ $buku->pengarang }}</p>
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($buku->genre)
                                                <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-[#038666] text-[#EBF2FA]">{{ $buku->genre }}</span>
                                            @endif
                                            <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-yellow-400 text-[#081C15] font-semibold">⭐ {{ number_format($buku->reviews_avg_rating, 1) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Rekomendasi Genre --}}
            @if (!empty($genres) && $rekomendasi->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-[#038666]">
                    <div class="p-5">
                        <h3 class="text-base font-semibold text-[#1B4322] mb-3">💡 Rekomendasi untuk Genre Kesukaanmu</h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach ($rekomendasi as $buku)
                                <a href="{{ route('katalog.show', $buku->id) }}" class="border border-[#038666] rounded-lg overflow-hidden hover:shadow-md transition block bg-white">
                                    @if ($buku->cover_image)
                                        <div class="w-full h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                            <img src="{{ asset('storage/' . $buku->cover_image) }}" alt="{{ $buku->judul }}" class="w-full h-full object-contain">
                                        </div>
                                    @else
                                        <div class="w-full h-56 bg-[#EBF2FA] flex items-center justify-center">
                                            <span class="text-[#038666] text-xs">Tidak ada cover</span>
                                        </div>
                                    @endif
                                    <div class="p-3">
                                        <h4 class="font-semibold text-sm text-[#081C15] mb-1 line-clamp-1" title="{{ $buku->judul }}">{{ $buku->judul }}</h4>
                                        <p class="text-xs text-[#038666] mb-2 truncate">{{ $buku->pengarang }}</p>
                                        @if($buku->genre)
                                            <span class="inline-block px-2 py-0.5 text-[11px] rounded bg-[#038666] text-[#EBF2FA]">{{ $buku->genre }}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
