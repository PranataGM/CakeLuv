<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'CakeLuv - Patisserie & Bakery Mewah') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN sementara untuk prototype) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C5837C',
                        primary_hover: '#b06f68',
                        secondary: '#FAF9F6',
                        dark: '#1A1A1A',
                        gold: '#D4AF37'
                    },
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FAF9F6; }
        ::-webkit-scrollbar-thumb { background: #C5837C; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #b06f68; }
        html { scroll-behavior: smooth; }
        #loader {
            position: fixed; inset: 0; z-index: 9999; background: #FAF9F6;
            display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.5s ease;
        }
        .spinner {
            width: 50px; height: 50px; border: 3px solid rgba(197, 131, 124, 0.2);
            border-radius: 50%; border-top-color: #C5837C; animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary text-dark font-sans flex flex-col min-h-screen">
    
    <!-- Loading Screen -->
    <div id="loader">
        <div class="spinner mb-4"></div>
        <p class="font-serif text-primary text-xl italic tracking-wider">CakeLuv...</p>
    </div>

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                        <span class="font-serif font-bold text-3xl text-primary tracking-tight">CakeLuv.</span>
                    </a>
                </div>
                <div class="flex items-center space-x-8">
                    @php 
                        $activeClass = "text-primary font-bold border-b-2 border-primary pb-1";
                        $inactiveClass = "text-gray-600 hover:text-primary";
                        $currentRoute = request()->path();
                    @endphp
                    
                    <a href="{{ url('/') }}" class="text-sm uppercase tracking-wider transition {{ $currentRoute == '/' ? $activeClass : $inactiveClass }}">Beranda</a>
                    <a href="{{ url('/#about') }}" class="text-sm uppercase tracking-wider transition {{ $inactiveClass }}">Tentang</a>
                    <a href="{{ url('/shop') }}" class="text-sm uppercase tracking-wider transition {{ str_starts_with($currentRoute, 'shop') ? $activeClass : $inactiveClass }}">Katalog</a>
                    <a href="{{ url('/#contact') }}" class="text-sm uppercase tracking-wider transition {{ $inactiveClass }}">Kontak</a>
                    
                    <div class="h-6 w-px bg-gray-300 ml-4 mr-4"></div>

                    <a href="{{ url('/cart') }}" class="text-dark hover:text-primary transition relative group" id="cartIcon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin') }}" class="text-xs uppercase font-bold tracking-wider text-gold hover:text-yellow-600 transition">Admin</a>
                        @endif
                        <a href="{{ url('/profile') }}" class="text-xs uppercase font-bold tracking-wider text-gray-600 hover:text-primary transition flex items-center gap-2">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" class="w-6 h-6 rounded-full object-cover">
                            @endif
                            Profil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs uppercase font-bold tracking-wider text-red-400 hover:text-red-600 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="text-xs uppercase font-bold tracking-wider text-gray-600 hover:text-primary transition">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-20 pb-10 border-t-[6px] border-primary mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div data-aos="fade-up">
                    <h2 class="font-serif text-3xl font-bold text-primary mb-4">CakeLuv.</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-light">
                        Menghadirkan kebahagiaan di setiap gigitan. Dibuat dengan bahan premium, cinta, dan dedikasi tinggi untuk merayakan momen spesial Anda.
                    </p>
                </div>
                <div data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-serif text-xl font-bold mb-4 tracking-wide">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ url('/shop') }}" class="hover:text-primary transition">Katalog Produk</a></li>
                        <li><a href="{{ url('/#about') }}" class="hover:text-primary transition">Kisah Kami</a></li>
                        <li><a href="{{ url('/cart') }}" class="hover:text-primary transition">Keranjang Belanja</a></li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="font-serif text-xl font-bold mb-4 tracking-wide">Kunjungi Kami</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span>Jl. Sudirman No. 123, Jakarta Selatan, 12190</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 mt-8 text-center flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} CakeLuv Patisserie. All rights reserved.</p>
                <p class="mt-2 md:mt-0">100% Quality Premium Ingredients | Handcrafted with Love</p>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgClass = type === 'success' ? 'bg-green-600' : (type === 'error' ? 'bg-red-500' : 'bg-dark');
            const icon = type === 'success' 
                ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' 
                : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>';

            toast.className = `flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white text-sm font-bold tracking-wide transform transition-all duration-300 translate-y-10 opacity-0 pointer-events-auto ${bgClass}`;
            toast.innerHTML = `<span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20">${icon}</span> <span>${message}</span>`;
            
            container.appendChild(toast);
            
            requestAnimationFrame(() => toast.classList.remove('translate-y-10', 'opacity-0'));
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        @if(session('success'))
            window.addEventListener('DOMContentLoaded', () => showToast("{{ session('success') }}", 'success'));
        @endif
        
        @if(session('error'))
            window.addEventListener('DOMContentLoaded', () => showToast("{{ session('error') }}", 'error'));
        @endif

        AOS.init({ duration: 800, easing: 'ease-in-out', once: true, offset: 50 });

        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 500);
        });
    </script>
</body>
</html>
