<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['role'] = $user->getRole();
                
                header('Location: index.php?action=dashboard');
                exit;
            } else {
                $error = "Username atau password salah!";
                require_once __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?action=login');
        exit;
    }

    public function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
    }

    public function getCurrentUser() {
        if (isset($_SESSION['user_id'])) {
            return $this->userModel->getUserById($_SESSION['user_id']);
        }
        return null;
    }
}
?>