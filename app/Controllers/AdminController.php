<?php
// app/Controllers/AdminController.php

class AdminController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("HTTP/1.1 403 Forbidden");
            echo "Akses Ditolak. Anda bukan admin.";
            exit;
        }
    }

    public function dashboard() {
        $orderModel = $this->model('Order');
        $orders = $orderModel->getAllOrders();
        
        $data['total_orders'] = count($orders);
        $data['total_revenue'] = 0;
        foreach($orders as $o) {
            if($o['payment_status'] == 'paid') $data['total_revenue'] += $o['total_amount'];
        }
        $data['orders'] = array_slice($orders, 0, 5); // 5 recent

        // Analytics Data
        $data['sales_chart'] = $orderModel->getSalesLast7Days();
        $data['status_stats'] = $orderModel->getOrderStatusStats();
        $data['top_products'] = $orderModel->getTopProducts();

        $this->view('admin/dashboard', $data);
    }

    public function products() {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        $data['products'] = $productModel->getAll();
        $data['categories'] = $categoryModel->getAll();

        $this->view('admin/products', $data);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productModel = $this->model('Product');
            
            $data = [
                'name' => htmlspecialchars($_POST['name']),
                'category_id' => $_POST['category_id'],
                'price' => $_POST['price'],
                'daily_stock' => $_POST['daily_stock'],
                'description' => htmlspecialchars($_POST['description']),
                'image_url' => ''
            ];

            // Handle file upload
            if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] == 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['image_file']['name'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                
                if (in_array($ext, $allowed)) {
                    $newName = uniqid() . '-' . time() . '.' . $ext;
                    // Upload dir is in public/uploads (since index.php is in public)
                    $destination = '../public/uploads/' . $newName;
                    
                    if (move_uploaded_file($_FILES['image_file']['tmp_name'], $destination)) {
                        // Store relative URL accessible via browser
                        $data['image_url'] = BASE_URL . '/uploads/' . $newName;
                    }
                }
            }

            // Fallback default image jika upload gagal/kosong
            if (empty($data['image_url'])) {
                $data['image_url'] = 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&h=500&fit=crop';
            }

            if ($productModel->add($data)) {
                $_SESSION['success'] = "Produk berhasil ditambahkan.";
            } else {
                $_SESSION['error'] = "Gagal menambah produk.";
            }
            $this->redirect('/admin/products');
        }
    }

    public function deleteProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productModel = $this->model('Product');
            $productModel->delete($_POST['id']);
            $this->redirect('/admin/products');
        }
    }

    public function orders() {
        $orderModel = $this->model('Order');
        $data['orders'] = $orderModel->getAllOrders();
        $this->view('admin/orders', $data);
    }

    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $orderModel = $this->model('Order');
            $orderModel->updateProductionStatus($_POST['order_id'], $_POST['status']);
            $this->redirect('/admin/orders');
        }
    }
}
