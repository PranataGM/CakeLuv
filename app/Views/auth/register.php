<div class="max-w-md mx-auto mt-16 bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-center mb-6">Daftar Akun Baru</h2>
    
    <form action="<?= BASE_URL ?>/register" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">No. Handphone</label>
            <input type="text" name="phone" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        <button type="submit" class="w-full bg-primary hover:bg-pink-500 text-white font-bold py-2 px-4 rounded-lg transition">Daftar</button>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">Sudah punya akun? <a href="<?= BASE_URL ?>/login" class="text-primary hover:underline">Login di sini</a>.</p>
</div>
