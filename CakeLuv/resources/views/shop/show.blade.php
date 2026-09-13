@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="text-sm font-light text-gray-500 mb-10 tracking-wide" data-aos="fade-right">
            <a href="{{ url('/') }}" class="hover:text-primary transition">Beranda</a> 
            <span class="mx-2">/</span> 
            <a href="{{ url('/shop') }}" class="hover:text-primary transition">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-primary font-medium">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-20 border border-gray-100">
            <div class="flex flex-col md:flex-row">
                
                <!-- Product Image -->
                <div class="md:w-1/2 relative" data-aos="fade-right">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover min-h-[400px] md:min-h-[600px]">
                    @if($product->category->slug == 'best-sellers')
                        <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-xs font-bold text-primary tracking-wider uppercase shadow-lg">Best Seller</div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="md:w-1/2 p-8 md:p-14 flex flex-col justify-center" data-aos="fade-left">
                    <div class="text-xs text-primary font-bold tracking-widest uppercase mb-3">{{ $product->category->name }}</div>
                    <h1 class="font-serif text-4xl md:text-5xl font-bold text-dark mb-4 leading-tight">{{ $product->name }}</h1>
                    
                    <div class="flex items-center mb-6">
                        <span class="text-2xl font-bold text-primary tracking-wide">Rp {{ number_format($product->price * 1000, 0, ',', '.') }}</span>
                        <div class="ml-6 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $product->daily_stock > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $product->daily_stock > 0 ? 'Stok: ' . $product->daily_stock : 'Habis Terjual' }}
                        </div>
                    </div>

                    <div class="w-16 h-1 bg-primary/20 mb-8"></div>

                    <p class="text-gray-600 leading-relaxed font-light mb-10 text-lg">
                        {{ $product->description }}
                    </p>

                    @if($product->daily_stock > 0)
                        <form action="{{ url('/cart/add') }}" method="POST" id="addToCartForm" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-dark mb-3 uppercase tracking-wider">Kuantitas</label>
                                <div class="flex items-center border border-gray-200 rounded-full w-36 overflow-hidden">
                                    <button type="button" onclick="updateQty(-1)" class="w-12 h-12 flex justify-center items-center text-gray-500 hover:bg-gray-50 hover:text-primary transition font-bold text-lg">-</button>
                                    <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="{{ $product->daily_stock }}" class="w-12 h-12 text-center border-none focus:ring-0 text-dark font-bold bg-transparent" readonly>
                                    <button type="button" onclick="updateQty(1)" class="w-12 h-12 flex justify-center items-center text-gray-500 hover:bg-gray-50 hover:text-primary transition font-bold text-lg">+</button>
                                </div>
                            </div>
                            
                            <!-- Custom Message Field (for cakes usually) -->
                            @if(!in_array($product->category->slug, ['lilin-aksesoris']))
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-dark mb-3 uppercase tracking-wider">Pesan di Atas Kue <span class="text-gray-400 font-normal text-xs normal-case">(Opsional)</span></label>
                                <input type="text" name="custom_message" placeholder="Contoh: Happy Birthday Sarah" maxlength="30" class="w-full px-5 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light transition">
                                <p class="text-xs text-gray-400 mt-2 italic">Maksimal 30 karakter.</p>
                            </div>
                            @endif

                            <div class="flex space-x-4">
                                <button type="button" onclick="submitCart()" id="btnSubmitCart" class="flex-1 bg-primary hover:bg-primary_hover text-white font-bold py-4 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 tracking-wide flex justify-center items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    TAMBAH KE KERANJANG
                                </button>
                                <!-- WhatsApp Shortcut -->
                                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo CakeLuv, saya ingin memesan ' . $product->name . ' (Rp ' . number_format($product->price * 1000, 0, ',', '.') . ')') }}" target="_blank" class="w-14 h-14 rounded-full bg-green-500 hover:bg-green-600 text-white flex items-center justify-center shadow-lg transition-transform hover:-translate-y-1">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="mt-auto bg-gray-100 p-6 rounded-2xl border border-gray-200">
                            <h4 class="font-bold text-dark mb-2">Maaf, produk sedang kosong.</h4>
                            <p class="text-sm text-gray-500">Silakan kembali lagi esok hari atau lihat koleksi kami yang lain.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($related_products->count() > 0)
        <div class="mt-24" data-aos="fade-up">
            <h3 class="font-serif text-3xl font-bold text-dark mb-10 text-center">Mungkin Anda Juga Suka</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($related_products as $item)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 overflow-hidden">
                    <a href="{{ url('/shop/' . $item->slug) }}" class="relative h-48 overflow-hidden block">
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                    </a>
                    <div class="p-5">
                        <a href="{{ url('/shop/' . $item->slug) }}" class="block mb-2">
                            <h4 class="font-serif font-bold text-lg text-dark group-hover:text-primary transition-colors line-clamp-1">{{ $item->name }}</h4>
                        </a>
                        <div class="flex justify-between items-center mt-4">
                            <span class="text-dark font-bold tracking-wide">Rp {{ number_format($item->price * 1000, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<script>
function updateQty(change) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + change;
    const max = parseInt(input.getAttribute('max'));
    
    if (val < 1) val = 1;
    if (val > max) {
        val = max;
        showToast('Batas stok harian tercapai.', 'error');
    }
    
    input.value = val;
}

function submitCart() {
    const form = document.getElementById('addToCartForm');
    const formData = new FormData(form);
    const btn = document.getElementById('btnSubmitCart');
    
    const productImage = document.querySelector('img.object-cover.min-h-\\[400px\\]');
    const cartIcon = document.getElementById('cartIcon');
    
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MEMPROSES...';
    btn.disabled = true;
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(async response => {
        const data = await response.json();
        
        btn.innerHTML = originalContent;
        btn.disabled = false;
        
        if (data.status === 'success') {
            if (productImage && cartIcon) {
                const flyingImage = productImage.cloneNode(true);
                flyingImage.style.position = 'fixed';
                flyingImage.style.zIndex = '1000';
                flyingImage.style.width = '100px';
                flyingImage.style.height = '100px';
                flyingImage.style.borderRadius = '50%';
                flyingImage.style.objectFit = 'cover';
                
                const imgRect = productImage.getBoundingClientRect();
                flyingImage.style.left = imgRect.left + 'px';
                flyingImage.style.top = imgRect.top + 'px';
                flyingImage.style.transition = 'all 0.8s cubic-bezier(0.25, 1, 0.5, 1)';
                
                document.body.appendChild(flyingImage);
                
                const cartRect = cartIcon.getBoundingClientRect();
                
                requestAnimationFrame(() => {
                    flyingImage.style.left = (cartRect.left - 20) + 'px';
                    flyingImage.style.top = cartRect.top + 'px';
                    flyingImage.style.width = '20px';
                    flyingImage.style.height = '20px';
                    flyingImage.style.opacity = '0.5';
                });
                
                setTimeout(() => {
                    flyingImage.remove();
                    cartIcon.classList.add('animate-bounce');
                    setTimeout(() => cartIcon.classList.remove('animate-bounce'), 1000);
                    showToast(data.message, 'success');
                }, 800);
            } else {
                showToast(data.message, 'success');
            }
        } else if (data.status === 'closed') {
            openStoreModal();
        } else {
            showToast(data.message, 'error');
            if(data.message.includes('login') || data.redirect) {
                window.location.href = '{{ url("/login") }}';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerHTML = originalContent;
        btn.disabled = false;
    });
}
</script>
@endsection
