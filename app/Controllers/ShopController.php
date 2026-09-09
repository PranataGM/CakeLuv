<?php
// app/Controllers/ShopController.php

class ShopController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $all_products = $productModel->getAll();
        
        $data['cakes'] = [];
        $data['accessories'] = [];

        foreach($all_products as $p) {
            // Asumsikan kategori 5 adalah Lilin & Aksesoris
            if ($p['category_name'] == 'Lilin & Aksesoris' || strpos(strtolower($p['name']), 'lilin') !== false || strpos(strtolower($p['name']), 'topper') !== false) {
                $data['accessories'][] = $p;
            } else {
                $data['cakes'][] = $p;
            }
        }

        $this->view('shop/index', $data);
    }

    public function show($slug) {
        $productModel = $this->model('Product');
        $data['product'] = $productModel->findBySlug($slug);
        
        if (!$data['product']) {
            $this->redirect('/shop');
        }

        $data['cart_item'] = null;
        if (isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart');
            $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
            $items = $cartModel->getItems($cart['id']);
            foreach($items as $ci) {
                if ($ci['product_id'] == $data['product']['id']) {
                    $data['cart_item'] = $ci;
                    break;
                }
            }
        }
        
        $this->view('shop/show', $data);
    }
}
