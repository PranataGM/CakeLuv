@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10" data-aos="fade-right">
            <h1 class="font-serif text-4xl font-bold text-dark">Proses <span class="text-primary italic">Pembayaran</span></h1>
        </div>

        <form action="{{ url('/checkout/process') }}" method="POST" class="flex flex-col lg:flex-row gap-10">
            @csrf
            
            @if(isset($selectedItems) && count($selectedItems) > 0)
                @foreach($selectedItems as $itemId)
                    <input type="hidden" name="selected_items[]" value="{{ $itemId }}">
                @endforeach
            @endif

            <!-- Form Details -->
            <div class="lg:w-2/3 space-y-8" data-aos="fade-up">
                
                <!-- Contact Info -->
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h3 class="font-serif font-bold text-2xl text-dark mb-6 border-b-2 border-primary/20 pb-3 inline-block">Informasi Kontak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 text-sm font-light">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 text-sm font-light">
                        </div>
                    </div>
                    @if(!auth()->user()->phone)
                    <div class="mt-4 p-4 bg-yellow-50 text-yellow-700 rounded-xl text-sm">
                        <span class="font-bold">Info:</span> Anda belum mengatur nomor WhatsApp. Midtrans mungkin memerlukan ini. Anda bisa <a href="{{ url('/profile') }}" class="underline font-bold hover:text-yellow-900">mengaturnya di profil</a> terlebih dahulu, atau lanjutkan jika tidak masalah.
                    </div>
                    @endif
                </div>

                <!-- Delivery Info -->
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
                    <h3 class="font-serif font-bold text-2xl text-dark mb-6 border-b-2 border-primary/20 pb-3 inline-block">Pengiriman</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tipe Pengiriman</label>
                            <select name="delivery_type" id="deliveryType" onchange="toggleAddress()" class="w-full px-5 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light cursor-pointer appearance-none bg-white">
                                <option value="pickup">Ambil di Toko (Pickup)</option>
                                <option value="delivery">Kirim ke Alamat (Delivery +Rp 50.000)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Tanggal Pengiriman/Pengambilan</label>
                            <input type="date" name="target_date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="w-full px-5 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light">
                            <p class="text-xs text-gray-400 mt-2 italic">Minimal pemesanan H-1.</p>
                        </div>
                    </div>

                    <div id="addressContainer" class="hidden">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Pengiriman Lengkap</label>
                        <textarea name="shipping_address" rows="3" class="w-full px-5 py-4 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary text-sm font-light" placeholder="Nama jalan, nomor rumah, RT/RW, kecamatan, kota, patokan..."></textarea>
                    </div>
                </div>

            </div>

            <!-- Order Summary -->
            <div class="lg:w-1/3" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-dark text-white rounded-3xl p-8 shadow-2xl sticky top-28">
                    <h3 class="font-serif text-2xl font-bold mb-6">Ringkasan</h3>
                    
                    <div class="space-y-4 mb-6 text-sm text-gray-300 font-light max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart->items as $item)
                        <div class="flex justify-between items-start border-b border-gray-700 pb-3">
                            <div>
                                <span class="block text-white font-medium">{{ $item->product->name }}</span>
                                <span class="text-xs text-gray-500">{{ $item->quantity }}x @ Rp {{ number_format($item->product->price * 1000, 0, ',', '.') }}</span>
                            </div>
                            <span class="font-bold text-white">Rp {{ number_format($item->product->price * $item->quantity * 1000, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-gray-700 text-sm">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span>Rp <span id="subtotalAmount">{{ number_format($total, 0, ',', '.') }}</span></span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Biaya Pengiriman</span>
                            <span>Rp <span id="shippingFeeAmount">0</span></span>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-6 mt-6 flex justify-between items-center mb-8">
                        <span class="font-bold tracking-wide uppercase text-sm">Total Bayar</span>
                        <span class="text-2xl font-bold text-primary">Rp <span id="totalAmount">{{ number_format($total, 0, ',', '.') }}</span></span>
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-4 rounded-full transition-all duration-300 shadow-lg tracking-wider uppercase text-sm">
                        Bayar Sekarang
                    </button>
                    <div class="mt-4 flex justify-center">
                        <img src="https://gopay.co.id/icon.png" alt="GoPay" class="h-5 opacity-50 grayscale mx-1" onerror="this.style.display='none'">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Logo_ovo_purple.svg/512px-Logo_ovo_purple.svg.png" alt="OVO" class="h-5 opacity-50 grayscale mx-1" onerror="this.style.display='none'">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #333; border-radius: 4px;}
.custom-scrollbar::-webkit-scrollbar-thumb { background: #C5837C; border-radius: 4px; }
</style>

<script>
    const baseTotal = {{ $total }};
    
    function toggleAddress() {
        const type = document.getElementById('deliveryType').value;
        const address = document.getElementById('addressContainer');
        const shippingFeeEl = document.getElementById('shippingFeeAmount');
        const totalEl = document.getElementById('totalAmount');
        
        let shippingFee = 0;
        
        if (type === 'delivery') {
            address.classList.remove('hidden');
            address.querySelector('textarea').required = true;
            shippingFee = 50000;
        } else {
            address.classList.add('hidden');
            address.querySelector('textarea').required = false;
        }
        
        shippingFeeEl.innerText = new Intl.NumberFormat('id-ID').format(shippingFee);
        totalEl.innerText = new Intl.NumberFormat('id-ID').format(baseTotal + shippingFee);
    }
</script>
@endsection
