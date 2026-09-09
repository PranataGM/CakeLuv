CREATE DATABASE IF NOT EXISTS bakery_db;
USE bakery_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    daily_stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT,
    product_id INT,
    quantity INT NOT NULL,
    custom_message VARCHAR(100) NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    target_date DATE NOT NULL,
    delivery_type ENUM('pickup', 'delivery') DEFAULT 'pickup',
    shipping_address TEXT NULL,
    payment_status ENUM('pending', 'paid', 'failed', 'expired') DEFAULT 'pending',
    production_status ENUM('waiting', 'baking', 'ready', 'completed') DEFAULT 'waiting',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    price_at_purchase DECIMAL(12,2) NOT NULL,
    quantity INT NOT NULL,
    custom_message VARCHAR(100) NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Insert default admin
INSERT IGNORE INTO users (name, email, password, role) VALUES 
('Administrator', 'admin@cakeluv.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'); 
-- password default admin adalah 'password'

-- Insert default categories
INSERT IGNORE INTO categories (id, name, slug) VALUES 
(1, 'Best Sellers', 'best-sellers'),
(2, 'Trending Now', 'trending-now'),
(3, 'Birthday', 'birthday'),
(4, 'Anniversary', 'anniversary'),
(5, 'Lilin & Aksesoris', 'lilin-aksesoris');

-- Insert sample products (Harga disesuaikan, dikali 1000 di UI)
INSERT IGNORE INTO products (category_id, name, slug, description, price, daily_stock, image_url) VALUES 
-- Original 4 Best Sellers
(1, 'Chocolate Bliss Cake', 'chocolate-bliss-cake', 'Kue cokelat pekat nan kaya rasa, sempurna untuk setiap perayaan.', 360.00, 10, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&h=500&fit=crop'),
(1, 'Strawberry Shortcake', 'strawberry-shortcake', 'Kue bolu lembut, ringan, dengan krim segar dan potongan stroberi manis.', 380.00, 10, 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=500&h=500&fit=crop'),
(1, 'Red Velvet Dream', 'red-velvet-dream', 'Red velvet klasik dengan frosting cream cheese yang kaya dan lezat.', 340.00, 5, 'https://images.unsplash.com/photo-1616541823729-00fe0ea0bc33?w=500&h=500&fit=crop'),
(1, 'Mango Delight Cake', 'mango-delight-cake', 'Kue mangga tropis untuk sentuhan rasa manis dan menyegarkan.', 350.00, 8, 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=500&h=500&fit=crop'),

-- 3 New Best Sellers
(1, 'Classic Tiramisu', 'classic-tiramisu', 'Tiramisu autentik Italia dengan paduan kopi espresso dan keju mascarpone.', 420.00, 5, 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=500&h=500&fit=crop'),
(1, 'Matcha Opera Cake', 'matcha-opera-cake', 'Kue opera berlapis matcha premium dan ganache cokelat putih.', 450.00, 8, 'https://images.unsplash.com/photo-1514845555139-4ce432b03fb4?w=500&h=500&fit=crop'),
(1, 'Choco Hazelnut Crunch', 'choco-hazelnut-crunch', 'Paduan hazelnut renyah dan mousse cokelat susu yang meleleh di mulut.', 390.00, 12, 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=500&h=500&fit=crop'),

-- 10 New Cakes (Katalog Tambahan)
(2, 'Minimalist Korean Cake', 'minimalist-korean-cake', 'Desain simpel dan estetik, sangat cocok untuk kejutan ulang tahun masa kini.', 320.00, 15, 'https://images.unsplash.com/photo-1557308536-ee471ef2c390?w=500&h=500&fit=crop'),
(3, 'Vintage Heart Cake', 'vintage-heart-cake', 'Kue bentuk hati bergaya vintage dengan piping elegan, penuh keromantisan.', 390.00, 5, 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?w=500&h=500&fit=crop'),
(3, 'Black Forest Gâteau', 'black-forest-gateau', 'Kue Black Forest klasik dengan ceri hitam segar.', 360.00, 8, 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=500&h=500&fit=crop'),
(2, 'Lemon Meringue Cake', 'lemon-meringue-cake', 'Keseimbangan sempurna antara asam lemon segar dan meringue panggang manis.', 330.00, 10, 'https://images.unsplash.com/photo-1519869325930-281384150729?w=500&h=500&fit=crop'),
(4, 'Raspberry Lychee Rose', 'raspberry-lychee-rose', 'Perpaduan leci, raspberry, dan aroma mawar yang memanjakan indera.', 410.00, 6, 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=500&h=500&fit=crop'),
(2, 'Mocha Caramel Latte', 'mocha-caramel-latte', 'Bolu kopi dengan limpahan karamel leleh di setiap gigitan.', 350.00, 12, 'https://images.unsplash.com/photo-1587668178277-295251f900ce?w=500&h=500&fit=crop'),
(3, 'Funfetti Party Cake', 'funfetti-party-cake', 'Kue vanilla penuh warna dengan taburan sprinkles yang ceria.', 300.00, 15, 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=500&h=500&fit=crop'),
(4, 'Elegant Swan White Choco', 'elegant-swan-white-choco', 'Desain elegan berlapis cokelat putih, direkomendasikan untuk Anniversary.', 480.00, 4, 'https://images.unsplash.com/photo-1605807646983-377bc5a7644e?w=500&h=500&fit=crop'),
(2, 'Pistachio Raspberry', 'pistachio-raspberry', 'Kue pistachio gurih berpadu dengan selai raspberry buatan sendiri.', 430.00, 8, 'https://images.unsplash.com/photo-1622621746668-59fb299bc4d7?w=500&h=500&fit=crop'),
(3, 'Blueberry Earl Grey', 'blueberry-earl-grey', 'Kue teh Earl Grey lembut dengan frosting blueberry segar.', 360.00, 10, 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=500&h=500&fit=crop'),

-- 9 Lilin & 1 Cake Topper
(5, 'Lilin Batang Biasa (Isi 10)', 'lilin-biasa-10', 'Satu bungkus lilin ulang tahun biasa motif ulir klasik.', 15.00, 50, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 1 (Gold)', 'lilin-angka-1-gold', 'Lilin bentuk angka 1 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 2 (Gold)', 'lilin-angka-2-gold', 'Lilin bentuk angka 2 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 3 (Gold)', 'lilin-angka-3-gold', 'Lilin bentuk angka 3 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 4 (Gold)', 'lilin-angka-4-gold', 'Lilin bentuk angka 4 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 5 (Gold)', 'lilin-angka-5-gold', 'Lilin bentuk angka 5 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 6 (Gold)', 'lilin-angka-6-gold', 'Lilin bentuk angka 6 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 7 (Gold)', 'lilin-angka-7-gold', 'Lilin bentuk angka 7 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Lilin Angka 8 (Gold)', 'lilin-angka-8-gold', 'Lilin bentuk angka 8 warna emas metalik.', 10.00, 30, 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'),
(5, 'Custom Cake Topper Akrilik', 'custom-cake-topper-akrilik', 'Topper akrilik premium (Tuliskan teks custom di catatan keranjang).', 45.00, 20, 'https://images.unsplash.com/photo-1530968311545-0d2961d7eb6b?w=500&h=500&fit=crop');
