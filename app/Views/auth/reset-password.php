<div class="max-w-md mx-auto mt-16 bg-white p-8 border border-gray-200 rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold text-center mb-6">Buat Sandi Baru</h2>
    <p class="text-sm text-gray-500 mb-6 text-center">Masukkan kode reset dari email beserta sandi baru Anda.</p>
    
    <form action="<?= BASE_URL ?>/reset-password" method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Kode Reset</label>
            <input type="text" name="token" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary text-center tracking-widest font-bold" maxlength="6" placeholder="XXXXXX">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Sandi Baru</label>
            <input type="password" name="new_password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-primary">
        </div>
        
        <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-3 px-4 rounded-lg transition uppercase tracking-wider text-sm">Ubah Sandi</button>
    </form>
</div>
