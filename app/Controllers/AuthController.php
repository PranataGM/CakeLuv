<?php
// app/Controllers/AuthController.php

class AuthController extends Controller {
    public function login() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/login');
    }

    public function loginProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $user = $userModel->login($_POST['email'], $_POST['password']);

            if ($user) {
                if ($user['is_verified'] == 0 && $user['role'] !== 'admin') {
                    $_SESSION['error'] = "Akun belum diverifikasi. Silakan cek email Anda.";
                    $this->redirect('/verify?email=' . urlencode($user['email']));
                }

                // Prevent Session Hijacking
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    $this->redirect('/admin');
                } else {
                    $this->redirect('/');
                }
            } else {
                $_SESSION['error'] = "Email atau password salah!";
                $this->redirect('/login');
            }
        }
    }

    public function register() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/register');
    }

    public function registerProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $password = $_POST['password'];

            $token = sprintf("%06d", mt_rand(1, 999999));

            if ($userModel->register($name, $email, $password, $phone, $token)) {
                // Simulasi pengiriman email
                // mail($email, "Kode Verifikasi", "Kode Anda: " . $token);
                
                $_SESSION['success'] = "Pendaftaran berhasil! Cek email Anda untuk kode OTP. (Token simulasi: $token)";
                $this->redirect('/verify?email=' . urlencode($email));
            } else {
                $_SESSION['error'] = "Email mungkin sudah terdaftar.";
                $this->redirect('/register');
            }
        }
    }

    public function verify() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $data['email'] = isset($_GET['email']) ? $_GET['email'] : '';
        $this->view('auth/verify', $data);
    }

    public function verifyProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $email = $_POST['email'];
            $token = $_POST['token'];

            if($userModel->verifyEmail($email, $token)) {
                $_SESSION['success'] = "Email berhasil diverifikasi! Silakan login.";
                $this->redirect('/login');
            } else {
                $_SESSION['error'] = "Token tidak valid atau sudah diverifikasi.";
                $this->redirect('/verify?email=' . urlencode($email));
            }
        }
    }

    public function forgotPassword() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/forgot-password');
    }

    public function forgotPasswordProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $email = htmlspecialchars($_POST['email']);

            $user = $userModel->findByEmail($email);
            if ($user) {
                $token = sprintf("%06d", mt_rand(1, 999999));
                $userModel->setResetToken($email, $token);

                // Simulasi pengiriman email
                // mail($email, "Reset Sandi", "Kode Reset Anda: " . $token);

                $_SESSION['success'] = "Kode reset telah dikirim ke email Anda. (Token simulasi: $token)";
                $this->redirect('/reset-password?email=' . urlencode($email));
            } else {
                $_SESSION['error'] = "Email tidak ditemukan.";
                $this->redirect('/forgot-password');
            }
        }
    }

    public function resetPassword() {
        if(isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $data['email'] = isset($_GET['email']) ? $_GET['email'] : '';
        $this->view('auth/reset-password', $data);
    }

    public function resetPasswordProcess() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('User');
            $email = $_POST['email'];
            $token = $_POST['token'];
            $new_password = $_POST['new_password'];

            if ($userModel->checkResetToken($email, $token)) {
                $userModel->resetPassword($email, $new_password);
                $_SESSION['success'] = "Sandi berhasil diubah! Silakan login dengan sandi baru.";
                $this->redirect('/login');
            } else {
                $_SESSION['error'] = "Token reset tidak valid atau sudah kedaluwarsa.";
                $this->redirect('/reset-password?email=' . urlencode($email));
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/');
    }
}
