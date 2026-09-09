<?php
// app/Controllers/WebhookController.php

class WebhookController extends Controller {
    public function handle() {
        // Menerima input dari webhook (berupa JSON)
        $payload = file_get_contents('php://input');
        $notification = json_decode($payload);

        if (!$notification) {
            http_response_code(400);
            exit;
        }

        require_once '../app/Config/config.php';
        
        // Verifikasi Signature Key untuk memastikan payload dari Midtrans
        $serverKey = MIDTRANS_SERVER_KEY;
        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $signatureKey = $notification->signature_key;

        $mySignature = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);

        if ($mySignature !== $signatureKey) {
            http_response_code(403);
            echo "Invalid Signature";
            exit;
        }

        // Ambil status transaksi
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = isset($notification->fraud_status) ? $notification->fraud_status : null;

        $orderModel = $this->model('Order');

        // Logic status Midtrans
        if ($transactionStatus == 'capture'){
            if ($fraudStatus == 'accept'){
                $orderModel->updatePaymentStatusByOrderNumber($orderId, 'paid');
            }
        } else if ($transactionStatus == 'settlement'){
            $orderModel->updatePaymentStatusByOrderNumber($orderId, 'paid');
        } else if ($transactionStatus == 'cancel' ||
          $transactionStatus == 'deny' ||
          $transactionStatus == 'expire'){
            $orderModel->updatePaymentStatusByOrderNumber($orderId, 'expired');
        } else if ($transactionStatus == 'pending'){
            $orderModel->updatePaymentStatusByOrderNumber($orderId, 'pending');
        }

        http_response_code(200);
        echo "OK";
    }
}
