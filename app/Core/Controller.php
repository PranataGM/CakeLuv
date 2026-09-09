<?php
// app/Core/Controller.php

class Controller {
    public function model($model) {
        require_once '../app/Models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        if (file_exists('../app/Views/' . $view . '.php')) {
            extract($data);
            
            // Check if it's admin route to load admin layout
            if (strpos($view, 'admin/') === 0) {
                require_once '../app/Views/layouts/admin.php';
            } else {
                require_once '../app/Views/layouts/main.php';
            }
        } else {
            die("View does not exist.");
        }
    }

    public function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
}
