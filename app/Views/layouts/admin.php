<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - CakeLuv</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff8fab',
                        dark: '#333333'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 text-dark font-sans flex">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md h-screen fixed">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-primary">Admin Panel</h2>
        </div>
        <nav class="mt-6">
            <a href="<?= BASE_URL ?>/admin" class="block px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-primary">Dashboard</a>
            <a href="<?= BASE_URL ?>/admin/products" class="block px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-primary">Manajemen Produk</a>
            <a href="<?= BASE_URL ?>/admin/orders" class="block px-6 py-3 text-gray-600 hover:bg-gray-50 hover:text-primary">Manajemen Pesanan</a>
        </nav>
        <div class="absolute bottom-0 w-full p-6">
            <a href="<?= BASE_URL ?>/" class="text-sm text-gray-500 hover:text-primary">&larr; Kembali ke Web</a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-64 flex-1 p-8">
        <?php require_once '../app/Views/' . $view . '.php'; ?>
    </main>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-5 right-5 z-[100] flex flex-col gap-3 pointer-events-none"></div>

    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const bgClass = type === 'success' ? 'bg-green-600' : (type === 'error' ? 'bg-red-500' : 'bg-gray-800');
            const icon = type === 'success' 
                ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>' 
                : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>';

            toast.className = `flex items-center gap-3 px-5 py-4 rounded-xl shadow-xl text-white text-sm font-bold tracking-wide transform transition-all duration-300 translate-y-10 opacity-0 pointer-events-auto ${bgClass}`;
            toast.innerHTML = `<span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20">${icon}</span> <span>${message}</span>`;
            
            container.appendChild(toast);
            
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            });
            
            setTimeout(() => {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        <?php if(isset($_SESSION['success'])): ?>
            window.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['success']) ?>", 'success'));
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            window.addEventListener('DOMContentLoaded', () => showToast("<?= addslashes($_SESSION['error']) ?>", 'error'));
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
