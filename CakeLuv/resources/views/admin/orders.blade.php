@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-500 text-xs font-bold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">No. Pesanan</th>
                    <th class="px-6 py-4 text-left">Pelanggan</th>
                    <th class="px-6 py-4 text-left">Total</th>
                    <th class="px-6 py-4 text-center">Tipe Pengiriman</th>
                    <th class="px-6 py-4 text-center">Status Pembayaran</th>
                    <th class="px-6 py-4 text-center">Status Produksi</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold text-gray-800">{{ $order->order_number }}<br><span class="text-xs text-gray-400 font-normal">{{ $order->created_at ? $order->created_at->format('d M Y, H:i') : '-' }}</span></td>
                    <td class="px-6 py-4">{{ $order->user->name ?? 'Guest' }}<br><span class="text-xs text-gray-400">{{ $order->user->email ?? '' }}</span></td>
                    <td class="px-6 py-4 font-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center uppercase text-xs font-bold tracking-wider">{{ $order->delivery_type }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ strtoupper($order->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            {{ strtoupper($order->production_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button onclick="openModal('modal-{{ $order->id }}')" class="text-primary hover:text-primary_hover font-bold text-xs uppercase tracking-wider">Update</button>
                    </td>
                </tr>

                <!-- Modal Update Status -->
                <div id="modal-{{ $order->id }}" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white rounded-2xl w-full max-w-md overflow-hidden shadow-2xl transform transition-all">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-lg text-gray-800">Update Pesanan {{ $order->order_number }}</h3>
                            <button onclick="closeModal('modal-{{ $order->id }}')" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="p-6">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status Pembayaran</label>
                                <select name="payment_status" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                                    <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="expired" {{ $order->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status Produksi</label>
                                <select name="production_status" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                                    <option value="waiting" {{ $order->production_status == 'waiting' ? 'selected' : '' }}>Waiting</option>
                                    <option value="processing" {{ $order->production_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="ready" {{ $order->production_status == 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="completed" {{ $order->production_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->production_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" onclick="closeModal('modal-{{ $order->id }}')" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-bold transition">Batal</button>
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary hover:bg-primary_hover text-white font-bold transition">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $orders->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endpush
