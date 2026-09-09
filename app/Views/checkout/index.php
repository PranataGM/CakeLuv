<div class="max-w-6xl mx-auto mt-12 mb-20 grid grid-cols-1 lg:grid-cols-5 gap-12 px-4" data-aos="fade-up">
    <!-- Form Checkout -->
    <div class="lg:col-span-3 bg-white p-8 md:p-10 border border-gray-100 rounded-3xl shadow-xl">
        <h2 class="font-serif text-3xl font-bold mb-8 border-b-2 border-primary pb-4 inline-block">Detail Pengiriman</h2>
        
        <form action="<?= BASE_URL ?>/checkout/process" method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 tracking-wide uppercase">Tanggal Diinginkan</label>
                <input type="date" name="target_date" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
                <p class="text-xs text-gray-500 mt-2 italic">*Pesan minimal H-1 untuk hasil maksimal.</p>
            </div>
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2 tracking-wide uppercase">Metode Pengambilan</label>
                <div class="relative">
                    <select name="delivery_type" required class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" onchange="toggleAddress(this.value)">
                        <option value="pickup">Ambil di Toko (Pickup) - Gratis</option>
                        <option value="delivery">Kirim ke Alamat (Delivery)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>

            <div class="hidden transition-all duration-500 opacity-0" id="addressField">
                <label class="block text-gray-700 text-sm font-bold mb-2 tracking-wide uppercase">Alamat Lengkap</label>
                <textarea name="shipping_address" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" placeholder="Tuliskan alamat lengkap beserta patokan..."></textarea>
            </div>

            <div class="pt-8">
                <button type="submit" class="w-full bg-dark hover:bg-black text-white font-bold py-4 px-6 rounded-full transition-colors shadow-xl uppercase tracking-widest text-sm flex justify-center items-center">
                    <span>Selesaikan Pembayaran</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Ringkasan Pesanan -->
    <div class="lg:col-span-2">
        <div class="bg-secondary p-8 rounded-3xl border border-gray-100 shadow-sm sticky top-28">
            <h3 class="font-serif text-2xl font-bold mb-8">Ringkasan Pesanan</h3>
            
            <div class="space-y-6 mb-8 max-h-[40vh] overflow-y-auto pr-2">
                <?php foreach($items as $item): ?>
                    <div class="flex items-start justify-between border-b border-gray-200 pb-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="<?= htmlspecialchars($item['image_url']) ?>" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-sm text-dark"><?= htmlspecialchars($item['name']) ?></p>
                                <p class="text-xs text-gray-500 mt-1">Qty: <?= $item['quantity'] ?></p>
                                <?php if($item['custom_message']): ?>
                                    <p class="text-xs text-primary font-medium mt-1">"<?= htmlspecialchars($item['custom_message']) ?>"</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <span class="font-bold text-dark text-sm">Rp <?= number_format(($item['price'] * 1000) * $item['quantity'], 0, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center text-gray-500 mb-2 text-sm">
                    <span>Subtotal</span>
                    <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-center text-gray-500 mb-4 text-sm border-b border-gray-100 pb-4">
                    <span>Pajak & Layanan</span>
                    <span>Termasuk</span>
                </div>
                <div class="flex justify-between items-end">
                    <span class="font-bold text-dark uppercase tracking-widest text-xs">Total Akhir</span>
                    <span class="font-serif text-2xl font-bold text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleAddress(val) {
    const field = document.getElementById('addressField');
    if(val === 'delivery') {
        field.classList.remove('hidden');
        // A little timeout to allow display:block to apply before animating opacity
        setTimeout(() => field.classList.remove('opacity-0'), 10);
        field.querySelector('textarea').required = true;
    } else {
        field.classList.add('opacity-0');
        setTimeout(() => field.classList.add('hidden'), 500); // Wait for transition
        field.querySelector('textarea').required = false;
    }
}
</script>
