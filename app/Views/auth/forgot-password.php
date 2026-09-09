<div class="max-w-md mx-auto mt-16 bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-center mb-6">Lupa Sandi</h2>
    <p class="text-sm text-gray-500 mb-6 text-center">Masukkan email yang terdaftar untuk menerima kode reset.</p>
    
    <form action="<?= BASE_URL ?>/forgot-password" method="POST">
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email Terdaftar</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-3 px-4 rounded-lg transition uppercase tracking-wider text-sm">Kirim Kode Reset</button>
    </form>
    <div class="mt-4 text-center text-sm">
        <a href="<?= BASE_URL ?>/login" class="text-gray-500 hover:text-primary">&larr; Kembali ke Login</a>
    </div>
</div>
