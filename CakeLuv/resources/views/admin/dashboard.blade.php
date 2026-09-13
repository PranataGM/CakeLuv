@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Revenue -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-green-100 text-green-600 rounded-xl mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pendapatan</p>
            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-blue-100 text-blue-600 rounded-xl mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Total Pesanan</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-yellow-100 text-yellow-600 rounded-xl mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Menunggu Bayar</p>
            <p class="text-2xl font-bold text-gray-800">{{ $pendingOrders }}</p>
        </div>
    </div>

    <!-- Total Products -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
        <div class="p-4 bg-primary/20 text-primary rounded-xl mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium">Jumlah Produk</p>
            <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart -->
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-700 mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-700 mb-4">Pesanan Terbaru</h3>
        <div class="space-y-4">
            @forelse($recentOrders as $order)
            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-xl transition">
                <div>
                    <p class="font-bold text-sm text-gray-800">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-500">{{ $order->user->name ?? 'Guest' }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <span class="px-2 py-1 text-[10px] font-bold rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ strtoupper($order->payment_status) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 text-center py-4">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const labels = {!! $chartLabels !!};
    const data = {!! $chartData !!};
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#ff8fab',
                backgroundColor: 'rgba(255, 143, 171, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000) + 'k';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
