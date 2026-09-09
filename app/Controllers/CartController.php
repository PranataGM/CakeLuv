<?php
// app/Controllers/CartController.php

class CartController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Silakan login untuk melihat keranjang.";
            $this->redirect('/login');
        }

        $cartModel = $this->model('Cart');
        $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
        $items = $cartModel->getItems($cart['id']);

        $data = [
            'items' => $items,
            'total' => array_sum(array_map(function($item) { return ($item['price'] * 1000) * $item['quantity']; }, $items))
        ];

        $this->view('cart/index', $data);
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart');
            $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
            
            $quantities = $_POST['quantities'] ?? [];
            $messages = $_POST['messages'] ?? [];
            
            foreach ($quantities as $item_id => $qty) {
                $qty = max(1, (int)$qty);
                $cartModel->updateItemQuantity($item_id, $qty);
            }
            
            if (isset($_POST['checkout'])) {
                $this->redirect('/checkout');
            } else {
                $_SESSION['success'] = "Keranjang berhasil diperbarui.";
                $this->redirect('/cart');
            }
        }
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['status' => 'error', 'message' => 'Silakan login terlebih dahulu.']);
                exit;
            }

            $product_id = $_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $custom_message = isset($_POST['custom_message']) ? htmlspecialchars($_POST['custom_message']) : null;

            $productModel = $this->model('Product');
            if (!$productModel->checkStock($product_id, $quantity)) {
                echo json_encode(['status' => 'error', 'message' => 'Stok tidak mencukupi.']);
                exit;
            }

            $cartModel = $this->model('Cart');
            $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
            
            if ($cartModel->addItem($cart['id'], $product_id, $quantity, $custom_message)) {
                echo json_encode(['status' => 'success', 'message' => 'Produk ditambahkan ke keranjang!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan produk.']);
            }
        }
    }

    public function remove($id) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $cartModel = $this->model('Cart');
        $cartModel->removeItem($id);
        $this->redirect('/cart');
    }
}
