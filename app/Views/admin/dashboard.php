<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Analitik</h1>
    <span class="bg-primary/10 text-primary font-bold px-4 py-2 rounded-lg text-sm">Overview Hari Ini</span>
</div>

<!-- TOP CARDS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
        <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
            <p class="text-2xl font-bold text-gray-800"><?= $total_orders ?></p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
        <div class="p-3 bg-green-50 text-green-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Pendapatan Bersih</p>
            <p class="text-2xl font-bold text-gray-800">Rp <?= number_format($total_revenue, 0, ',', '.') ?></p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
        <div class="p-3 bg-purple-50 text-purple-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Kue Terjual</p>
            <p class="text-2xl font-bold text-gray-800">
                <?php 
                $sold = 0; 
                foreach($top_products as $tp) $sold += $tp['total_sold']; 
                echo $sold; 
                ?>
            </p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center space-x-4">
        <div class="p-3 bg-orange-50 text-orange-500 rounded-xl">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-gray-500 text-sm font-medium">Pesanan Aktif</p>
            <p class="text-2xl font-bold text-gray-800">
                <?php 
                $active = 0;
                foreach($status_stats as $ss) if($ss['production_status'] != 'selesai') $active += $ss['count'];
                echo $active;
                ?>
            </p>
        </div>
    </div>
</div>

<!-- CHARTS SECTION -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Sales Chart -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Penjualan (7 Hari Terakhir)</h3>
        <canvas id="salesChart" height="120"></canvas>
    </div>
    
    <!-- Top Products Chart -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">5 Produk Terlaris</h3>
        <canvas id="productsChart" height="120"></canvas>
    </div>
</div>

<!-- RECENT ORDERS -->
<h2 class="text-xl font-bold mb-4 text-gray-800">Pesanan Masuk Terbaru</h2>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-4 px-6 text-xs uppercase font-bold text-gray-500 tracking-wider">Nomor Pesanan</th>
                    <th class="py-4 px-6 text-xs uppercase font-bold text-gray-500 tracking-wider">Pelanggan</th>
                    <th class="py-4 px-6 text-xs uppercase font-bold text-gray-500 tracking-wider">Total</th>
                    <th class="py-4 px-6 text-xs uppercase font-bold text-gray-500 tracking-wider">Pembayaran</th>
                    <th class="py-4 px-6 text-xs uppercase font-bold text-gray-500 tracking-wider">Status Produksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if(empty($orders)): ?>
                <tr><td colspan="5" class="py-8 text-center text-gray-500">Belum ada pesanan terbaru.</td></tr>
                <?php endif; ?>
                <?php foreach($orders as $o): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-4 px-6 font-medium text-primary"><?= $o['order_number'] ?></td>
                    <td class="py-4 px-6 text-gray-800"><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td class="py-4 px-6 font-bold text-gray-800">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 text-xs font-bold rounded-full <?= $o['payment_status'] == 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' ?>">
                            <?= strtoupper($o['payment_status']) ?>
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <span class="text-sm text-gray-600 font-medium capitalize"><?= str_replace('_', ' ', $o['production_status']) ?></span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- SCRIPTS FOR CHARTS -->
<?php
// Prepare data for JS
$sales_labels = [];
$sales_data = [];
foreach($sales_chart as $s) {
    $sales_labels[] = date('d M', strtotime($s['date']));
    $sales_data[] = $s['total'];
}

$prod_labels = [];
$prod_data = [];
foreach($top_products as $tp) {
    $prod_labels[] = $tp['name'];
    $prod_data[] = $tp['total_sold'];
}
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Colors
    const primaryColor = '#ff8fab';
    const primaryLight = 'rgba(255, 143, 171, 0.2)';

    // 1. Tren Penjualan Line Chart
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: <?= json_encode($sales_labels) ?>,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?= json_encode($sales_data) ?>,
                borderColor: primaryColor,
                backgroundColor: primaryLight,
                borderWidth: 3,
                pointBackgroundColor: primaryColor,
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    // 2. Top Products Bar Chart
    const ctxProd = document.getElementById('productsChart').getContext('2d');
    new Chart(ctxProd, {
        type: 'bar',
        data: {
            labels: <?= json_encode($prod_labels) ?>,
            datasets: [{
                label: 'Terjual',
                data: <?= json_encode($prod_data) ?>,
                backgroundColor: [
                    '#ff8fab', '#fb6f92', '#ffe5ec', '#ffc2d1', '#f9a8d4'
                ],
                borderRadius: 6,
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#f3f4f6' } },
                x: { grid: { display: false }, ticks: { font: { size: 10 } } }
            }
        }
    });
});
</script>
