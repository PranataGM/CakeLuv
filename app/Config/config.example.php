<?php
// app/Config/config.example.php
// RENAME THIS FILE TO config.php AND FILL IN YOUR CREDENTIALS

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bakery_db');

// Midtrans Credentials
define('MIDTRANS_SERVER_KEY', 'YOUR_MIDTRANS_SERVER_KEY');
define('MIDTRANS_CLIENT_KEY', 'YOUR_MIDTRANS_CLIENT_KEY');
define('MIDTRANS_IS_PRODUCTION', false);

// Base URL auto-detect (Localhost)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'];
define('BASE_URL', $protocol . "://" . $domain);
