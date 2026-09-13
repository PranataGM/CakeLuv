@extends('layouts.app')

@section('content')
<div class="bg-secondary min-h-screen flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full" data-aos="fade-up">
        
        <!-- Header -->
        <div class="text-center mb-10">
            <h2 class="text-3xl font-serif font-bold text-dark mb-2">Buat Akun Baru</h2>
            <p class="text-gray-500 font-light">Bergabunglah untuk pengalaman belanja yang lebih manis.</p>
        </div>

        <div class="bg-white py-10 px-8 rounded-3xl shadow-2xl border border-gray-100">
            <!-- Google Login Button -->
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 text-gray-700 font-bold py-3 px-4 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm mb-6">
                <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Daftar dengan Google
            </a>

            <div class="relative flex items-center justify-center mb-6">
                <div class="border-t border-gray-200 w-full"></div>
                <div class="bg-white px-4 text-xs text-gray-400 uppercase tracking-widest font-bold absolute">Atau</div>
            </div>

            <form action="{{ url('/register') }}" method="POST">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-bold text-dark mb-2 tracking-wide">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required value="{{ old('name') }}" class="appearance-none w-full px-5 py-4 rounded-xl border border-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all font-light text-sm" placeholder="Nama Anda">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-dark mb-2 tracking-wide">Alamat Email</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}" class="appearance-none w-full px-5 py-4 rounded-xl border border-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all font-light text-sm" placeholder="nama@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-dark mb-2 tracking-wide">Kata Sandi</label>
                        <input type="password" id="password" name="password" required class="appearance-none w-full px-5 py-4 rounded-xl border border-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all font-light text-sm" placeholder="Minimal 8 karakter">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-dark mb-2 tracking-wide">Konfirmasi Kata Sandi</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required class="appearance-none w-full px-5 py-4 rounded-xl border border-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all font-light text-sm" placeholder="Ulangi kata sandi">
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary_hover text-white font-bold py-4 px-4 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1 tracking-wider uppercase text-sm mt-4">
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-600 font-light">
                    Sudah punya akun? 
                    <a href="{{ url('/login') }}" class="font-bold text-primary hover:text-primary_hover transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
