<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
                <li class="inline-flex items-center">
                    <a href="<?= BASE_URL ?>/" class="hover:text-primary transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="<?= BASE_URL ?>/shop" class="hover:text-primary transition-colors">Katalog</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="text-gray-400"><?= htmlspecialchars($product['name']) ?></span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-16 items-start">
            
            <!-- Gambar Produk -->
            <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-gray-50 aspect-square group" data-aos="fade-right">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700">
                <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full text-xs font-bold text-gray-600 tracking-wider uppercase shadow-sm">
                    <?= htmlspecialchars($product['category_name']) ?>
                </div>
            </div>
            
            <!-- Info Produk -->
            <div class="flex flex-col h-full justify-center" data-aos="fade-left">
                <p class="text-primary text-sm font-bold tracking-[0.2em] uppercase mb-2">CakeLuv Signature</p>
                <h1 class="font-serif text-4xl lg:text-5xl font-bold text-dark mb-4 leading-tight">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>
                
                <div class="mb-6">
                    <span class="text-3xl font-bold text-dark">Rp <?= number_format($product['price'] * 1000, 0, ',', '.') ?></span>
                </div>
                
                <div class="prose prose-sm md:prose-base text-gray-600 font-light mb-8 leading-relaxed">
                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
                
                <div class="flex items-center space-x-4 mb-8 pb-8 border-b border-gray-100">
                    <div class="flex items-center text-sm font-bold <?= $product['daily_stock'] > 0 ? 'text-green-600' : 'text-red-500' ?>">
                        <span class="w-3 h-3 rounded-full mr-2 <?= $product['daily_stock'] > 0 ? 'bg-green-500' : 'bg-red-500' ?>"></span>
                        <?= $product['daily_stock'] > 0 ? "Tersedia ({$product['daily_stock']} stok harian)" : 'Stok Habis' ?>
                    </div>
                </div>
                
                <form action="<?= BASE_URL ?>/cart/add" method="POST" class="mt-auto" id="addCartForm">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <?php if($product['daily_stock'] > 0): ?>
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan Khusus (Opsional)</label>
                        <input type="text" name="custom_message" maxlength="100" value="<?= isset($cart_item) ? htmlspecialchars($cart_item['custom_message'] ?? '') : '' ?>" placeholder="Misal: Tulisan HBD, Lilin Angka 2" class="w-full bg-gray-50 border border-gray-200 text-dark rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all placeholder-gray-400">
                        <p class="text-[10px] text-gray-400 mt-1">*Maksimal 100 karakter.</p>
                    </div>
                    <?php endif; ?>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-1/3 relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Jumlah</label>
                            <input type="number" name="quantity" value="<?= isset($cart_item) ? htmlspecialchars($cart_item['quantity']) : '1' ?>" min="1" max="<?= $product['daily_stock'] ?>" class="w-full bg-gray-50 border border-gray-200 text-dark font-bold text-center rounded-xl py-4 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" <?= $product['daily_stock'] < 1 ? 'disabled' : '' ?>>
                        </div>
                        
                        <div class="w-full sm:w-2/3">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">&nbsp;</label>
                            <button type="button" onclick="addToCart(this)" class="w-full bg-dark hover:bg-black text-white font-bold py-4 px-8 rounded-xl shadow-xl transition-all hover:-translate-y-1 uppercase tracking-widest text-sm flex items-center justify-center disabled:opacity-50 disabled:hover:translate-y-0" <?= $product['daily_stock'] < 1 ? 'disabled' : '' ?>>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <span><?= isset($cart_item) ? 'Update Keranjang' : 'Masukkan Keranjang' ?></span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

<script>
function addToCart(button) {
    const form = document.getElementById('addCartForm');
    const formData = new FormData(form);
    const btnText = button.querySelector('span');
    const originalContent = btnText.innerHTML;
    
    btnText.innerHTML = 'Memproses...';
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btnText.innerHTML = originalContent;
        if(data.status === 'success') {
            // Langsung arahkan ke cart belanja
            window.location.href = '<?= BASE_URL ?>/cart';
        } else {
            alert('⚠️ ' + data.message);
            if(data.message.includes('login')) window.location.href = '<?= BASE_URL ?>/login';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btnText.innerHTML = originalContent;
    });
}
</script>
