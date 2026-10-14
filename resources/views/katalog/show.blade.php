<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-[#081C15] leading-tight">
                {{ $buku->judul }}
            </h2>
            <a href="{{ route('katalog') }}" class="inline-flex items-center px-4 py-2 bg-[#038666] text-white rounded-md hover:bg-[#1B4322] transition font-medium">
                ← Kembali ke Katalog
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Book Detail -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-8 border border-[#038666]">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row gap-8">
                        @php
                            $covers = [];
                            if ($buku->cover_image) {
                                $covers[] = ['label' => 'Cover Depan', 'url' => asset('storage/' . $buku->cover_image)];
                            }
                            if ($buku->back_cover) {
                                $covers[] = ['label' => 'Cover Belakang', 'url' => asset('storage/' . $buku->back_cover)];
                            }
                        @endphp

                        <!-- Cover with Slider -->
                        <div class="w-full md:w-80 flex-shrink-0" x-data="{ activeIndex: 0, total: {{ count($covers) }} }">
                            <div class="relative w-full h-[460px] bg-[#EBF2FA] rounded-lg flex items-center justify-center p-3 border border-[#038666]/30 overflow-hidden">
                                @if(count($covers) > 0)
                                    @foreach($covers as $index => $cover)
                                        <img src="{{ $cover['url'] }}" alt="{{ $buku->judul }} - {{ $cover['label'] }}"
                                             @if(count($covers) > 1)
                                                 x-show="activeIndex === {{ $index }}"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 x-cloak
                                             @endif
                                             class="w-full h-full object-contain rounded-lg">
                                    @endforeach

                                    @if(count($covers) > 1)
                                        <!-- Navigation Arrows -->
                                        <button type="button" @click="activeIndex = (activeIndex === 0) ? total - 1 : activeIndex - 1"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-[#1B4322]/80 hover:bg-[#1B4322] text-white flex items-center justify-center transition shadow-md z-10"
                                                title="Lihat Cover Sebelumnya">
                                            <i class="bi bi-chevron-left text-base"></i>
                                        </button>
                                        <button type="button" @click="activeIndex = (activeIndex === total - 1) ? 0 : activeIndex + 1"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-[#1B4322]/80 hover:bg-[#1B4322] text-white flex items-center justify-center transition shadow-md z-10"
                                                title="Lihat Cover Berikutnya">
                                            <i class="bi bi-chevron-right text-base"></i>
                                        </button>
                                    @endif
                                @else
                                    <i class="bi bi-book text-[#038666] text-8xl"></i>
                                @endif
                            </div>

                            @if(count($covers) > 1)
                                <!-- Cover Selector Switcher -->
                                <div class="flex justify-center items-center gap-2 mt-3">
                                    @foreach($covers as $index => $cover)
                                        <button type="button" @click="activeIndex = {{ $index }}"
                                                :class="activeIndex === {{ $index }} ? 'bg-[#038666] text-white ring-2 ring-[#038666]/30' : 'bg-white text-[#081C15] border border-[#038666] hover:bg-[#EBF2FA]'"
                                                class="px-3 py-1.5 rounded-md text-xs font-semibold transition shadow-sm flex items-center gap-1">
                                            <i class="bi {{ $index === 0 ? 'bi-image' : 'bi-image-fill' }}"></i>
                                            {{ $cover['label'] }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold mb-3 text-[#081C15]">{{ $buku->judul }}</h1>
                            <p class="text-[#038666] text-lg mb-6">oleh {{ $buku->pengarang }}</p>
                            
                            <div class="mb-6 text-[#081C15] space-y-2">
                                <p><span class="font-semibold text-[#1B4322]">Penerbit:</span> {{ $buku->penerbit }}</p>
                                <p><span class="font-semibold text-[#1B4322]">Tahun:</span> {{ $buku->tahun_terbit }}</p>
                                @if($buku->genre)
                                    <p><span class="font-semibold text-[#1B4322]">Genre:</span> <span class="inline-block px-3 py-1 text-sm rounded bg-[#038666] text-white">{{ $buku->genre }}</span></p>
                                @endif
                            </div>

                            <div class="flex items-center mb-6">
                                <div class="flex items-center text-[#FBB02D] text-xl">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= round($avgRating) ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="ml-3 text-[#038666] font-medium">{{ number_format($avgRating, 1) }} / 5 <span class="text-sm">({{ $totalReviews }} reviews)</span></span>
                            </div>

                            <div class="mb-8">
                                <div class="flex gap-4 items-center">
                                    <span class="inline-block px-5 py-2 rounded-lg text-base font-semibold {{ $buku->stok_fisik > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        📚 Fisik: {{ $buku->stok_fisik }} {{ $buku->stok_fisik > 0 ? 'tersedia' : 'habis' }}
                                    </span>
                                    <span class="inline-block px-5 py-2 rounded-lg text-base font-semibold {{ $buku->stok_digital > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                        💾 Digital: {{ $buku->stok_digital > 0 ? 'tersedia' : 'tidak tersedia' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex gap-4 flex-wrap">
                                @if($buku->stok_fisik > 0 || $buku->stok_digital > 0)
                                    <form method="POST" action="{{ route('pinjam.store', $buku) }}" class="flex gap-2">
                                        @csrf
                                        @if($buku->stok_fisik > 0)
                                            <button type="submit" name="copy_type" value="fisik" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                                                <i class="bi bi-book-fill mr-2"></i> Pinjam Fisik
                                            </button>
                                        @endif
                                        @if($buku->stok_digital > 0)
                                            <button type="submit" name="copy_type" value="digital" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                                <i class="bi bi-file-earmark-text-fill mr-2"></i> Pinjam Digital
                                            </button>
                                        @endif
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('wishlist.toggle', $buku) }}">
                                    @csrf
                                    <button type="submit" class="px-6 py-3 {{ $inWishlist ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} rounded-lg font-semibold">
                                        <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }} mr-2"></i>
                                        {{ $inWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}
                                    </button>
                                </form>

                                @if($canRead)
                                    <a href="{{ route('buku.baca', $buku) }}" target="_blank" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold inline-block">
                                        <i class="bi bi-file-pdf mr-2"></i> Baca Buku
                                    </a>
                                @elseif($buku->file_path)
                                    <p class="text-sm text-gray-600 italic py-3">Pinjam buku ini untuk membaca</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($buku->blurb)
                        <div class="mt-8 pt-8 border-t">
                            <h3 class="text-xl font-semibold mb-4">Sinopsis</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $buku->blurb }}</p>
                        </div>
                    @endif
                </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-lg shadow overflow-hidden border border-[#038666]">
                <div class="p-8">
                    <h3 class="text-2xl font-semibold mb-6">Reviews & Ratings ({{ $totalReviews }})</h3>

                    <!-- Review Form -->
                    <div class="mb-8 p-6 bg-white rounded-lg border border-[#038666]">
                        <h4 class="font-semibold mb-4 text-[#1B4322] text-lg">{{ $userReview ? '✏️ Edit Review Anda' : '✍️ Tulis Review' }}</h4>
                        <form method="POST" action="{{ route('review.store', $buku) }}">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 text-[#081C15]">Rating</label>
                                <div class="flex items-center gap-2">
                                    <div class="star-rating flex text-3xl">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star star-input text-gray-400 hover:text-[#FBB02D] cursor-pointer transition-transform hover:scale-110" data-rating="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" value="{{ $userReview->rating ?? '' }}" required>
                                    <span id="rating-text" class="text-sm text-[#038666]"></span>
                                </div>
                                @error('rating')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2 text-[#081C15]">Komentar (opsional)</label>
                                <textarea name="comment" rows="4" class="w-full rounded-md border-[#038666] shadow-sm focus:border-[#038666] focus:ring-[#038666]" placeholder="Tulis review Anda...">{{ $userReview->comment ?? '' }}</textarea>
                                @error('comment')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="px-6 py-2 bg-[#FBB02D] text-[#081C15] rounded-md hover:bg-[#d89a26] font-semibold">
                                {{ $userReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                        </form>
                    </div>

                    <hr class="my-8">

                    <!-- Reviews List -->
                    <div class="space-y-6">
                        @forelse($buku->reviews->sortByDesc('created_at') as $review)
                            <div class="border-b border-[#EBF2FA] pb-6 last:border-b-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="font-semibold text-[#081C15]">{{ $review->user->name }}</p>
                                        <div class="flex items-center gap-2 text-sm text-[#038666]">
                                            <div class="flex text-[#FBB02D]">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                                @endfor
                                            </div>
                                            <span>•</span>
                                            <span>{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    @if($review->user_id === auth()->id())
                                        <form method="POST" action="{{ route('review.destroy', $review) }}" onsubmit="return confirm('Hapus review ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                @if($review->comment)
                                    <p class="text-[#081C15] mt-2">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @empty
                            <p class="text-[#038666] text-center py-8">Belum ada review untuk buku ini</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-input');
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');
            
            const currentRating = ratingInput.value;
            if (currentRating) {
                updateStars(parseInt(currentRating));
            }
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    updateStars(rating);
                });
                
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating, true);
                });
            });
            
            document.querySelector('.star-rating').addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value) || 0;
                updateStars(currentRating);
            });
            
            function updateStars(rating, isHover = false) {
                stars.forEach((star, idx) => {
                    if (idx < rating) {
                        star.classList.remove('bi-star', 'text-gray-400');
                        star.classList.add('bi-star-fill', 'text-[#FBB02D]');
                    } else {
                        star.classList.remove('bi-star-fill', 'text-[#FBB02D]');
                        star.classList.add('bi-star', 'text-gray-400');
                    }
                });
                
                if (!isHover) {
                    ratingText.textContent = rating > 0 ? `${rating} / 5` : '';
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

