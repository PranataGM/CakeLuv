@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10" data-aos="fade-right">
            <h1 class="font-serif text-4xl font-bold text-dark">Profil <span class="text-primary italic">Saya</span></h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Editor -->
            <div class="md:col-span-1 bg-white p-8 rounded-3xl shadow-xl border border-gray-100" data-aos="fade-up">
                <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="flex justify-center mb-6">
                        <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-primary/20 bg-gray-100 flex items-center justify-center">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-4xl text-gray-400 font-serif">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                            
                            <label class="absolute inset-0 bg-black/50 opacity-0 hover:opacity-100 cursor-pointer flex items-center justify-center transition-opacity">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <input type="file" name="avatar" class="hidden" accept="image/*">
                            </label>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:border-primary text-sm font-light">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Email</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 text-sm font-light">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">No. HP (WhatsApp)</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="0812xxxxxx" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:border-primary text-sm font-light">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Bio / Catatan</label>
                            <textarea name="bio" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:border-primary text-sm font-light">{{ old('bio', $user->bio) }}</textarea>
                        </div>
                        <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-3 rounded-xl transition-all shadow-md mt-4 tracking-wide uppercase text-sm">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order History -->
            <div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-xl border border-gray-100" data-aos="fade-up" data-aos-delay="100">
                <h3 class="font-serif font-bold text-2xl text-dark mb-6 border-b-2 border-primary/20 pb-3 inline-block">Histori Pesanan</h3>
                
                @if($orders->count() > 0)
                    <div class="space-y-6">
                        @foreach($orders as $order)
                        <div class="border border-gray-100 rounded-2xl p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $order->created_at->format('d M Y') }}</p>
                                    <h4 class="font-serif font-bold text-lg text-primary">Order #{{ $order->order_number }}</h4>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
                                        {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : ($order->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-end border-t border-gray-100 pt-4">
                                <div>
                                    <p class="text-sm text-gray-500">Status Dapur: <span class="font-bold text-dark">{{ ucfirst($order->production_status) }}</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 mb-1">Total Belanja</p>
                                    <p class="text-xl font-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 bg-secondary/50 rounded-2xl">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <p class="text-gray-500 font-light">Anda belum memiliki histori pesanan.</p>
                        <a href="{{ url('/shop') }}" class="inline-block mt-4 text-primary font-bold hover:underline">Mulai Belanja</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
