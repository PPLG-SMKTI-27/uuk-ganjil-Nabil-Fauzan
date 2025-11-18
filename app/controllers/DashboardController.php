<?php
require_once __DIR__ . '/../models/Tamu.php';
require_once __DIR__ . '/../models/User.php';

class DashboardController {
    private $tamuModel;
    private $authController;

    public function __construct() {
        $this->tamuModel = new TamuModel();
        $this->authController = new AuthController();
        
        // Pastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $this->authController->checkAuth();
        
        $stats = $this->tamuModel->getStats();
        $recentTamu = array_slice($this->tamuModel->getAll(), 0, 5);
        
        // Cek apakah user adalah admin
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
        
        require_once __DIR__ . '/../views/dashboard/index.php';
    }

    // Method untuk mengubah status menjadi selesai (admin only)
    public function updateStatusSelesai() {
        $this->authController->checkAuth();
        
        // Cek apakah request adalah POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?action=dashboard&error=Invalid request');
            exit;
        }

        $id = $_POST['id'] ?? null;
        
        if (!$id) {
            header('Location: index.php?action=dashboard&error=ID not provided');
            exit;
        }

        // Cek apakah user adalah admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?action=dashboard&error=Hanya admin yang bisa mengubah status');
            exit;
        }

        $status = 'selesai';
        
        if ($this->tamuModel->updateStatus($id, $status)) {
            header('Location: index.php?action=dashboard&success=1');
            exit;
        } else {
            header('Location: index.php?action=dashboard&error=Gagal update status');
            exit;
        }
    }
}
?>