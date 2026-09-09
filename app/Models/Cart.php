<?php
// app/Models/Cart.php

class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getCartByUserId($user_id) {
        $this->db->query('SELECT * FROM carts WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $cart = $this->db->single();

        if (!$cart) {
            $this->db->query('INSERT INTO carts (user_id) VALUES (:user_id)');
            $this->db->bind(':user_id', $user_id);
            $this->db->execute();
            $cartId = $this->db->lastInsertId();
            return ['id' => $cartId, 'user_id' => $user_id];
        }

        return $cart;
    }

    public function getItems($cart_id) {
        $this->db->query('SELECT ci.*, p.name, p.slug, p.price, p.image_url, p.daily_stock FROM cart_items ci JOIN products p ON ci.product_id = p.id WHERE ci.cart_id = :cart_id');
        $this->db->bind(':cart_id', $cart_id);
        return $this->db->resultSet();
    }

    public function updateItemQuantity($item_id, $quantity) {
        $this->db->query('UPDATE cart_items SET quantity = :quantity WHERE id = :id');
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':id', $item_id);
        return $this->db->execute();
    }

    public function addItem($cart_id, $product_id, $quantity, $custom_message = null) {
        $custom_message = substr($custom_message ?? '', 0, 100);
        
        // Cukup cek product_id, abaikan message lama
        $this->db->query('SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id');
        $this->db->bind(':cart_id', $cart_id);
        $this->db->bind(':product_id', $product_id);
        $existing = $this->db->single();

        if ($existing) {
            // Overwrite quantity dan message
            $this->db->query('UPDATE cart_items SET quantity = :qty, custom_message = :msg WHERE id = :id');
            $this->db->bind(':qty', $quantity);
            $this->db->bind(':msg', $custom_message);
            $this->db->bind(':id', $existing['id']);
            return $this->db->execute();
        } else {
            $this->db->query('INSERT INTO cart_items (cart_id, product_id, quantity, custom_message) VALUES (:cart_id, :product_id, :quantity, :custom_message)');
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':product_id', $product_id);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':custom_message', $custom_message);
            return $this->db->execute();
        }
    }

    public function removeItem($item_id) {
        $this->db->query('DELETE FROM cart_items WHERE id = :id');
        $this->db->bind(':id', $item_id);
        return $this->db->execute();
    }

    public function clearCart($cart_id) {
        $this->db->query('DELETE FROM cart_items WHERE cart_id = :cart_id');
        $this->db->bind(':cart_id', $cart_id);
        return $this->db->execute();
    }
}
