<?php
// app/Controllers/CheckoutController.php

class CheckoutController extends Controller {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $cartModel = $this->model('Cart');
        $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
        $items = $cartModel->getItems($cart['id']);

        if (empty($items)) {
            $this->redirect('/cart');
        }

        $data = [
            'items' => $items,
            'total' => array_sum(array_map(function($item) { return ($item['price'] * 1000) * $item['quantity']; }, $items))
        ];

        $this->view('checkout/index', $data);
    }

    public function process() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $cartModel = $this->model('Cart');
            $cart = $cartModel->getCartByUserId($_SESSION['user_id']);
            $items = $cartModel->getItems($cart['id']);

            if (empty($items)) {
                $this->redirect('/cart');
            }

            $productModel = $this->model('Product');
            $orderModel = $this->model('Order');

            $target_date = $_POST['target_date'];
            $delivery_type = $_POST['delivery_type'];
            $shipping_address = isset($_POST['shipping_address']) ? htmlspecialchars($_POST['shipping_address']) : null;
            $total_amount = array_sum(array_map(function($item) { return ($item['price'] * 1000) * $item['quantity']; }, $items));

            // Race Condition Check: Check stock again before finalizing
            foreach ($items as $item) {
                if (!$productModel->checkStock($item['product_id'], $item['quantity'])) {
                    $_SESSION['error'] = "Stok untuk produk " . $item['name'] . " tidak mencukupi.";
                    $this->redirect('/cart');
                }
            }

            // Create Order
            $order_id = $orderModel->createOrder($_SESSION['user_id'], $total_amount, $target_date, $delivery_type, $shipping_address);
            $order_number = $orderModel->getOrderNumber($order_id);

            if ($order_id) {
                // Deduct stock and add order items
                foreach ($items as $item) {
                    $productModel->deductStock($item['product_id'], $item['quantity']);
                    $orderModel->addOrderItem($order_id, $item['product_id'], $item['price'] * 1000, $item['quantity'], $item['custom_message']);
                }

                // Clear Cart
                $cartModel->clearCart($cart['id']);

                // Integrate Midtrans
                require_once '../app/Config/config.php';
                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order_number,
                        'gross_amount' => $total_amount,
                    ),
                    'customer_details' => array(
                        'first_name' => $_SESSION['user_name']
                    )
                );

                $auth = base64_encode(MIDTRANS_SERVER_KEY . ':');
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://app.sandbox.midtrans.com/snap/v1/transactions");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
                $headers = array();
                $headers[] = 'Accept: application/json';
                $headers[] = 'Content-Type: application/json';
                $headers[] = 'Authorization: Basic ' . $auth;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                
                $midtrans_response = json_decode($result);
                
                if (isset($midtrans_response->token)) {
                    $_SESSION['snap_token'] = $midtrans_response->token;
                    $this->redirect('/order/status/' . $order_number);
                } else {
                    echo "<div style='background:#fce4e4; border:1px solid #fcc2c3; padding:20px; color:#cc0033; font-family:sans-serif; margin:20px; border-radius:8px;'>";
                    echo "<strong>Midtrans Error!</strong><br><br>";
                    echo "Silakan periksa kredensial Sandbox Anda di file app/Config/config.php.<br>";
                    echo "Pesan Error dari Midtrans:<br>";
                    echo "<code>" . htmlspecialchars($result) . "</code>";
                    echo "</div>";
                }

            }
        }
    }

    public function status($order_number) {
        $orderModel = $this->model('Order');
        $data['order'] = $orderModel->getOrderDetails($order_number);
        $data['snap_token'] = isset($_SESSION['snap_token']) ? $_SESSION['snap_token'] : null;
        unset($_SESSION['snap_token']); // Consume token
        $this->view('checkout/status', $data);
    }

    // Metode fallback hanya untuk simulasi Localhost (karena Webhook tidak bisa ditembak tanpa Ngrok)
    public function finishLocalPayment() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_number = $_POST['order_number'];
            if($order_number) {
                $orderModel = $this->model('Order');
                $orderModel->updatePaymentStatusByOrderNumber($order_number, 'paid');
            }
        }
    }
}
