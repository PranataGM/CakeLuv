@extends('layouts.app')

@section('content')
<div class="bg-white py-16 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Breadcrumb -->
        <div class="mb-12" data-aos="fade-right">
            <nav class="text-sm font-light text-gray-500 mb-4 tracking-wide">
                <a href="{{ url('/') }}" class="hover:text-primary transition">Beranda</a> 
                <span class="mx-2">/</span> 
                <span class="text-primary font-medium">Katalog Produk</span>
            </nav>
            <h1 class="font-serif text-4xl font-bold text-dark">Koleksi <span class="text-primary italic">CakeLuv</span></h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            
            <!-- Sidebar Filter (Desktop) -->
            <div class="w-full lg:w-1/4" data-aos="fade-up">
                <form action="{{ url('/shop') }}" method="GET" id="filterForm" class="bg-secondary/50 p-6 rounded-2xl border border-gray-100 sticky top-28">
                    
                    <!-- Search Input (Optional, kept structural) -->
                    <div class="mb-8">
                        <h3 class="font-serif font-bold text-lg text-dark mb-4 border-b-2 border-primary/20 pb-2 inline-block">Pencarian</h3>
                        <input type="text" name="search" placeholder="Cari kue..." value="{{ request('search') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light transition">
                    </div>

                    <div class="mb-8">
                        <h3 class="font-serif font-bold text-lg text-dark mb-4 border-b-2 border-primary/20 pb-2 inline-block">Kategori</h3>
                        <ul class="space-y-3 font-light text-sm">
                            <li>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="" onchange="document.getElementById('filterForm').submit()" {{ !request('category') ? 'checked' : '' }} class="form-radio text-primary focus:ring-primary h-4 w-4">
                                    <span class="ml-3 group-hover:text-primary transition {{ !request('category') ? 'text-primary font-medium' : 'text-gray-600' }}">Semua Kategori</span>
                                </label>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="category" value="{{ $cat->slug }}" onchange="document.getElementById('filterForm').submit()" {{ request('category') == $cat->slug ? 'checked' : '' }} class="form-radio text-primary focus:ring-primary h-4 w-4">
                                    <span class="ml-3 group-hover:text-primary transition {{ request('category') == $cat->slug ? 'text-primary font-medium' : 'text-gray-600' }}">{{ $cat->name }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-serif font-bold text-lg text-dark mb-4 border-b-2 border-primary/20 pb-2 inline-block">Urutkan</h3>
                        <select name="sort" onchange="document.getElementById('filterForm').submit()" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light cursor-pointer appearance-none bg-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama: A - Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama: Z - A</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Product Grid -->
            <div class="w-full lg:w-3/4">
                <style>
                    .horizontal-grid {
                        display: grid;
                        grid-auto-flow: column;
                        grid-auto-columns: 280px;
                        gap: 2rem;
                        overflow-x: auto;
                        padding-bottom: 1.5rem;
                        cursor: grab;
                    }
                    .horizontal-grid:active {
                        cursor: grabbing;
                    }
                    .grid-rows-3 { grid-template-rows: repeat(3, minmax(0, 1fr)); }
                    .grid-rows-1 { grid-template-rows: repeat(1, minmax(0, 1fr)); }
                    .horizontal-grid::-webkit-scrollbar { height: 6px; }
                    .horizontal-grid::-webkit-scrollbar-track { background: #FAF9F6; border-radius: 10px; }
                    .horizontal-grid::-webkit-scrollbar-thumb { background: #e0b4b0; border-radius: 10px; }
                    .horizontal-grid::-webkit-scrollbar-thumb:hover { background: #C5837C; }
                </style>

                <!-- Section Kue -->
                <div class="mb-12">
                    <h2 class="font-serif text-3xl font-bold text-dark mb-6">Aneka Kue & Dessert</h2>
                    @if($cakes->count() > 0)
                        <div class="horizontal-grid grid-rows-3" id="kueGrid">
                            @foreach($cakes as $index => $item)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 group border border-gray-100 overflow-hidden flex flex-col h-[420px]" data-aos="fade-left" data-aos-delay="{{ ($index % 3) * 100 }}">
                                <a href="{{ url('/shop/' . $item->slug) }}" class="relative h-48 overflow-hidden block flex-shrink-0">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                                    @if($item->category->slug == 'best-sellers')
                                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-primary tracking-wider uppercase">Best Seller</div>
                                    @endif
                                    @if($item->daily_stock <= 0)
                                        <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center">
                                            <span class="bg-dark text-white px-3 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase">Habis Terjual</span>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="text-[10px] text-primary font-bold tracking-widest uppercase mb-1">{{ $item->category->name }}</div>
                                    <a href="{{ url('/shop/' . $item->slug) }}" class="block mb-1">
                                        <h4 class="font-serif font-bold text-lg text-dark group-hover:text-primary transition-colors line-clamp-1">{{ $item->name }}</h4>
                                    </a>
                                    <p class="text-gray-500 text-xs font-light line-clamp-2 mb-4 flex-grow">{{ $item->description }}</p>
                                    
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-100 mt-auto">
                                        <span class="text-dark font-bold text-base tracking-wide">Rp {{ number_format($item->price * 1000, 0, ',', '.') }}</span>
                                        
                                        @if($item->daily_stock > 0)
                                        <form action="{{ url('/cart/add') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" onclick="addToCart(this)" class="bg-secondary text-primary hover:bg-primary hover:text-white rounded-full p-2.5 transition-colors shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </button>
                                        </form>
                                        @else
                                        <button disabled class="bg-gray-100 text-gray-400 rounded-full p-2.5 cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 font-light text-sm italic">Belum ada produk kue.</p>
                    @endif
                </div>

                <!-- Section Lilin & Aksesoris -->
                <div>
                    <h2 class="font-serif text-3xl font-bold text-dark mb-6">Lilin & Aksesoris</h2>
                    @if($accessories->count() > 0)
                        <div class="horizontal-grid grid-rows-1" id="lilinGrid">
                            @foreach($accessories as $index => $item)
                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 group border border-gray-100 overflow-hidden flex flex-col h-[420px]" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                <a href="{{ url('/shop/' . $item->slug) }}" class="relative h-48 overflow-hidden block flex-shrink-0">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700 pointer-events-none">
                                    @if($item->daily_stock <= 0)
                                        <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] flex items-center justify-center">
                                            <span class="bg-dark text-white px-3 py-1.5 rounded-full text-[10px] font-bold tracking-widest uppercase">Habis Terjual</span>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="text-[10px] text-primary font-bold tracking-widest uppercase mb-1">{{ $item->category->name }}</div>
                                    <a href="{{ url('/shop/' . $item->slug) }}" class="block mb-1">
                                        <h4 class="font-serif font-bold text-lg text-dark group-hover:text-primary transition-colors line-clamp-1">{{ $item->name }}</h4>
                                    </a>
                                    <p class="text-gray-500 text-xs font-light line-clamp-2 mb-4 flex-grow">{{ $item->description }}</p>
                                    
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-100 mt-auto">
                                        <span class="text-dark font-bold text-base tracking-wide">Rp {{ number_format($item->price * 1000, 0, ',', '.') }}</span>
                                        
                                        @if($item->daily_stock > 0)
                                        <form action="{{ url('/cart/add') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="button" onclick="addToCart(this)" class="bg-secondary text-primary hover:bg-primary hover:text-white rounded-full p-2.5 transition-colors shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </button>
                                        </form>
                                        @else
                                        <button disabled class="bg-gray-100 text-gray-400 rounded-full p-2.5 cursor-not-allowed">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 font-light text-sm italic">Belum ada produk aksesoris / lilin.</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>

<script>
    // Add drag to scroll functionality
    function makeScrollable(id) {
        const slider = document.getElementById(id);
        if(!slider) return;
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
            slider.style.cursor = 'grab';
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        makeScrollable('kueGrid');
        makeScrollable('lilinGrid');
    });
</script>

<script>
function addToCart(button) {
    const form = button.closest('form');
    const formData = new FormData(form);
    
    const productCard = button.closest('.group');
    const productImage = productCard ? productCard.querySelector('img') : null;
    const cartIcon = document.getElementById('cartIcon');

    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalContent;
        if(data.status === 'success') {
            if (productImage && cartIcon) {
                const imgClone = productImage.cloneNode();
                const rect = productImage.getBoundingClientRect();
                const cartRect = cartIcon.getBoundingClientRect();
                
                imgClone.style.position = 'fixed';
                imgClone.style.top = rect.top + 'px';
                imgClone.style.left = rect.left + 'px';
                imgClone.style.width = rect.width + 'px';
                imgClone.style.height = rect.height + 'px';
                imgClone.style.borderRadius = '50%';
                imgClone.style.objectFit = 'cover';
                imgClone.style.zIndex = '9999';
                imgClone.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                imgClone.style.opacity = '0.9';
                
                document.body.appendChild(imgClone);
                
                void imgClone.offsetWidth;
                
                setTimeout(() => {
                    imgClone.style.top = cartRect.top + 'px';
                    imgClone.style.left = cartRect.left + 'px';
                    imgClone.style.width = '24px';
                    imgClone.style.height = '24px';
                    imgClone.style.opacity = '0.1';
                }, 10);
                
                setTimeout(() => {
                    imgClone.remove();
                    showToast(data.message, 'success');
                }, 800);
            } else {
                showToast(data.message, 'success');
            }
        } else {
            showToast(data.message, 'error');
            if(data.message.includes('login') || data.redirect) {
                window.location.href = '{{ url("/login") }}';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalContent;
    });
}
</script>
@endsection
