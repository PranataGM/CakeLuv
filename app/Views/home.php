<?php
/**
 * @var array $best_sellers
 */
?>
<!-- HERO SECTION -->
<div class="relative bg-secondary overflow-hidden min-h-[80vh] flex items-center">
    <!-- Decorative background circle -->
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
                <a href="<?= BASE_URL ?>/shop" class="bg-primary hover:bg-primary_hover text-white font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-[0_10px_20px_rgba(197,131,124,0.3)] hover:shadow-[0_15px_30px_rgba(197,131,124,0.4)] hover:-translate-y-1 tracking-wide">LIHAT KATALOG</a>
            </div>
        </div>
        <div class="md:w-1/2 mt-12 md:mt-0 relative" data-aos="fade-left" data-aos-delay="200">
            <!-- Elegant Image Frame -->
            <div class="relative w-full max-w-md mx-auto aspect-[4/5] rounded-t-full overflow-hidden shadow-2xl border-8 border-white bg-white">
                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800&h=1000&fit=crop" alt="Signature Cake" class="object-cover w-full h-full hover:scale-105 transition-transform duration-700">
            </div>
            <!-- Floating Badge -->
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
            <?php foreach($best_sellers as $index => $item): ?>
            <div class="flex-shrink-0 w-72 md:w-80 bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 group border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                <div class="relative h-64 overflow-hidden">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-primary tracking-wider uppercase">Best Seller</div>
                </div>
                <div class="p-6">
                    <h4 class="font-serif font-bold text-xl text-dark mb-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($item['name']) ?></h4>
                    <p class="text-gray-500 text-sm font-light line-clamp-2 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                        <span class="text-dark font-bold text-lg tracking-wide">Rp <?= number_format($item['price'] * 1000, 0, ',', '.') ?></span>
                        
                        <form action="<?= BASE_URL ?>/cart/add" method="POST" class="inline">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="button" onclick="addToCart(this)" class="bg-secondary text-primary hover:bg-primary hover:text-white rounded-full p-3 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12" data-aos="fade-up">
            <a href="<?= BASE_URL ?>/shop" class="inline-flex items-center text-primary font-bold tracking-widest uppercase hover:text-dark transition-colors border-b-2 border-primary pb-1 hover:border-dark">
                Lihat Semua Koleksi &rarr;
            </a>
        </div>
    </div>
</div>

<!-- SECTION PROSES PEMESANAN (HOW IT WORKS) -->
<div class="py-24 bg-secondary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h3 class="font-serif text-3xl font-bold text-dark">Cara Memesan</h3>
            <p class="text-gray-500 mt-2 font-light">3 Langkah mudah untuk momen manis Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative">
            <!-- Line Connector (Hidden on Mobile) -->
            <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-gray-200 z-0"></div>
            
            <!-- Step 1 -->
            <div class="text-center relative z-10" data-aos="fade-up" data-aos-delay="0">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-secondary mb-6 text-primary hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                </div>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">1. Pilih Kue & Tanggal</h4>
                <p class="text-gray-500 text-sm font-light px-4">Telusuri katalog kami, pilih varian rasa, lalu tentukan tanggal dan metode pengambilan.</p>
            </div>
            <!-- Step 2 -->
            <div class="text-center relative z-10" data-aos="fade-up" data-aos-delay="100">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-secondary mb-6 text-primary hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">2. Pembayaran Aman</h4>
                <p class="text-gray-500 text-sm font-light px-4">Selesaikan pembayaran secara otomatis & aman dengan berbagai metode dari Midtrans.</p>
            </div>
            <!-- Step 3 -->
            <div class="text-center relative z-10" data-aos="fade-up" data-aos-delay="200">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center shadow-lg border-4 border-secondary mb-6 text-primary hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <h4 class="font-serif font-bold text-xl text-dark mb-2">3. Kue Siap Dinikmati</h4>
                <p class="text-gray-500 text-sm font-light px-4">Kue Anda akan diproduksi dalam kondisi paling segar dan siap untuk melengkapi acara Anda.</p>
            </div>
        </div>
    </div>
</div>

<!-- ABOUT SECTION -->
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

