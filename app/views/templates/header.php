<?php
// Logika PHP di sini
$title = "Judul Halaman";
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Buku Tamu Digital - SMK TI Airlangga'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?action=dashboard">
                <i class="fas fa-book"></i> Buku Tamu Digital
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="navbar-nav ms-auto">
                        <span class="navbar-text me-3">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?> 
                            <span class="badge bg-light text-dark"><?php echo ucfirst($_SESSION['role']); ?></span>
                        </span>
                        <a class="nav-link" href="index.php?action=logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>" 
                               href="index.php?action=dashboard"
                               data-bs-toggle="tooltip"
                               title="Lihat dashboard">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'tamu') ? 'active' : ''; ?>" 
                               href="index.php?action=tamu"
                               data-bs-toggle="tooltip"
                               title="Lihat semua data tamu">
                                <i class="fas fa-users"></i> Data Tamu
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'tamu_create') ? 'active' : ''; ?>" 
                               href="index.php?action=tamu_create"
                               data-bs-toggle="tooltip"
                               title="Tambah tamu baru">
                                <i class="fas fa-user-plus"></i> Tambah Tamu
                            </a>
                        </li>
                        
                        <!-- MENU BARU: Riwayat dan Selesai -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'tamu_riwayat') ? 'active' : ''; ?>" 
                               href="index.php?action=tamu_riwayat"
                               data-bs-toggle="tooltip"
                               title="Lihat riwayat semua pengunjung">
                                <i class="fas fa-history"></i> Riwayat Pengunjung
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page == 'tamu_selesai') ? 'active' : ''; ?>" 
                               href="index.php?action=tamu_selesai"
                               data-bs-toggle="tooltip"
                               title="Lihat pengunjung yang sudah selesai">
                                <i class="fas fa-check-circle"></i> Pengunjung Selesai
                            </a>
                        </li>
                        
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" 
                               href="index.php?action=tamu_aktif"
                               data-bs-toggle="tooltip"
                               title="Lihat tamu yang sedang aktif">
                                <i class="fas fa-user-clock"></i> Tamu Aktif
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    
                    <!-- Divider dan Info -->
                    <hr class="my-3">
                    <div class="px-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            <?php 
                            $totalTamu = $stats['total_tamu'] ?? 0;
                            $tamuAktif = $stats['tamu_aktif'] ?? 0;
                            $tamuSelesai = $stats['tamu_selesai'] ?? 0;
                            ?>
                            <strong>Statistik:</strong><br>
                            • Total: <?php echo $totalTamu; ?><br>
                            • Aktif: <?php echo $tamuAktif; ?><br>
                            • Selesai: <?php echo $tamuSelesai; ?>
                        </small>
                    </div>
                </div>
            </nav>
            <main class="col-md-10 ms-sm-auto px-md-4">
    <?php endif; ?>

    <div class="<?php echo isset($_SESSION['user_id']) ? '' : 'container mt-4'; ?>">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                Status berhasil diubah!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>