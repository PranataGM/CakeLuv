<div class="max-w-5xl mx-auto mt-12 mb-20 bg-white p-8 md:p-12 border border-gray-100 rounded-2xl shadow-xl" data-aos="fade-up">
    <h2 class="font-serif text-3xl font-bold mb-8 border-b-2 border-primary pb-4 inline-block">Keranjang Belanja</h2>

    <?php if(empty($items)): ?>
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            <p class="text-gray-500 font-light text-lg mb-6">Keranjang Anda masih kosong.</p>
            <a href="<?= BASE_URL ?>/shop" class="bg-dark hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-full transition shadow-lg tracking-widest uppercase text-sm">Mulai Belanja</a>
        </div>
    <?php else: ?>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <div class="lg:col-span-2">
            <form action="<?= BASE_URL ?>/cart/update" method="POST" id="cartForm">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="py-4 px-6 text-sm font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                                <th class="py-4 px-4 text-sm font-bold text-gray-400 uppercase tracking-wider">Harga</th>
                                <th class="py-4 px-4 text-sm font-bold text-gray-400 uppercase tracking-wider text-center">Qty</th>
                                <th class="py-4 px-4 text-sm font-bold text-gray-400 uppercase tracking-wider text-right">Subtotal</th>
                                <th class="py-4 px-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach($items as $item): ?>
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                <td class="py-6 px-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-20 h-20 rounded-xl overflow-hidden shadow-sm flex-shrink-0">
                                            <img src="<?= htmlspecialchars($item['image_url']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-serif font-bold text-lg text-dark mb-1"><?= htmlspecialchars($item['name']) ?></p>
                                            <a href="<?= BASE_URL ?>/product/<?= $item['slug'] ?>" class="text-xs text-primary font-bold tracking-wider uppercase hover:underline mb-2 inline-block">Edit Detail Produk &rarr;</a>
                                            <!-- INI KOLOM DESKRIPSI/CATATAN KUE (TAMPILAN SAJA) -->
                                            <?php if(!empty($item['custom_message'])): ?>
                                                <p class="text-sm text-gray-500 mt-1 italic">Catatan: <?= htmlspecialchars($item['custom_message']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-4 text-gray-600 font-medium">Rp <?= number_format($item['price'] * 1000, 0, ',', '.') ?></td>
                                <td class="py-6 px-4 text-center">
                                    <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="w-16 px-2 py-1 border border-gray-200 rounded-lg text-center focus:outline-none focus:border-primary bg-white font-bold text-dark">
                                </td>
                                <td class="py-6 px-4 font-bold text-dark text-right">Rp <?= number_format(($item['price'] * 1000) * $item['quantity'], 0, ',', '.') ?></td>
                                <td class="py-6 px-4 text-center">
                                    <a href="<?= BASE_URL ?>/cart/remove/<?= $item['id'] ?>" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                        <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" name="update_cart" value="1" class="text-sm font-bold text-gray-500 hover:text-primary transition-colors flex items-center bg-white border border-gray-200 py-2 px-6 rounded-full hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Update Keranjang & Catatan
                    </button>
                </div>
        </div>
        
        <!-- Ringkasan -->
        <div class="lg:col-span-1">
            <div class="bg-secondary p-8 rounded-3xl border border-gray-100 shadow-sm sticky top-28">
                <h3 class="font-serif text-2xl font-bold mb-6">Ringkasan</h3>
                <div class="flex justify-between items-center text-gray-600 mb-4 pb-4 border-b border-gray-200">
                    <span>Subtotal</span>
                    <span class="font-bold text-dark">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
                <div class="flex justify-between items-end mb-8">
                    <span class="font-bold uppercase tracking-widest text-xs text-gray-400">Total</span>
                    <span class="font-serif text-3xl font-bold text-primary">Rp <?= number_format($total, 0, ',', '.') ?></span>
                </div>
                
                <button type="submit" name="checkout" value="1" class="w-full bg-dark hover:bg-black text-white font-bold py-4 px-6 rounded-full shadow-xl transition-all hover:-translate-y-1 flex items-center justify-center uppercase tracking-widest text-sm">
                    Lanjut ke Pembayaran
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
                <p class="text-xs text-gray-400 text-center mt-4">Catatan Anda akan tersimpan otomatis saat checkout.</p>
            </div>
        </div>
        </form>
    </div>
    <?php endif; ?>
</div>