<!-- CHEF / OWNER SECTION -->
<div class="py-20 bg-secondary relative overflow-hidden">
    <!-- Dekorasi aksen -->
    <div class="absolute top-1/4 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-center gap-16">
            <!-- Text Content -->
            <div class="md:w-1/2 order-2 md:order-1" data-aos="fade-right">
                <p class="text-primary text-sm font-bold tracking-[0.2em] uppercase mb-2">Sosok di Balik CakeLuv</p>
                <h3 class="font-serif text-3xl md:text-4xl font-bold text-dark mb-2">Chef Isabella Ren</h3>
                <h4 class="text-gray-500 italic mb-6">Head Pastry Chef & Founder</h4>
                
                <p class="text-gray-600 font-light leading-relaxed mb-6">
                    Lulusan Le Cordon Bleu Paris, Chef Isabella membawa teknik patisserie klasik Prancis dan memadukannya dengan sentuhan cita rasa modern. Dengan filosofi bahwa setiap kue adalah karya seni yang bisa dinikmati, ia memastikan standar kualitas terbaik.
                </p>
                <div class="border-l-4 border-primary pl-6 my-8">
                    <p class="text-gray-800 font-serif italic text-lg leading-relaxed">
                        "Bagi saya, membuat kue bukan sekadar menakar bahan, melainkan menakar kebahagiaan yang akan dibagikan di setiap senyum perayaan."
                    </p>
                </div>
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Signature_of_John_Hancock.svg" class="h-10 opacity-60" alt="Chef Signature">
            </div>
            
            <!-- Chef Image -->
            <div class="md:w-1/2 order-1 md:order-2" data-aos="fade-left">
                <div class="relative w-full max-w-sm mx-auto aspect-[3/4] rounded-t-full rounded-b-2xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                    <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?w=600&h=800&fit=crop" alt="Chef Isabella Ren" class="object-cover w-full h-full hover:scale-105 transition-transform duration-700">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTACT SECTION -->
<div id="contact" class="py-24 bg-white relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute top-1/2 left-0 w-64 h-64 bg-secondary rounded-full -translate-x-1/2 -translate-y-1/2 z-0"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-dark text-white rounded-3xl overflow-hidden shadow-2xl flex flex-col lg:flex-row" data-aos="fade-up">
            <!-- Contact Info -->
            <div class="lg:w-1/2 p-12 md:p-16 flex flex-col justify-center bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]">
                <h3 class="font-serif text-3xl font-bold mb-8 text-gold">Kunjungi Kami</h3>
                
                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="bg-white/10 p-3 rounded-full mr-4 text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold tracking-wider text-sm mb-1 text-white">LOKASI PATISSERIE</p>
                            <p class="text-gray-400 font-light leading-relaxed">Jl. Sudirman No. 123, Kebayoran Baru<br>Jakarta Selatan, Indonesia 12190</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white/10 p-3 rounded-full mr-4 text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold tracking-wider text-sm mb-1 text-white">EMAIL</p>
                            <p class="text-gray-400 font-light">hello@cakeluv.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white/10 p-3 rounded-full mr-4 text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold tracking-wider text-sm mb-1 text-white">WHATSAPP / TELEPON</p>
                            <p class="text-gray-400 font-light">+62 812 3456 7890</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="inline-block mt-3 bg-green-500 hover:bg-green-600 text-white text-xs font-bold px-4 py-2 rounded-full transition-colors">Chat via WhatsApp</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Google Maps -->
            <div class="lg:w-1/2 h-80 lg:h-auto min-h-[400px]">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17918.61046547494!2d110.32850872238001!3d-7.750900299999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59e047e4c947%3A0x59b9c48a46a1488c!2sKenes%20Bakery%20Jl.%20Kabupaten!5e1!3m2!1sid!2sid!4v1788937730979!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
function addToCart(button) {
    const form = button.closest('form');
    const formData = new FormData(form);
    
    // Add brief loading state to button
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalContent;
        if(data.status === 'success') {
            if(typeof showToast === 'function') {
                showToast(data.message, 'success');
            } else {
                alert('🎂 ' + data.message); 
            }
        } else {
            if(typeof showToast === 'function') {
                showToast(data.message, 'error');
            } else {
                alert('⚠️ ' + data.message);
            }
            if(data.message.includes('login')) {
                window.location.href = '<?= BASE_URL ?>/login';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalContent;
    });
}

// Drag to Scroll & Auto Scroll for Best Sellers
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.getElementById('bestSellersSlider');
    if (!slider) return;

    let isDown = false;
    let startX;
    let scrollLeft;
    let autoScrollInterval;
    let isHovering = false;

    // --- Drag to Scroll ---
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.classList.add('cursor-grabbing');
        slider.classList.remove('cursor-grab');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        pauseAutoScroll();
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
        isHovering = false;
        startAutoScroll();
    });

    slider.addEventListener('mouseenter', () => {
        isHovering = true;
        pauseAutoScroll();
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
        if(!isHovering) startAutoScroll();
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // Scroll-fast multiplier
        slider.scrollLeft = scrollLeft - walk;
    });

    // Mobile touch support
    slider.addEventListener('touchstart', () => pauseAutoScroll(), {passive: true});
    slider.addEventListener('touchend', () => startAutoScroll(), {passive: true});

    // --- Auto Scroll Secara Perlahan ---
    function startAutoScroll() {
        if(autoScrollInterval) clearInterval(autoScrollInterval);
        autoScrollInterval = setInterval(() => {
            // Jika sudah mentok ke kanan, reset ke awal
            if(slider.scrollLeft >= (slider.scrollWidth - slider.clientWidth - 1)) {
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                slider.scrollLeft += 1;
            }
        }, 30); // Kecepatan scroll perlahan (semakin kecil interval, semakin cepat)
    }

    function pauseAutoScroll() {
        clearInterval(autoScrollInterval);
    }

    // Mulai auto scroll
    startAutoScroll();
});
</script>
