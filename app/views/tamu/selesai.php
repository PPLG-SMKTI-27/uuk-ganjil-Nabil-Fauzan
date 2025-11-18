<?php
$title = "Pengunjung Selesai - Buku Tamu Digital";
$current_page = 'tamu_selesai';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="fas fa-check-circle"></i> Pengunjung Selesai
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="index.php?action=tamu_riwayat" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=tamu" class="btn btn-primary">
            <i class="fas fa-users"></i> Data Tamu
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success">
            <i class="fas fa-info-circle"></i>
            <strong>Pengunjung Selesai</strong> - Tamu yang telah menyelesaikan kunjungan dan proses administrasinya.
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-success text-white">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">
                    <i class="fas fa-list-check"></i> Daftar Pengunjung Selesai
                </h5>
            </div>
            <div class="col-md-6 text-end">
                <small>Total: <?php echo count($tamuSelesai); ?> pengunjung selesai</small>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (empty($tamuSelesai)): ?>
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-5x text-muted mb-3"></i>
                <h5>Belum ada pengunjung selesai</h5>
                <p class="text-muted mb-3">Pengunjung akan muncul di sini setelah ditandai sebagai selesai.</p>
                <a href="index.php?action=tamu_riwayat" class="btn btn-primary">
                    <i class="fas fa-history"></i> Lihat Riwayat
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Waktu Kunjungan</th>
                            <th>Durasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tamuSelesai as $index => $tamu): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($tamu->getNama()); ?></strong>
                                <?php if ($tamu->getEmail()): ?>
                                    <br><small class="text-muted"><?php echo htmlspecialchars($tamu->getEmail()); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($tamu->getInstansi()); ?></td>
                            <td>
                                <span class="badge bg-primary">
                                    <?php
                                    $kategoriLabels = [
                                        'orang_tua' => 'Orang Tua',
                                        'calon_siswa' => 'Calon Siswa',
                                        'mahasiswa' => 'Mahasiswa',
                                        'lainnya' => 'Lainnya'
                                    ];
                                    echo $kategoriLabels[$tamu->getKategori()] ?? $tamu->getKategori();
                                    ?>
                                </span>
                            </td>
                            <td>
                                <i class="fas fa-calendar text-muted"></i>
                                <?php echo date('d/m/Y', strtotime($tamu->getTanggalKunjungan())); ?>
                            </td>
                            <td>
                                <small>
                                    <i class="fas fa-sign-in-alt text-success"></i>
                                    <?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?>
                                    <br>
                                    <i class="fas fa-sign-out-alt text-danger"></i>
                                    <?php echo date('H:i', strtotime($tamu->getWaktuKeluar())); ?>
                                </small>
                            </td>
                            <td>
                                <?php
                                $masuk = new DateTime($tamu->getWaktuMasuk());
                                $keluar = new DateTime($tamu->getWaktuKeluar());
                                $durasi = $masuk->diff($keluar);
                                ?>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-clock"></i>
                                    <?php echo $durasi->h . 'j ' . $durasi->i . 'm'; ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?action=tamu_show&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Statistik Selesai -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik Pengunjung Selesai</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <?php
                                $kategoriCount = [];
                                foreach ($tamuSelesai as $tamu) {
                                    $kategori = $tamu->getKategori();
                                    $kategoriCount[$kategori] = ($kategoriCount[$kategori] ?? 0) + 1;
                                }
                                
                                $kategoriLabels = [
                                    'orang_tua' => 'Orang Tua',
                                    'calon_siswa' => 'Calon Siswa',
                                    'mahasiswa' => 'Mahasiswa',
                                    'lainnya' => 'Lainnya'
                                ];
                                
                                foreach ($kategoriLabels as $key => $label): 
                                    $count = $kategoriCount[$key] ?? 0;
                                    $percentage = count($tamuSelesai) > 0 ? round(($count / count($tamuSelesai)) * 100, 1) : 0;
                                ?>
                                <div class="col-3">
                                    <div class="border rounded p-3">
                                        <h6 class="text-primary"><?php echo $count; ?></h6>
                                        <small><?php echo $label; ?></small>
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar" style="width: <?php echo $percentage; ?>%"></div>
                                        </div>
                                        <small class="text-muted"><?php echo $percentage; ?>%</small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>