<div class="bg-secondary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
        <h1 class="font-serif text-4xl md:text-5xl font-bold text-dark mb-4">Katalog Kami</h1>
        <p class="text-gray-600 max-w-2xl mx-auto font-light">Temukan beragam pilihan mahakarya rasa untuk setiap perayaan Anda, mulai dari kue elegan hingga aksesoris pesta.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- SECTION KUE -->
    <div class="mb-16">
        <div class="flex items-center justify-between mb-8" data-aos="fade-right">
            <h2 class="font-serif text-3xl font-bold text-dark border-l-4 border-primary pl-4">Koleksi Kue Premium</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach($cakes as $index => $item): ?>
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group border border-gray-100 flex flex-col overflow-hidden" data-aos="fade-up" data-aos-delay="<?= ($index % 4) * 100 ?>">
                <div class="relative h-64 overflow-hidden bg-gray-50 flex-shrink-0">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-600 tracking-wider uppercase"><?= htmlspecialchars($item['category_name']) ?></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="font-serif font-bold text-xl text-dark mb-2 group-hover:text-primary transition-colors"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-gray-500 text-sm font-light line-clamp-3 mb-6 flex-grow"><?= htmlspecialchars($item['description']) ?></p>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100 mt-auto">
                        <span class="text-dark font-bold text-lg tracking-wide">Rp <?= number_format($item['price'] * 1000, 0, ',', '.') ?></span>
                        <form action="<?= BASE_URL ?>/cart/add" method="POST" class="inline">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="button" onclick="addToCart(this)" class="bg-secondary text-primary hover:bg-primary hover:text-white rounded-full p-3 transition-colors shadow-sm" <?= $item['daily_stock'] < 1 ? 'disabled' : '' ?>>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- SECTION LILIN & AKSESORIS -->
    <?php if(!empty($accessories)): ?>
    <div class="pt-8 border-t border-gray-100">
        <div class="flex items-center justify-between mb-8" data-aos="fade-right">
            <h2 class="font-serif text-3xl font-bold text-dark border-l-4 border-gold pl-4">Lilin & Aksesoris</h2>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
            <?php foreach($accessories as $index => $item): ?>
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 group border border-gray-100 flex flex-col overflow-hidden" data-aos="zoom-in" data-aos-delay="<?= ($index % 5) * 50 ?>">
                <div class="relative h-48 overflow-hidden bg-gray-50 flex-shrink-0">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="object-cover w-full h-full group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="font-bold text-sm text-dark mb-1 group-hover:text-gold transition-colors line-clamp-2"><?= htmlspecialchars($item['name']) ?></h3>
                    <p class="text-xs text-gray-500 font-light mb-4 line-clamp-2 flex-grow"><?= htmlspecialchars($item['description']) ?></p>
                    
                    <div class="flex flex-col gap-2 pt-3 border-t border-gray-50 mt-auto">
                        <span class="text-dark font-bold text-sm tracking-wide">Rp <?= number_format($item['price'] * 1000, 0, ',', '.') ?></span>
                        <form action="<?= BASE_URL ?>/cart/add" method="POST" class="w-full">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="button" onclick="addToCart(this)" class="w-full bg-secondary text-primary hover:bg-gold hover:text-white text-xs font-bold rounded-lg py-2 transition-colors shadow-sm uppercase tracking-wider" <?= $item['daily_stock'] < 1 ? 'disabled' : '' ?>>
                                Tambah
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function addToCart(button) {
    const form = button.closest('form');
    const formData = new FormData(form);
    
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 mx-auto animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
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
                alert('🛒 ' + data.message); 
            }
        } else {
            if(typeof showToast === 'function') {
                showToast(data.message, 'error');
            } else {
                alert('⚠️ ' + data.message);
            }
            if(data.message.includes('login')) window.location.href = '<?= BASE_URL ?>/login';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalContent;
    });
}
</script>
