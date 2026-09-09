<?php
// app/Controllers/HomeController.php

class HomeController extends Controller {
    public function index() {
        $productModel = $this->model('Product');
        $data['best_sellers'] = $productModel->getBestSellers();
        $data['trending'] = $productModel->getTrending();
        
        $this->view('home', $data);
    }
}
