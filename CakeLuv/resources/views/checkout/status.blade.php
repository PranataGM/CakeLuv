@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen py-16 flex items-center justify-center">
    <div class="max-w-2xl w-full px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100" data-aos="zoom-in">
            <div class="bg-dark p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-primary/20 blur-3xl"></div>
                <div class="relative z-10">
                    <svg class="w-16 h-16 text-primary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h2 class="font-serif text-3xl font-bold text-white mb-2">Pesanan Dibuat!</h2>
                    <p class="text-gray-400 font-light text-sm">Nomor Pesanan: <span class="font-bold text-white tracking-widest">{{ $order->order_number }}</span></p>
                </div>
            </div>

            <div class="p-8 md:p-12 text-center">
                
                @if($order->payment_status == 'paid')
                    <div class="mb-8 inline-block bg-green-50 text-green-700 px-6 py-3 rounded-full font-bold text-sm tracking-wide">
                        Pembayaran Berhasil Diverifikasi
                    </div>
                    <p class="text-gray-600 mb-8 font-light leading-relaxed">
                        Terima kasih! Pesanan Anda sedang diproses dan masuk antrean produksi (Dapur: <span class="font-bold text-dark uppercase">{{ $order->production_status }}</span>). Kami akan mengirimkan notifikasi lebih lanjut.
                    </p>
                    <a href="{{ url('/profile') }}" class="inline-block bg-primary hover:bg-primary_hover text-white font-bold py-3 px-8 rounded-full transition-all shadow-lg text-sm uppercase tracking-wide">Lihat Pesanan Saya</a>
                
                @elseif($order->payment_status == 'pending')
                    <div class="mb-8 inline-block bg-yellow-50 text-yellow-700 px-6 py-3 rounded-full font-bold text-sm tracking-wide">
                        Menunggu Pembayaran
                    </div>
                    
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-200">
                        <p class="text-sm text-gray-500 mb-2 uppercase tracking-widest font-bold">Total Pembayaran</p>
                        <p class="font-serif text-4xl text-dark font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>

                    @if(str_starts_with($order->snap_token, 'MOCK_TOKEN'))
                        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-8 text-sm text-left border border-red-100">
                            <strong>Mode Lokal (Portfolio):</strong> Midtrans key belum diatur. Untuk simulasi pembayaran sukses, klik tombol di bawah.
                        </div>
                        <button onclick="finishMockPayment()" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-4 rounded-full transition-all shadow-lg text-sm uppercase tracking-wider mb-4">
                            SIMULASI BAYAR (MOCK)
                        </button>
                    @else
                        <button id="pay-button" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-4 rounded-full transition-all shadow-lg text-sm uppercase tracking-wider mb-4">
                            Lanjutkan Pembayaran
                        </button>
                    @endif
                    
                    <a href="{{ url('/shop') }}" class="text-gray-500 hover:text-primary transition font-light text-sm underline">Bayar Nanti (Kembali ke Katalog)</a>
                @endif
                
            </div>
        </div>
        
    </div>
</div>

@if($order->payment_status == 'pending' && !str_starts_with($order->snap_token, 'MOCK_TOKEN'))
    <!-- Midtrans Snap.js -->
    <script src="{{ env('MIDTRANS_IS_PRODUCTION') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result){
                    finishLocalPayment();
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda.");
                },
                onError: function(result){
                    alert("Pembayaran gagal.");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                }
            });
        };

        function finishLocalPayment() {
            fetch("{{ url('/checkout/finishLocalPayment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_id: '{{ $order->order_number }}' })
            }).then(() => {
                window.location.reload();
            });
        }
    </script>
@endif

@if(str_starts_with($order->snap_token, 'MOCK_TOKEN'))
<script>
function finishMockPayment() {
    fetch("{{ url('/checkout/finishLocalPayment') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ order_id: '{{ $order->order_number }}' })
    }).then(res => res.json()).then(data => {
        if(data.status === 'success') window.location.reload();
    });
}
</script>
@endif

@endsection
