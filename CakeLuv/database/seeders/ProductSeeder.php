<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Best Sellers
            [
                'category_id' => 1,
                'name' => 'Chocolate Bliss Cake',
                'slug' => 'chocolate-bliss-cake',
                'description' => 'Kue cokelat pekat nan kaya rasa, sempurna untuk setiap perayaan.',
                'price' => 360.00,
                'daily_stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Strawberry Shortcake',
                'slug' => 'strawberry-shortcake',
                'description' => 'Kue bolu lembut, ringan, dengan krim segar dan potongan stroberi manis.',
                'price' => 380.00,
                'daily_stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Red Velvet Dream',
                'slug' => 'red-velvet-dream',
                'description' => 'Red velvet klasik dengan frosting cream cheese yang kaya dan lezat.',
                'price' => 340.00,
                'daily_stock' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1616541823729-00fe0ea0bc33?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Mango Delight Cake',
                'slug' => 'mango-delight-cake',
                'description' => 'Kue mangga tropis untuk sentuhan rasa manis dan menyegarkan.',
                'price' => 350.00,
                'daily_stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1602351447937-745cb720612f?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Classic Tiramisu',
                'slug' => 'classic-tiramisu',
                'description' => 'Tiramisu autentik Italia dengan paduan kopi espresso dan keju mascarpone.',
                'price' => 420.00,
                'daily_stock' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Matcha Opera Cake',
                'slug' => 'matcha-opera-cake',
                'description' => 'Kue opera berlapis matcha premium dan ganache cokelat putih.',
                'price' => 450.00,
                'daily_stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1514845555139-4ce432b03fb4?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 1,
                'name' => 'Choco Hazelnut Crunch',
                'slug' => 'choco-hazelnut-crunch',
                'description' => 'Paduan hazelnut renyah dan mousse cokelat susu yang meleleh di mulut.',
                'price' => 390.00,
                'daily_stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62?w=500&h=500&fit=crop'
            ],
            
            // New Cakes
            [
                'category_id' => 2,
                'name' => 'Minimalist Korean Cake',
                'slug' => 'minimalist-korean-cake',
                'description' => 'Desain simpel dan estetik, sangat cocok untuk kejutan ulang tahun masa kini.',
                'price' => 320.00,
                'daily_stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1557308536-ee471ef2c390?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 3,
                'name' => 'Vintage Heart Cake',
                'slug' => 'vintage-heart-cake',
                'description' => 'Kue bentuk hati bergaya vintage dengan piping elegan, penuh keromantisan.',
                'price' => 390.00,
                'daily_stock' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 3,
                'name' => 'Black Forest Gâteau',
                'slug' => 'black-forest-gateau',
                'description' => 'Kue Black Forest klasik dengan ceri hitam segar.',
                'price' => 360.00,
                'daily_stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 2,
                'name' => 'Lemon Meringue Cake',
                'slug' => 'lemon-meringue-cake',
                'description' => 'Keseimbangan sempurna antara asam lemon segar dan meringue panggang manis.',
                'price' => 330.00,
                'daily_stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1519869325930-281384150729?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 4,
                'name' => 'Raspberry Lychee Rose',
                'slug' => 'raspberry-lychee-rose',
                'description' => 'Perpaduan leci, raspberry, dan aroma mawar yang memanjakan indera.',
                'price' => 410.00,
                'daily_stock' => 6,
                'image_url' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 2,
                'name' => 'Mocha Caramel Latte',
                'slug' => 'mocha-caramel-latte',
                'description' => 'Bolu kopi dengan limpahan karamel leleh di setiap gigitan.',
                'price' => 350.00,
                'daily_stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1587668178277-295251f900ce?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 3,
                'name' => 'Funfetti Party Cake',
                'slug' => 'funfetti-party-cake',
                'description' => 'Kue vanilla penuh warna dengan taburan sprinkles yang ceria.',
                'price' => 300.00,
                'daily_stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 4,
                'name' => 'Elegant Swan White Choco',
                'slug' => 'elegant-swan-white-choco',
                'description' => 'Desain elegan berlapis cokelat putih, direkomendasikan untuk Anniversary.',
                'price' => 480.00,
                'daily_stock' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1605807646983-377bc5a7644e?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 2,
                'name' => 'Pistachio Raspberry',
                'slug' => 'pistachio-raspberry',
                'description' => 'Kue pistachio gurih berpadu dengan selai raspberry buatan sendiri.',
                'price' => 430.00,
                'daily_stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1622621746668-59fb299bc4d7?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 3,
                'name' => 'Blueberry Earl Grey',
                'slug' => 'blueberry-earl-grey',
                'description' => 'Kue teh Earl Grey lembut dengan frosting blueberry segar.',
                'price' => 360.00,
                'daily_stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?w=500&h=500&fit=crop'
            ],
            
            // Accessories
            [
                'category_id' => 5,
                'name' => 'Lilin Batang Biasa (Isi 10)',
                'slug' => 'lilin-biasa-10',
                'description' => 'Satu bungkus lilin ulang tahun biasa motif ulir klasik.',
                'price' => 15.00,
                'daily_stock' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 5,
                'name' => 'Lilin Angka 1 (Gold)',
                'slug' => 'lilin-angka-1-gold',
                'description' => 'Lilin bentuk angka 1 warna emas metalik.',
                'price' => 10.00,
                'daily_stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 5,
                'name' => 'Lilin Angka 2 (Gold)',
                'slug' => 'lilin-angka-2-gold',
                'description' => 'Lilin bentuk angka 2 warna emas metalik.',
                'price' => 10.00,
                'daily_stock' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1542385151-efd9000785a0?w=500&h=500&fit=crop'
            ],
            [
                'category_id' => 5,
                'name' => 'Custom Cake Topper Akrilik',
                'slug' => 'custom-cake-topper-akrilik',
                'description' => 'Topper akrilik premium (Tuliskan teks custom di catatan keranjang).',
                'price' => 45.00,
                'daily_stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1530968311545-0d2961d7eb6b?w=500&h=500&fit=crop'
            ],
        ];

        DB::table('products')->insert($products);
    }
}
