<?php
// app/Models/Order.php

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createOrder($user_id, $total_amount, $target_date, $delivery_type, $shipping_address) {
        $order_number = 'ORD-' . time() . '-' . rand(1000, 9999);
        $this->db->query('INSERT INTO orders (user_id, order_number, total_amount, target_date, delivery_type, shipping_address) VALUES (:user_id, :order_number, :total_amount, :target_date, :delivery_type, :shipping_address)');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':order_number', $order_number);
        $this->db->bind(':total_amount', $total_amount);
        $this->db->bind(':target_date', $target_date);
        $this->db->bind(':delivery_type', $delivery_type);
        $this->db->bind(':shipping_address', $shipping_address);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getOrderNumber($id) {
        $this->db->query('SELECT order_number FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row ? $row['order_number'] : null;
    }

    public function addOrderItem($order_id, $product_id, $price_at_purchase, $quantity, $custom_message) {
        $this->db->query('INSERT INTO order_items (order_id, product_id, price_at_purchase, quantity, custom_message) VALUES (:order_id, :product_id, :price_at_purchase, :quantity, :custom_message)');
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':product_id', $product_id);
        $this->db->bind(':price_at_purchase', $price_at_purchase);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':custom_message', $custom_message);
        return $this->db->execute();
    }

    public function updatePaymentStatusByOrderNumber($order_number, $status) {
        $this->db->query('UPDATE orders SET payment_status = :status WHERE order_number = :order_number');
        $this->db->bind(':status', $status);
        $this->db->bind(':order_number', $order_number);
        return $this->db->execute();
    }

    public function updateProductionStatus($order_id, $status) {
        $this->db->query('UPDATE orders SET production_status = :status WHERE id = :order_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':order_id', $order_id);
        return $this->db->execute();
    }

    public function getAllOrders() {
        $this->db->query('SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC');
        return $this->db->resultSet();
    }

    public function getOrdersByUserId($user_id) {
        $this->db->query('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function getOrderDetails($order_number) {
        $this->db->query('SELECT o.*, u.name as customer_name, u.email, u.phone FROM orders o JOIN users u ON o.user_id = u.id WHERE o.order_number = :order_number');
        $this->db->bind(':order_number', $order_number);
        $order = $this->db->single();

        if ($order) {
            $this->db->query('SELECT oi.*, p.name as product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = :order_id');
            $this->db->bind(':order_id', $order['id']);
            $order['items'] = $this->db->resultSet();
        }

        return $order;
    }
    public function getSalesLast7Days() {
        $this->db->query("SELECT DATE(created_at) as date, SUM(total_amount) as total FROM orders WHERE payment_status = 'paid' AND created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(created_at) ORDER BY date ASC");
        return $this->db->resultSet();
    }

    public function getOrderStatusStats() {
        $this->db->query("SELECT production_status, COUNT(*) as count FROM orders GROUP BY production_status");
        return $this->db->resultSet();
    }

    public function getTopProducts() {
        $this->db->query("SELECT p.name, SUM(oi.quantity) as total_sold FROM order_items oi JOIN products p ON oi.product_id = p.id JOIN orders o ON oi.order_id = o.id WHERE o.payment_status = 'paid' GROUP BY p.id ORDER BY total_sold DESC LIMIT 5");
        return $this->db->resultSet();
    }
}
