<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Wishlist Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($wishlists->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($wishlists as $wishlist)
                        <div class="bg-white rounded-lg shadow overflow-hidden border border-[#038666]">
                            <a href="{{ route('katalog.show', $wishlist->buku) }}" class="block">
                                <div class="h-56 bg-[#EBF2FA] p-2 flex items-center justify-center">
                                    @if($wishlist->buku->cover_image)
                                        <img src="{{ asset('storage/' . $wishlist->buku->cover_image) }}" alt="{{ $wishlist->buku->judul }}" class="w-full h-full object-contain">
                                    @else
                                        <i class="bi bi-book text-[#038666] text-4xl"></i>
                                    @endif
                                </div>
                            </a>
                            <div class="p-3">
                                <a href="{{ route('katalog.show', $wishlist->buku) }}" class="hover:text-[#038666]">
                                    <h3 class="font-semibold text-sm mb-1 line-clamp-1 text-[#081C15]" title="{{ $wishlist->buku->judul }}">{{ $wishlist->buku->judul }}</h3>
                                </a>
                                <p class="text-[#038666] text-xs mb-3 truncate">{{ $wishlist->buku->pengarang }}</p>
                                
                                <form method="POST" action="{{ route('wishlist.toggle', $wishlist->buku) }}">
                                    @csrf
                                    <button type="submit" class="w-full px-3 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-md text-xs font-semibold">
                                        <i class="bi bi-trash mr-1"></i> Hapus dari Wishlist
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center border border-[#038666]">
                    <i class="bi bi-heart text-[#038666] text-6xl mb-4"></i>
                    <p class="text-[#038666] text-lg mb-4">Wishlist Anda masih kosong</p>
                    <a href="{{ route('katalog') }}" class="inline-block px-6 py-3 bg-[#FBB02D] text-[#081C15] rounded-lg hover:bg-[#d89a26] font-semibold">
                        Jelajahi Katalog
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
