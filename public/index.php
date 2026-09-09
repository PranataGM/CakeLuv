<?php
session_start();

require_once '../app/Config/config.php';
require_once '../app/Core/Database.php';
require_once '../app/Core/Controller.php';
require_once '../app/Core/Router.php';

$router = new Router();

// Define routes
$router->add('GET', '/', 'HomeController', 'index');

// Auth routes
$router->add('GET', '/login', 'AuthController', 'login');
$router->add('POST', '/login', 'AuthController', 'loginProcess');
$router->add('GET', '/register', 'AuthController', 'register');
$router->add('POST', '/register', 'AuthController', 'registerProcess');
$router->add('GET', '/verify', 'AuthController', 'verify');
$router->add('POST', '/verify', 'AuthController', 'verifyProcess');
$router->add('GET', '/forgot-password', 'AuthController', 'forgotPassword');
$router->add('POST', '/forgot-password', 'AuthController', 'forgotPasswordProcess');
$router->add('GET', '/reset-password', 'AuthController', 'resetPassword');
$router->add('POST', '/reset-password', 'AuthController', 'resetPasswordProcess');
$router->add('GET', '/logout', 'AuthController', 'logout');

// Shop routes
$router->add('GET', '/shop', 'ShopController', 'index');
$router->add('GET', '/product/{slug}', 'ShopController', 'show');

// Cart routes
$router->add('GET', '/cart', 'CartController', 'index');
$router->add('POST', '/cart/add', 'CartController', 'add');
$router->add('POST', '/cart/update', 'CartController', 'update');
$router->add('GET', '/cart/remove/{id}', 'CartController', 'remove');

// Checkout & Orders routes
$router->add('GET', '/checkout', 'CheckoutController', 'index');
$router->add('POST', '/checkout/process', 'CheckoutController', 'process');
$router->add('GET', '/order/status/{order_number}', 'CheckoutController', 'status');
$router->add('POST', '/checkout/finishLocalPayment', 'CheckoutController', 'finishLocalPayment');

// Webhook Midtrans
$router->add('POST', '/webhook/midtrans', 'WebhookController', 'handle');

// Admin routes
$router->add('GET', '/admin', 'AdminController', 'dashboard');
$router->add('GET', '/admin/products', 'AdminController', 'products');
$router->add('POST', '/admin/products/add', 'AdminController', 'addProduct');
$router->add('POST', '/admin/products/delete', 'AdminController', 'deleteProduct');
$router->add('GET', '/admin/orders', 'AdminController', 'orders');
$router->add('POST', '/admin/orders/update-status', 'AdminController', 'updateOrderStatus');

// Run
$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$router->dispatch($url);
