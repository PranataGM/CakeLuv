<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CakeLuv - Patisserie & Bakery Mewah</title>
    
    <!-- Google Fonts: Playfair Display (Luxury Headings) & Montserrat (Modern Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#C5837C', // Rose Gold Mewah
                        primary_hover: '#b06f68',
                        secondary: '#FAF9F6', // Champagne / Off-white
                        dark: '#1A1A1A', // Charcoal / Almost Black
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
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #FAF9F6; }
        ::-webkit-scrollbar-thumb { background: #C5837C; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #b06f68; }
        
        /* Smooth Scroll */
        html { scroll-behavior: smooth; }

        /* Loader Animation */
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
                    <a href="<?= BASE_URL ?>/" class="flex-shrink-0 flex items-center">
                        <span class="font-serif font-bold text-3xl text-primary tracking-tight">CakeLuv.</span>
                    </a>
                </div>
                <div class="flex items-center space-x-8">
                    <?php 
                        $activeClass = "text-primary font-bold border-b-2 border-primary pb-1";
                        $inactiveClass = "text-gray-600 hover:text-primary";
                    ?>
                    <a href="<?= BASE_URL ?>/" class="text-sm uppercase tracking-wider transition <?= ($view == 'home') ? $activeClass : $inactiveClass ?>">Beranda</a>
                    <a href="<?= BASE_URL ?>/#about" class="text-sm uppercase tracking-wider transition <?= $inactiveClass ?>">Tentang</a>
                    <a href="<?= BASE_URL ?>/shop" class="text-sm uppercase tracking-wider transition <?= (strpos($view, 'shop') === 0) ? $activeClass : $inactiveClass ?>">Katalog</a>
                    <a href="<?= BASE_URL ?>/#contact" class="text-sm uppercase tracking-wider transition <?= $inactiveClass ?>">Kontak</a>
                    
                    <div class="h-6 w-px bg-gray-300 ml-4 mr-4"></div> <!-- Divider -->

                    <a href="<?= BASE_URL ?>/cart" class="text-gray-600 hover:text-primary transition flex items-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </a>
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <a href="<?= BASE_URL ?>/admin" class="text-xs uppercase font-bold tracking-wider text-gold hover:text-yellow-600 transition">Admin</a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/logout" class="text-xs uppercase font-bold tracking-wider text-red-400 hover:text-red-600 transition">Logout</a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="text-xs uppercase font-bold tracking-wider text-gray-600 hover:text-primary transition">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages (Digantikan oleh Toast di bagian bawah) -->

    <main class="flex-grow">
        <?php require_once '../app/Views/' . $view . '.php'; ?>
    </main>

    <!-- Mewah Footer -->
    <footer class="bg-dark text-white pt-20 pb-10 border-t-[6px] border-primary mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                
                <!-- Brand Info -->
                <div data-aos="fade-up">
                    <h2 class="font-serif text-3xl font-bold text-primary mb-4">CakeLuv.</h2>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-light">
                        Menghadirkan kebahagiaan di setiap gigitan. Dibuat dengan bahan premium, cinta, dan dedikasi tinggi untuk merayakan momen spesial Anda.
                    </p>
                    <!-- Social Icons (Dummy) -->
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-primary transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                        <a href="#" class="text-gray-400 hover:text-primary transition"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-serif text-xl font-bold mb-4 tracking-wide">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="<?= BASE_URL ?>/shop" class="hover:text-primary transition">Katalog Produk</a></li>
                        <li><a href="<?= BASE_URL ?>/#about" class="hover:text-primary transition">Kisah Kami</a></li>
                        <li><a href="<?= BASE_URL ?>/cart" class="hover:text-primary transition">Keranjang Belanja</a></li>
                        <li><a href="#" class="hover:text-primary transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-primary transition">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <!-- Operational Hours -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h3 class="font-serif text-xl font-bold mb-4 tracking-wide">Kunjungi Kami</h3>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jl. Sudirman No. 123, Jakarta Selatan, 12190</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-primary mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <span class="block text-white mb-1">Senin - Jumat</span>
                                <span>08.00 - 20.00 WIB</span>
                                <span class="block text-white mt-2 mb-1">Sabtu - Minggu</span>
                                <span>09.00 - 21.00 WIB</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 mt-8 text-center flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; <?= date('Y') ?> CakeLuv Patisserie. All rights reserved.</p>
                <p class="mt-2 md:mt-0">100% Quality Premium Ingredients | Handcrafted with Love</p>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Toast Notification System
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
            
            // Animate in
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });
            
            // Remove after 3 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Catch PHP Session Alerts
        <?php if(isset($_SESSION['success'])): ?>
            window.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['success']) ?>", 'success'));
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            window.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['error']) ?>", 'error'));
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 50
        });

        // Hide Loader
        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500);
        });
    </script>
</body>
</html>
