@extends('layouts.app')

@section('content')
<!-- HERO SECTION -->
<div class="relative bg-secondary overflow-hidden min-h-[80vh] flex items-center">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-primary/10 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-gold/10 blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10 flex flex-col md:flex-row items-center py-16">
        <div class="md:w-1/2" data-aos="fade-right">
            <h2 class="text-xs font-bold text-primary uppercase tracking-[0.2em] mb-4 flex items-center">
                <span class="w-8 h-px bg-primary mr-3"></span> Patisserie Premium
            </h2>
            <h1 class="font-serif text-5xl md:text-6xl font-extrabold text-dark leading-tight mb-6">
                Seni Rasa dalam <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-gold italic">Setiap Gigitan.</span>
            </h1>
            <p class="text-gray-600 text-lg mb-10 font-light max-w-lg leading-relaxed">
                Kue yang diracik dengan sempurna untuk merayakan momen tak terlupakan. Dibuat dengan bahan premium dan desain elegan.
            </p>
            <div class="flex space-x-6 items-center">
                <a href="{{ url('/shop') }}" class="bg-primary hover:bg-primary_hover text-white font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-[0_10px_20px_rgba(197,131,124,0.3)] hover:shadow-[0_15px_30px_rgba(197,131,124,0.4)] hover:-translate-y-1 tracking-wide">LIHAT KATALOG</a>
            </div>
        </div>
        <div class="md:w-1/2 mt-12 md:mt-0 relative" data-aos="fade-left" data-aos-delay="200">
            <div class="relative w-full max-w-md mx-auto aspect-[4/5] rounded-t-full overflow-hidden shadow-2xl border-8 border-white bg-white">
                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&h=1000&fit=crop" alt="Signature Cake" class="object-cover w-full h-full hover:scale-105 transition-transform duration-700">
            </div>
            <div class="absolute bottom-10 -left-10 bg-white p-4 rounded-xl shadow-xl animate-bounce">
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Same Day</p>
                <p class="text-primary font-serif font-bold italic text-lg">Delivery</p>
            </div>
        </div>
    </div>
</div>

<!-- BEST SELLERS -->
<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
<div class="bg-white py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <p class="text-primary text-sm font-bold tracking-[0.2em] uppercase mb-2">Pilihan Favorit</p>
            <h3 class="font-serif text-4xl font-bold text-dark">Koleksi Terlaris</h3>
        </div>
        
        <div id="bestSellersSlider" class="flex overflow-x-auto gap-8 pb-10 pt-4 hide-scrollbar cursor-grab active:cursor-grabbing">
            @foreach($best_sellers as $index => $item)
            <div class="flex-shrink-0 w-72 md:w-80 bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 group border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="relative h-64 overflow-hidden">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary tracking-wider uppercase">Best Seller</div>
                </div>
                <div class="p-6">
                    <h4 class="font-serif font-bold text-xl text-dark mb-2 group-hover:text-primary transition-colors">{{ $item->name }}</h4>
                    <p class="text-gray-500 text-sm font-light line-clamp-2 mb-4">{{ $item->description }}</p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                        <span class="text-dark font-bold text-lg tracking-wide">Rp {{ number_format($item->price * 1000, 0, ',', '.') }}</span>
                        
                        <form action="{{ url('/cart/add') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="button" onclick="addToCart(this)" class="bg-secondary text-primary hover:bg-primary hover:text-white rounded-full p-3 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12" data-aos="fade-up">
            <a href="{{ url('/shop') }}" class="inline-flex items-center text-primary font-bold tracking-widest uppercase hover:text-dark transition-colors border-b-2 border-primary pb-1 hover:border-dark">
                Lihat Semua Koleksi &rarr;
            </a>
        </div>
    </div>
</div>

<!-- ABOUT & OTHERS (Simplified for brevity but identical in UI) -->
<div id="about" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center gap-16">
            <div class="md:w-1/2 relative" data-aos="zoom-in-up">
                <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=800&h=600&fit=crop" alt="Bakery Process" class="rounded-2xl shadow-2xl">
                <div class="absolute -bottom-8 -right-8 bg-primary text-white p-8 rounded-lg shadow-xl text-center hidden md:block">
                    <p class="text-4xl font-serif font-bold">10+</p>
                    <p class="text-sm font-light tracking-widest uppercase mt-1">Tahun<br>Pengalaman</p>
                </div>
            </div>
            <div class="md:w-1/2" data-aos="fade-up" data-aos-delay="200">
                <h3 class="font-serif text-3xl md:text-4xl font-bold text-dark mb-6">Tentang <span class="text-primary italic">Kisah Kami</span></h3>
                <p class="text-gray-600 font-light leading-relaxed mb-6">
                    CakeLuv bermula dari dapur kecil yang dipenuhi aroma mentega hangat dan gula karamel. Kami percaya bahwa setiap perayaan layak mendapatkan lebih dari sekadar kue biasa; ia membutuhkan mahakarya rasa.
                </p>
                <p class="text-gray-600 font-light leading-relaxed mb-8">
                    Dengan komitmen menggunakan 100% bahan natural berkualitas premium, cokelat Belgia asli, dan tanpa pengawet buatan, kami terus menciptakan kenangan manis yang berkesan di hati pelanggan kami. Setiap lapisan dipanggang dengan cinta.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- HIGHLIGHT SECTION -->
