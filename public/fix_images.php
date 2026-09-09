<?php
require 'app/Config/config.php';
require 'app/Core/Database.php';

$db = new Database();

// Fix Elegant Swan White Choco
$db->query("UPDATE products SET image_url = 'https://images.unsplash.com/photo-1535141192574-5d4897c12636?w=600&h=600&fit=crop' WHERE name LIKE '%Elegant Swan%' OR name LIKE '%White Choco%'");
$db->execute();

// Fix Red Velvet Dream
$db->query("UPDATE products SET image_url = 'https://images.unsplash.com/photo-1586788680434-30d324b2d46f?w=600&h=600&fit=crop' WHERE name LIKE '%Red Velvet%'");
$db->execute();

// Fix Lilin and Cake Topper
$db->query("UPDATE products SET image_url = 'https://images.unsplash.com/photo-1558301211-0d8c8ddee6ec?w=600&h=600&fit=crop' WHERE category_id = (SELECT id FROM categories WHERE slug = 'aksesoris' LIMIT 1) OR name LIKE '%Lilin%' OR name LIKE '%Topper%'");
$db->execute();

echo "Images Updated.";
