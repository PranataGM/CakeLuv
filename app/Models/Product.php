<?php
// app/Models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC');
        return $this->db->resultSet();
    }

    public function getBestSellers() {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE c.slug = "best-sellers" LIMIT 8');
        return $this->db->resultSet();
    }

    public function getTrending() {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE c.slug = "trending-now" LIMIT 4');
        return $this->db->resultSet();
    }

    public function findBySlug($slug) {
        $this->db->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.slug = :slug');
        $this->db->bind(':slug', $slug);
        return $this->db->single();
    }

    public function findById($id) {
        $this->db->query('SELECT * FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function checkStock($id, $quantity) {
        $this->db->query('SELECT daily_stock FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        $product = $this->db->single();
        if ($product) {
            return $product['daily_stock'] >= $quantity;
        }
        return false;
    }

    public function deductStock($id, $quantity) {
        $this->db->query('UPDATE products SET daily_stock = daily_stock - :qty WHERE id = :id AND daily_stock >= :qty');
        $this->db->bind(':qty', $quantity);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    public function add($data) {
        $this->db->query('INSERT INTO products (category_id, name, slug, description, price, daily_stock, image_url) VALUES (:category_id, :name, :slug, :description, :price, :daily_stock, :image_url)');
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':slug', strtolower(str_replace(' ', '-', $data['name'])) . '-' . time());
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':daily_stock', $data['daily_stock']);
        $this->db->bind(':image_url', $data['image_url']);
        return $this->db->execute();
    }

    public function delete($id) {
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
