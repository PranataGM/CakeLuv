<h1 class="text-3xl font-bold mb-8">Manajemen Pesanan</h1>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="py-3 px-4 text-sm font-bold">Order ID</th>
                <th class="py-3 px-4 text-sm font-bold">Pelanggan</th>
                <th class="py-3 px-4 text-sm font-bold">Tanggal Target</th>
                <th class="py-3 px-4 text-sm font-bold">Tipe</th>
                <th class="py-3 px-4 text-sm font-bold">Pembayaran</th>
                <th class="py-3 px-4 text-sm font-bold">Status Produksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $o): ?>
            <tr class="border-b">
                <td class="py-3 px-4"><?= $o['order_number'] ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($o['customer_name']) ?></td>
                <td class="py-3 px-4"><?= $o['target_date'] ?></td>
                <td class="py-3 px-4 uppercase text-xs"><?= $o['delivery_type'] ?></td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 text-xs font-bold rounded <?= $o['payment_status'] == 'paid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' ?>">
                        <?= $o['payment_status'] ?>
                    </span>
                </td>
                <td class="py-3 px-4">
                    <form action="<?= BASE_URL ?>/admin/orders/update-status" method="POST" class="flex items-center space-x-2">
                        <input type="hidden" name="order_id" value="<?= $o['id'] ?>">
                        <select name="status" class="border rounded px-2 py-1 text-sm text-gray-700">
                            <option value="waiting" <?= $o['production_status'] == 'waiting' ? 'selected' : '' ?>>Waiting</option>
                            <option value="baking" <?= $o['production_status'] == 'baking' ? 'selected' : '' ?>>Baking</option>
                            <option value="ready" <?= $o['production_status'] == 'ready' ? 'selected' : '' ?>>Ready</option>
                            <option value="completed" <?= $o['production_status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
