<div class="max-w-md mx-auto mt-16 bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-center mb-6">Verifikasi Email</h2>
    <p class="text-sm text-gray-500 mb-6 text-center">Masukkan 6 digit kode OTP yang telah dikirimkan ke email Anda.</p>
    
    <form action="<?= BASE_URL ?>/verify" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Verifikasi / OTP</label>
            <input type="text" name="token" required class="w-full px-3 py-3 border rounded-lg focus:outline-none focus:border-primary text-center tracking-widest text-lg font-bold" maxlength="6" placeholder="XXXXXX">
        </div>
        <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-3 px-4 rounded-lg transition uppercase tracking-wider text-sm">Verifikasi Sekarang</button>
    </form>
</div>
