<?php
// app/Models/User.php

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($name, $email, $password, $phone, $verification_token) {
        $this->db->query('INSERT INTO users (name, email, password, phone, verification_token, is_verified) VALUES (:name, :email, :password, :phone, :verification_token, 0)');
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->bind(':password', password_hash($password, PASSWORD_BCRYPT));
        $this->db->bind(':phone', $phone);
        $this->db->bind(':verification_token', $verification_token);
        
        try {
            return $this->db->execute();
        } catch(PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if ($row) {
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false;
    }

    public function findByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function verifyEmail($email, $token) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND verification_token = :token AND is_verified = 0');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        $row = $this->db->single();

        if($row) {
            $this->db->query('UPDATE users SET is_verified = 1, verification_token = NULL WHERE email = :email');
            $this->db->bind(':email', $email);
            return $this->db->execute();
        }
        return false;
    }

    public function setResetToken($email, $token) {
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $this->db->query('UPDATE users SET reset_token = :token, reset_expires = :expires WHERE email = :email');
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    public function checkResetToken($email, $token) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND reset_token = :token AND reset_expires > NOW()');
        $this->db->bind(':email', $email);
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function resetPassword($email, $new_password) {
        $this->db->query('UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE email = :email');
        $this->db->bind(':password', password_hash($new_password, PASSWORD_BCRYPT));
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    public function findById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
