<?php

use App\Models\User;

// app/controllers/AuthController.php

class AuthController {
    protected $userModel;

    public function __construct($db) {
        require_once __DIR__ . '/../models/User.php';
        $this->userModel = new User($db);
    }

    public function signin() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userModel->findUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user['username'];
            header('Location: /dashboard');
            exit();
        } else {
            header('Location: /signin?error=invalid_credentials');
            exit();
        }
    }
}

