<div class="max-w-md mx-auto mt-16 bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-center mb-6">Login ke CakeLuv</h2>
    
    <form action="<?= BASE_URL ?>/login" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <div class="mb-6">
            <div class="flex justify-between mb-2">
                <label class="block text-gray-700 text-sm font-bold">Password</label>
                <a href="<?= BASE_URL ?>/forgot-password" class="text-sm text-primary hover:underline">Lupa Sandi?</a>
            </div>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <button type="submit" class="w-full bg-primary hover:bg-pink-500 text-white font-bold py-2 px-4 rounded-lg transition">Login</button>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">Belum punya akun? <a href="<?= BASE_URL ?>/register" class="text-primary hover:underline">Daftar sekarang</a>.</p>
</div>
