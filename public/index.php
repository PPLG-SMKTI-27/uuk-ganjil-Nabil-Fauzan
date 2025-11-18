<?php
session_start();

$basePath = dirname(__DIR__);

require_once $basePath . '/app/controllers/AuthController.php';
require_once $basePath . '/app/controllers/DashboardController.php';
require_once $basePath . '/app/controllers/TamuController.php';

$action = $_GET['action'] ?? 'login';

try {
    switch ($action) {
        case 'login':
            $auth = new AuthController();
            $auth->login();
            break;
            
        case 'logout':
            $auth = new AuthController();
            $auth->logout();
            break;
            
        case 'dashboard':
            $dashboard = new DashboardController();
            $dashboard->index();
            break;
        
        case 'dashboard_update_status':
            $dashboard = new DashboardController();
            $dashboard->updateStatusSelesai();
            break;
            
        case 'tamu':
            $tamu = new TamuController();
            $tamu->index();
            break;
            
        case 'tamu_aktif':
            $tamu = new TamuController();
            $tamu->aktif();
            break;
            
        case 'tamu_show':
            $tamu = new TamuController();
            $tamu->show($_GET['id'] ?? null);
            break;
            
        case 'tamu_create':
            $tamu = new TamuController();
            $tamu->create();
            break;
            
        case 'tamu_edit':
            $tamu = new TamuController();
            $tamu->edit($_GET['id'] ?? null);
            break;
            
        case 'tamu_delete':
            $tamu = new TamuController();
            $tamu->delete($_GET['id'] ?? null);
            break;
            
        case 'tamu_update_status':
            $tamu = new TamuController();
            $tamu->updateStatus($_GET['id'] ?? null);
            break;

        case 'tamu_riwayat':
            $tamu = new TamuController();
            $tamu->riwayat();
            break;
            
        case 'tamu_selesai':
            $tamu = new TamuController();
            $tamu->selesai();
            break;
                    
        default:
            header('Location: index.php?action=login');
            break;
    }
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>