<div class="py-16 bg-secondary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div data-aos="fade-up" class="p-6">
                <svg class="w-12 h-12 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">Dibuat Harian</h4>
                <p class="text-sm text-gray-500 font-light">Selalu segar dari oven setiap pagi.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="p-6">
                <svg class="w-12 h-12 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">Bahan Premium</h4>
                <p class="text-sm text-gray-500 font-light">Kualitas terbaik tanpa kompromi.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="p-6">
                <svg class="w-12 h-12 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">100% Halal</h4>
                <p class="text-sm text-gray-500 font-light">Disertifikasi untuk kenyamanan Anda.</p>
            </div>
        </div>
    </div>
</div>

<!-- PATISSIER SECTION -->
<div class="py-24 bg-white border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col-reverse md:flex-row items-center gap-16">
            <div class="md:w-1/2" data-aos="fade-right">
                <h3 class="font-serif text-3xl md:text-4xl font-bold text-dark mb-2">Chef <span class="text-primary italic">Renatta</span></h3>
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Head Patissier</p>
                <p class="text-gray-600 font-light leading-relaxed mb-6">
                    Membawa pengalaman lebih dari 15 tahun dari dapur patisserie ternama di Paris, Chef Renatta memadukan teknik klasik Prancis dengan cita rasa nusantara. 
                </p>
                <p class="text-gray-600 font-light leading-relaxed mb-8">
                    "Setiap kue adalah medium seni untuk menceritakan sebuah kisah rasa yang abadi."
                </p>
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Signature_Example.png" alt="Signature" class="h-12 opacity-50 grayscale">
            </div>
            <div class="md:w-1/2 relative" data-aos="zoom-in-left">
                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&h=600&fit=crop" alt="Head Patissier" class="rounded-2xl shadow-2xl object-cover h-[500px] w-full border-4 border-white">
            </div>
        </div>
    </div>
</div>

<!-- CONTACT SECTION -->
<div id="contact" class="py-24 bg-dark text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="text-center mb-12">
            <h3 class="font-serif text-3xl md:text-4xl font-bold mb-6">Hubungi <span class="text-primary italic">Kami</span></h3>
            <p class="text-gray-400 font-light max-w-2xl mx-auto">Ada pesanan khusus atau pertanyaan? Kunjungi toko kami atau hubungi tim kami.</p>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-12 items-stretch">
            
            <!-- Contact Info -->
            <div class="lg:w-1/3 flex flex-col gap-6">
                <div class="bg-white/5 p-8 rounded-2xl border border-gray-700 hover:bg-white/10 transition flex-1 flex flex-col justify-center items-center text-center">
                    <svg class="w-8 h-8 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <h5 class="font-bold mb-2">Lokasi</h5>
                    <p class="text-sm text-gray-400 font-light">London Bakery & Cake<br>Kebon Agung</p>
                </div>
                <div class="bg-white/5 p-8 rounded-2xl border border-gray-700 hover:bg-white/10 transition flex-1 flex flex-col justify-center items-center text-center">
                    <svg class="w-8 h-8 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <h5 class="font-bold mb-2">Telepon</h5>
                    <p class="text-sm text-gray-400 font-light">+62 812-3456-7890</p>
                </div>
                <div class="bg-white/5 p-8 rounded-2xl border border-gray-700 hover:bg-white/10 transition flex-1 flex flex-col justify-center items-center text-center">
                    <svg class="w-8 h-8 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <h5 class="font-bold mb-2">Email</h5>
                    <p class="text-sm text-gray-400 font-light">hello@cakeluv.com</p>
                </div>
            </div>

            <!-- Maps iframe -->
            <div class="lg:w-2/3 h-[500px] rounded-2xl overflow-hidden shadow-xl border border-gray-700">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17893.321667423934!2d110.34309729229126!3d-7.745714278271933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59c30ef26b91%3A0xf5da7f9635877fe4!2sLondon%20Bakery%20%26%20Cake%20Kebon%20Agung!5e1!3m2!1sid!2sid!4v1789319856441!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>

        </div>
    </div>
</div>

<script>
function addToCart(button) {
    const form = button.closest('form');
    const formData = new FormData(form);
    
    // Find image to fly
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
            
            // Animation logic
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
                
                // Trigger reflow
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

document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById('bestSellersSlider');
    if (!slider) return;
    let isDown = false, startX, scrollLeft;

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('cursor-grabbing');
        slider.classList.remove('cursor-grab');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
    });
    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
    });
    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        slider.scrollLeft = scrollLeft - (x - startX) * 2;
    });
});
</script>
@endsection
