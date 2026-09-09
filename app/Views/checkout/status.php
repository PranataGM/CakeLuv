<div class="max-w-3xl mx-auto mt-20 mb-20 bg-white p-10 md:p-16 border border-gray-100 rounded-3xl shadow-2xl text-center relative overflow-hidden" data-aos="zoom-in">
    <!-- Decorative background -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-bl-full -mr-10 -mt-10"></div>
    <div class="absolute bottom-0 left-0 w-32 h-32 bg-gold/10 rounded-tr-full -ml-10 -mb-10"></div>

    <h2 class="font-serif text-4xl font-bold mb-4 text-dark relative z-10">Pesanan Diterima</h2>
    <p class="text-gray-500 mb-10 relative z-10">Terima kasih telah mempercayakan perayaan Anda pada kami.</p>
    
    <div class="mb-12 relative z-10">
        <p class="text-xs text-gray-400 font-bold tracking-widest uppercase mb-2">ID Pesanan</p>
        <p class="text-3xl font-bold text-primary tracking-wider"><?= $order['order_number'] ?></p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 text-left bg-secondary p-8 rounded-2xl relative z-10">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total Harga</p>
            <p class="font-bold text-dark">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pembayaran</p>
            <p class="font-bold uppercase text-xs px-2 py-1 inline-block rounded-md <?= $order['payment_status'] == 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' ?>"><?= $order['payment_status'] ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tgl Target</p>
            <p class="font-bold text-dark"><?= date('d M Y', strtotime($order['target_date'])) ?></p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Produksi</p>
            <p class="font-bold uppercase text-primary text-sm"><?= $order['production_status'] ?></p>
        </div>
    </div>

    <div class="relative z-10 flex flex-col items-center">
        <?php if($order['payment_status'] == 'pending' && $snap_token): ?>
            <p class="mb-6 text-gray-600">Satu langkah lagi untuk merayakan momen manis Anda.</p>
            <button id="pay-button" class="bg-dark hover:bg-black text-white font-bold py-4 px-12 rounded-full shadow-xl transition-all hover:-translate-y-1 uppercase tracking-widest text-sm flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Bayar Sekarang
            </button>
        <?php elseif($order['payment_status'] == 'paid'): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 p-6 rounded-2xl w-full">
                <svg class="w-12 h-12 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="font-bold text-lg mb-2">Pembayaran Sukses!</p>
                <p class="text-sm">Pesanan Anda sedang dalam antrean produksi kami.</p>
            </div>
        <?php endif; ?>

        <div class="mt-12">
            <a href="<?= BASE_URL ?>/" class="text-sm font-bold text-gray-400 hover:text-primary uppercase tracking-widest transition-colors border-b-2 border-transparent hover:border-primary pb-1">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</div>

<?php if($order['payment_status'] == 'pending' && $snap_token): ?>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= MIDTRANS_CLIENT_KEY ?>"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('<?= $snap_token ?>', {
            onSuccess: function(result){
                // Fallback untuk local demo tanpa ngrok
                fetch('<?= BASE_URL ?>/checkout/finishLocalPayment', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'order_number=<?= $order['order_number'] ?>'
                }).then(() => {
                    alert("Pembayaran Berhasil!");
                    window.location.reload();
                });
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                alert("Pembayaran Gagal!");
            },
            onClose: function(){
                console.log('User menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    };
</script>
<?php endif; ?>
