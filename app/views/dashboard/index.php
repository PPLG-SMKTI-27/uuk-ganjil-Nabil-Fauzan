<?php
$title = "Dashboard - Buku Tamu Digital";
$current_page = 'dashboard';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-chart-line"></i> Dashboard</h2>
        <small class="text-muted">
            <i class="fas fa-calendar-alt"></i> 
            <?php echo date('l, d F Y'); ?>
        </small>
    </div>

    <!-- Statistik Cards YANG SUDAH DIPERBARUI -->
    <div class="row mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Total Tamu</h6>
                            <h3 class="mb-0"><?php echo $stats['total_tamu'] ?? 0; ?></h3>
                        </div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card bg-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Tamu Aktif</h6>
                            <h3 class="mb-0"><?php echo $stats['tamu_aktif'] ?? 0; ?></h3>
                        </div>
                        <i class="fas fa-user-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CARD BARU: Tamu Selesai -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Tamu Selesai</h6>
                            <h3 class="mb-0"><?php echo $stats['tamu_selesai'] ?? 0; ?></h3>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CARD BARU: Total Riwayat -->
        <div class="col-md-6 col-lg-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50">Total Riwayat</h6>
                            <h3 class="mb-0"><?php echo $stats['total_riwayat'] ?? 0; ?></h3>
                        </div>
                        <i class="fas fa-history fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions YANG SUDAH DIPERBARUI -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                    <h5>Tambah Tamu Baru</h5>
                    <p class="text-muted">Catat kunjungan tamu baru</p>
                    <a href="index.php?action=tamu_create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Tamu
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-3x text-success mb-3"></i>
                    <h5>Lihat Data Tamu</h5>
                    <p class="text-muted">Kelola semua data tamu</p>
                    <a href="index.php?action=tamu" class="btn btn-success">
                        <i class="fas fa-list"></i> Data Tamu
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-history fa-3x text-info mb-3"></i>
                    <h5>Riwayat Pengunjung</h5>
                    <p class="text-muted">Lihat semua riwayat kunjungan</p>
                    <a href="index.php?action=tamu_riwayat" class="btn btn-info">
                        <i class="fas fa-history"></i> Lihat Riwayat
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-3x text-warning mb-3"></i>
                    <h5>Pengunjung Selesai</h5>
                    <p class="text-muted">Tamu yang sudah selesai</p>
                    <a href="index.php?action=tamu_selesai" class="btn btn-warning">
                        <i class="fas fa-check"></i> Lihat Selesai
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tamu Aktif Terbaru -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Tamu Aktif Terbaru (5 Data)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($recentTamu)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data kunjungan.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-user"></i> Nama</th>
                                        <th><i class="fas fa-building"></i> Instansi</th>
                                        <th><i class="fas fa-calendar"></i> Tanggal</th>
                                        <th><i class="fas fa-clock"></i> Waktu Masuk</th>
                                        <th><i class="fas fa-check-circle"></i> Status</th>
                                        <th><i class="fas fa-cogs"></i> Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentTamu as $tamu): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($tamu->getNama()); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($tamu->getInstansi()); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($tamu->getTanggalKunjungan())); ?></td>
                                        <td><?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?></td>
                                        <td>
                                            <?php if ($tamu->getStatus() === 'aktif'): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-circle"></i> Aktif
                                                </span>
                                            <?php elseif ($tamu->getStatus() === 'selesai'): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Selesai
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-times"></i> Keluar
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="index.php?action=tamu_show&id=<?php echo $tamu->getId(); ?>" 
                                                   class="btn btn-info" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Lihat detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <!-- Button ubah status selesai (Admin only) -->
                                                <?php if ($isAdmin && $tamu->getStatus() === 'aktif'): ?>
                                                    <form method="POST" action="index.php?action=dashboard_update_status" style="display:inline;">
                                                        <input type="hidden" name="id" value="<?php echo $tamu->getId(); ?>">
                                                        <button type="submit" 
                                                                class="btn btn-success" 
                                                                data-bs-toggle="tooltip"
                                                                title="Ubah status menjadi selesai"
                                                                onclick="return confirm('Ubah status menjadi selesai?')">
                                                            <i class="fas fa-check"></i> Selesai
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <a href="index.php?action=tamu_aktif" class="btn btn-primary">
                                <i class="fas fa-arrow-right"></i> Lihat Semua Tamu Aktif
                            </a>
                            <a href="index.php?action=tamu_riwayat" class="btn btn-outline-secondary">
                                <i class="fas fa-history"></i> Lihat Riwayat
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Kategori YANG SUDAH DIPERBARUI -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie"></i> Distribusi Kategori Tamu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h6 class="text-primary"><?php echo $stats['orang_tua'] ?? 0; ?></h6>
                                <small>Orang Tua</small>
                                <div class="progress mt-2" style="height: 5px;">
                                    <?php 
                                    $total = $stats['total_tamu'] ?? 1;
                                    $percentage = $total > 0 ? round(($stats['orang_tua'] ?? 0) / $total * 100, 1) : 0;
                                    ?>
                                    <div class="progress-bar bg-primary" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $percentage; ?>%</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h6 class="text-success"><?php echo $stats['calon_siswa'] ?? 0; ?></h6>
                                <small>Calon Siswa</small>
                                <div class="progress mt-2" style="height: 5px;">
                                    <?php 
                                    $percentage = $total > 0 ? round(($stats['calon_siswa'] ?? 0) / $total * 100, 1) : 0;
                                    ?>
                                    <div class="progress-bar bg-success" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $percentage; ?>%</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h6 class="text-info"><?php echo $stats['mahasiswa'] ?? 0; ?></h6>
                                <small>Mahasiswa</small>
                                <div class="progress mt-2" style="height: 5px;">
                                    <?php 
                                    $percentage = $total > 0 ? round(($stats['mahasiswa'] ?? 0) / $total * 100, 1) : 0;
                                    ?>
                                    <div class="progress-bar bg-info" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $percentage; ?>%</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="border rounded p-3">
                                <h6 class="text-warning"><?php echo $stats['lainnya'] ?? 0; ?></h6>
                                <small>Lainnya</small>
                                <div class="progress mt-2" style="height: 5px;">
                                    <?php 
                                    $percentage = $total > 0 ? round(($stats['lainnya'] ?? 0) / $total * 100, 1) : 0;
                                    ?>
                                    <div class="progress-bar bg-warning" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo $percentage; ?>%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Login Sebagai:</small>
                            <p><strong><?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Tanggal Hari Ini:</small>
                            <p><strong><?php echo date('d F Y'); ?></strong></p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">Statistik Kunjungan:</small>
                        <p>
                            <strong><?php echo $stats['total_tamu'] ?? 0; ?> tamu</strong> terdaftar<br>
                            <strong><?php echo $stats['tamu_aktif'] ?? 0; ?> aktif</strong>, 
                            <strong><?php echo $stats['tamu_selesai'] ?? 0; ?> selesai</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>