<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Katalog Buku') }}
        </h2>
    </x-slot>
    
    @push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-6">
                <form method="GET" action="{{ route('katalog') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Cari judul atau pengarang..." 
                           class="flex-1 rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]">
                    @foreach((array)request('genre', []) as $g)
                        <input type="hidden" name="genre[]" value="{{ $g }}">
                    @endforeach
                    @foreach((array)request('pengarang', []) as $p)
                        <input type="hidden" name="pengarang[]" value="{{ $p }}">
                    @endforeach
                    @foreach((array)request('penerbit', []) as $pb)
                        <input type="hidden" name="penerbit[]" value="{{ $pb }}">
                    @endforeach
                    <button type="submit" class="px-6 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                        Cari
                    </button>
                    @if(request('search') || request('genre') || request('pengarang') || request('penerbit'))
                        <a href="{{ route('katalog') }}" class="px-4 py-2 bg-white border border-[#038666] text-[#038666] rounded-md hover:bg-[#EBF2FA]">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <div class="flex gap-6">
                <!-- Sidebar Filters -->
                <div class="w-64 flex-shrink-0">
                    <div class="bg-white rounded-lg shadow p-4 border border-[#038666]">
                        <form id="filterForm" method="GET" action="{{ route('katalog') }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="bi bi-funnel-fill text-[#1B4322] text-sm"></i>
                                    <h3 class="font-bold text-sm tracking-wider text-[#1B4322] uppercase">Filter</h3>
                                </div>
                                @if(request('genre') || request('pengarang') || request('penerbit'))
                                    <a href="{{ route('katalog', request()->only('search')) }}" class="text-xs text-[#038666] hover:underline font-medium">
                                        Reset
                                    </a>
                                @endif
                            </div>

                            @foreach($filters as $label => $filter)
                                @php
                                    $isNested = $filter['type'] === 'nested';
                                    $filterKey = $label === 'Pengarang' ? 'pengarang' : ($label === 'Penerbit' ? 'penerbit' : 'genre');
                                    $hasActiveFilter = !empty(request($filterKey));
                                @endphp
                                <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }}" x-data="{ open: {{ $isNested || $hasActiveFilter ? 'true' : 'false' }} }">
                                    <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left font-semibold text-sm mb-2 text-[#081C15]">
                                        <span>{{ $label }}</span>
                                        <i class="bi text-xs transition-transform duration-200" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                    </button>

                                    <div x-show="open" x-cloak class="space-y-3 pt-1">
                                        @if($isNested)
                                            @foreach($filter['data'] as $genre => $subGenres)
                                                @php
                                                    $hasSubActive = collect($subGenres)->contains(fn($s) => in_array($s, (array)request('genre', [])));
                                                @endphp
                                                <div x-data="{ openSub: {{ $hasSubActive ? 'true' : 'true' }} }" class="text-xs">
                                                    <button type="button"
                                                            @click="openSub = !openSub"
                                                            class="flex items-center justify-between w-full text-left font-medium text-gray-600 hover:text-[#038666] py-1">
                                                        <span>{{ $genre }}</span>
                                                        <i class="bi text-[10px]" :class="openSub ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                                                    </button>
                                                    <div x-show="openSub" x-cloak class="pl-2 space-y-1.5 mt-1">
                                                        @foreach($subGenres as $sub)
                                                            <label class="flex items-center gap-2.5 text-xs text-[#081C15] hover:text-[#038666] cursor-pointer select-none">
                                                                <input type="checkbox" name="genre[]" value="{{ $sub }}"
                                                                       {{ in_array($sub, (array)request('genre', [])) ? 'checked' : '' }}
                                                                       onchange="this.form.submit()"
                                                                       class="rounded border-gray-300 text-[#038666] focus:ring-[#038666] h-4 w-4">
                                                                <span class="{{ in_array($sub, (array)request('genre', [])) ? 'font-semibold text-[#038666]' : '' }}">{{ $sub }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            @if($filter['data']->count() > 0)
                                                <div class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
                                                    @foreach($filter['data'] as $item)
                                                        <label class="flex items-center gap-2.5 text-xs text-[#081C15] hover:text-[#038666] cursor-pointer select-none" title="{{ $item }}">
                                                            <input type="checkbox" name="{{ $filterKey }}[]" value="{{ $item }}"
                                                                   {{ in_array($item, (array)request($filterKey, [])) ? 'checked' : '' }}
                                                                   onchange="this.form.submit()"
                                                                   class="rounded border-gray-300 text-[#038666] focus:ring-[#038666] h-4 w-4">
                                                            <span class="truncate {{ in_array($item, (array)request($filterKey, [])) ? 'font-semibold text-[#038666]' : '' }}">{{ $item }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4 pt-2">
                                <button type="submit" class="w-full py-2 px-3 bg-[#FBB02D] hover:bg-[#d89a26] text-[#081C15] text-xs font-semibold rounded-md shadow-sm transition">
                                    Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Book Grid -->
                <div class="flex-1">
                    @if($buku->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                            @foreach($buku as $b)
                                <a href="{{ route('katalog.show', $b) }}" class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition-shadow border border-[#038666] block">
                                    <div class="h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                        @if($b->cover_image)
                                            <img src="{{ asset('storage/' . $b->cover_image) }}" alt="{{ $b->judul }}" class="w-full h-full object-contain">
                                        @else
                                            <i class="bi bi-book text-[#038666] text-4xl"></i>
                                        @endif
                                    </div>
                                    <div class="p-3">
                                        <h3 class="font-semibold text-sm mb-1 line-clamp-1 text-[#081C15]" title="{{ $b->judul }}">{{ $b->judul }}</h3>
                                        <p class="text-[#038666] text-xs mb-2 truncate">{{ $b->pengarang }}</p>
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center text-[#FBB02D]">
                                                @php
                                                    $avgRating = $b->reviews->avg('rating') ?: 0;
                                                @endphp
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }} text-xs"></i>
                                                @endfor
                                                <span class="ml-1 text-[11px] text-[#038666]">({{ $b->reviews->count() }})</span>
                                            </div>
                                            <span class="text-[11px] px-1.5 py-0.5 rounded font-medium {{ $b->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $b->stok > 0 ? 'Tersedia' : 'Habis' }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $buku->links() }}
                        </div>
                    @else
                        <div class="bg-white rounded-lg shadow p-8 text-center border border-[#038666]">
                            <i class="bi bi-search text-[#038666] text-5xl mb-4"></i>
                            <p class="text-[#038666]">Tidak ada buku ditemukan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
