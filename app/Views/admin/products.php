<h1 class="text-3xl font-bold mb-8">Manajemen Produk</h1>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h2 class="text-xl font-bold mb-4">Tambah Produk Baru</h2>
    <form action="<?= BASE_URL ?>/admin/products/add" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-bold mb-2">Nama Kue</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Kategori</label>
            <select name="category_id" required class="w-full px-3 py-2 border rounded">
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Harga (Rp)</label>
            <input type="number" name="price" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Stok Harian</label>
            <input type="number" name="daily_stock" required class="w-full px-3 py-2 border rounded">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-bold mb-2">Pilih Gambar (JPG/PNG/WEBP)</label>
            <input type="file" name="image_file" accept="image/*" required class="w-full px-3 py-2 border rounded bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-pink-600 transition">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
        <div>
            <button type="submit" class="bg-primary hover:bg-pink-500 text-white font-bold py-2 px-6 rounded">Simpan Produk</button>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="py-3 px-4 text-sm font-bold">Produk</th>
                <th class="py-3 px-4 text-sm font-bold">Kategori</th>
                <th class="py-3 px-4 text-sm font-bold">Harga</th>
                <th class="py-3 px-4 text-sm font-bold">Stok</th>
                <th class="py-3 px-4 text-sm font-bold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $p): ?>
            <tr class="border-b">
                <td class="py-3 px-4 flex items-center space-x-3">
                    <img src="<?= htmlspecialchars($p['image_url']) ?>" class="w-10 h-10 object-cover rounded">
                    <span><?= htmlspecialchars($p['name']) ?></span>
                </td>
                <td class="py-3 px-4"><?= htmlspecialchars($p['category_name']) ?></td>
                <td class="py-3 px-4">Rp <?= number_format($p['price'] * 1000, 0, ',', '.') ?></td>
                <td class="py-3 px-4"><?= $p['daily_stock'] ?></td>
                <td class="py-3 px-4">
                    <form action="<?= BASE_URL ?>/admin/products/delete" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
