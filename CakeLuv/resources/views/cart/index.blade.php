@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10" data-aos="fade-right">
            <h1 class="font-serif text-4xl font-bold text-dark">Keranjang <span class="text-primary italic">Belanja</span></h1>
        </div>

        @if(!$cart || $cart->items->count() == 0)
            <div class="bg-white rounded-3xl p-16 text-center shadow-sm border border-gray-100" data-aos="fade-up">
                <svg class="w-20 h-20 text-gray-200 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h3 class="font-serif text-2xl font-bold text-dark mb-2">Keranjang Masih Kosong</h3>
                <p class="text-gray-500 font-light mb-8">Anda belum menambahkan kue atau aksesoris apapun.</p>
                <a href="{{ url('/shop') }}" class="inline-block bg-primary hover:bg-primary_hover text-white font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-lg tracking-wide">
                    MULAI BELANJA
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-10">
                <!-- Cart Items -->
                <div class="lg:w-2/3" data-aos="fade-up">
                    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                        <!-- Desktop Header -->
                        <div class="hidden md:grid grid-cols-12 gap-4 p-6 bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-widest items-center">
                            <div class="col-span-6 flex items-center gap-3">
                                <input type="checkbox" id="selectAll" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer" checked onclick="toggleAll(this)">
                                <label for="selectAll" class="cursor-pointer">Pilih Semua / Produk</label>
                            </div>
                            <div class="col-span-2 text-center">Harga</div>
                            <div class="col-span-2 text-center">Kuantitas</div>
                            <div class="col-span-2 text-right">Subtotal</div>
                        </div>

                        <div class="divide-y divide-gray-100" id="cartItemsContainer">
                            @php $total = 0; @endphp
                            @foreach($cart->items as $item)
                                @php 
                                    $subtotal = $item->product->price * $item->quantity * 1000;
                                    $total += $subtotal;
                                @endphp
                                <div class="p-6">
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                        <!-- Product Info -->
                                        <div class="col-span-1 md:col-span-6 flex gap-4 items-center">
                                            <input type="checkbox" class="item-checkbox w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary cursor-pointer" value="{{ $item->id }}" data-price="{{ $subtotal }}" data-qty="{{ $item->quantity }}" checked onchange="updateTotal()">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-20 h-20 md:w-24 md:h-24 object-cover rounded-xl border border-gray-100">
                                            <div class="flex flex-col justify-center">
                                                <a href="{{ url('/shop/' . $item->product->slug) }}" class="font-serif font-bold text-lg text-dark hover:text-primary transition">{{ $item->product->name }}</a>
                                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider">{{ $item->product->category->name }}</p>
                                                @if($item->custom_message)
                                                    <p class="text-xs text-gray-500 mt-2 bg-gray-50 p-2 rounded italic">"{{ $item->custom_message }}"</p>
                                                @endif
                                                <form action="{{ url('/cart/remove') }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600 font-bold uppercase tracking-wider transition">Hapus</button>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Mobile only labels -->
                                        <div class="md:hidden flex justify-between items-center mt-4">
                                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Harga</span>
                                            <span class="text-sm font-bold text-dark">Rp {{ number_format($item->product->price * 1000, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Price (Desktop) -->
                                        <div class="hidden md:block col-span-2 text-center text-sm font-bold text-gray-500">
                                            Rp {{ number_format($item->product->price * 1000, 0, ',', '.') }}
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-center mt-2 md:mt-0">
                                            <span class="md:hidden text-xs font-bold text-gray-500 uppercase tracking-widest">Kuantitas</span>
                                            <form action="{{ url('/cart/update') }}" method="POST" class="flex items-center border border-gray-200 rounded-full overflow-hidden bg-white">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit()" class="w-8 h-8 flex justify-center items-center text-gray-500 hover:bg-gray-50 transition font-bold">-</button>
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->daily_stock }}" class="w-10 h-8 text-center text-sm font-bold text-dark border-none focus:ring-0 p-0" onchange="this.form.submit()">
                                                <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit()" class="w-8 h-8 flex justify-center items-center text-gray-500 hover:bg-gray-50 transition font-bold">+</button>
                                            </form>
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="col-span-1 md:col-span-2 flex justify-between md:justify-end items-center mt-2 md:mt-0">
                                            <span class="md:hidden text-xs font-bold text-gray-500 uppercase tracking-widest">Subtotal</span>
                                            <span class="text-lg font-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-dark text-white rounded-3xl p-8 shadow-2xl sticky top-28 relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
                        
                        <h3 class="font-serif text-2xl font-bold mb-6">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6 text-sm text-gray-300 font-light">
                            <div class="flex justify-between">
                                <span id="summaryItemsText">Subtotal ({{ $cart->items->sum('quantity') }} item)</span>
                                <span class="font-bold text-white" id="summarySubtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Pengiriman</span>
                                <span class="italic">Dihitung di checkout</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-700 pt-6 mb-8 flex justify-between items-center">
                            <span class="font-bold tracking-wide uppercase text-sm">Total Estimasi</span>
                            <span class="text-2xl font-bold text-primary" id="summaryTotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <form id="checkoutForm" action="{{ url('/checkout') }}" method="GET" onsubmit="return prepareCheckout()">
                            <button type="submit" id="checkoutBtn" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-4 rounded-full transition-all shadow-[0_5px_15px_rgba(197,131,124,0.3)] hover:-translate-y-1 tracking-wider text-sm uppercase">
                                Proses Pembayaran
                            </button>
                        </form>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Pembayaran Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('Rp', 'Rp ').trim();
                }

                function toggleAll(source) {
                    const checkboxes = document.querySelectorAll('.item-checkbox');
                    checkboxes.forEach(cb => cb.checked = source.checked);
                    updateTotal();
                }

                function updateTotal() {
                    const checkboxes = document.querySelectorAll('.item-checkbox');
                    let total = 0;
                    let totalQty = 0;
                    let allChecked = true;

                    checkboxes.forEach(cb => {
                        if(cb.checked) {
                            total += parseInt(cb.getAttribute('data-price'));
                            totalQty += parseInt(cb.getAttribute('data-qty'));
                        } else {
                            allChecked = false;
                        }
                    });

                    document.getElementById('selectAll').checked = allChecked;
                    
                    const subtotalFormatted = formatRupiah(total);
                    document.getElementById('summarySubtotal').textContent = subtotalFormatted;
                    document.getElementById('summaryTotal').textContent = subtotalFormatted;
                    document.getElementById('summaryItemsText').textContent = 'Subtotal (' + totalQty + ' item)';

                    const btn = document.getElementById('checkoutBtn');
                    if(total === 0) {
                        btn.disabled = true;
                        btn.classList.add('opacity-50', 'cursor-not-allowed');
                        btn.classList.remove('hover:-translate-y-1', 'hover:bg-primary_hover');
                    } else {
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                        btn.classList.add('hover:-translate-y-1', 'hover:bg-primary_hover');
                    }
                }

                function prepareCheckout() {
                    const form = document.getElementById('checkoutForm');
                    // Remove old hidden inputs
                    form.querySelectorAll('input[type="hidden"]').forEach(el => el.remove());
                    
                    const checkboxes = document.querySelectorAll('.item-checkbox:checked');
                    if(checkboxes.length === 0) {
                        alert('Silakan pilih setidaknya satu produk untuk di-checkout.');
                        return false;
                    }

                    checkboxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_items[]';
                        input.value = cb.value;
                        form.appendChild(input);
                    });

                    return true;
                }
            </script>
        @endif
    </div>
</div>
@endsection
