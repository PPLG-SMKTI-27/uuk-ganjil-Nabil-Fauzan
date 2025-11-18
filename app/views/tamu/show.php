<?php
$title = "Detail Tamu - Buku Tamu Digital";
$current_page = 'tamu';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user"></i> Detail Data Tamu
    </h1>
    <div>
        <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="index.php?action=tamu" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Nama Lengkap</th>
                                <td><?php echo htmlspecialchars($tamu->getNama()); ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <?php if ($tamu->getEmail()): ?>
                                        <?php echo htmlspecialchars($tamu->getEmail()); ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>
                                    <?php if ($tamu->getTelepon()): ?>
                                        <?php echo htmlspecialchars($tamu->getTelepon()); ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Instansi</th>
                                <td><?php echo htmlspecialchars($tamu->getInstansi()); ?></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td>
                                    <?php
                                    $kategoriLabels = [
                                        'orang_tua' => 'Orang Tua Siswa',
                                        'calon_siswa' => 'Calon Siswa',
                                        'mahasiswa' => 'Mahasiswa', 
                                        'lainnya' => 'Lainnya'
                                    ];
                                    echo $kategoriLabels[$tamu->getKategori()] ?? $tamu->getKategori();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($tamu->getWaktuKeluar() === null): ?>
                                        <span class="badge bg-success">Sedang Berkunjung</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Selesai Berkunjung</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Kunjungan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Tanggal Kunjungan</th>
                                <td><?php echo date('d F Y', strtotime($tamu->getTanggalKunjungan())); ?></td>
                            </tr>
                            <tr>
                                <th>Waktu Masuk</th>
                                <td><?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Waktu Keluar</th>
                                <td>
                                    <?php if ($tamu->getWaktuKeluar()): ?>
                                        <?php echo date('H:i', strtotime($tamu->getWaktuKeluar())); ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>
                                    <?php if ($tamu->getWaktuKeluar()): ?>
                                        <?php
                                        $masuk = new DateTime($tamu->getWaktuMasuk());
                                        $keluar = new DateTime($tamu->getWaktuKeluar());
                                        $durasi = $masuk->diff($keluar);
                                        echo $durasi->h . ' jam ' . $durasi->i . ' menit';
                                        ?>
                                    <?php else: ?>
                                        <span class="text-muted">Masih berkunjung</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="mt-3">
                    <strong>Keperluan:</strong>
                    <p class="mt-2"><?php echo nl2br(htmlspecialchars($tamu->getKeperluan())); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Timeline</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6>Check-in</h6>
                            <p class="text-muted mb-0">
                                <?php echo date('d F Y', strtotime($tamu->getTanggalKunjungan())); ?><br>
                                <?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($tamu->getWaktuKeluar()): ?>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6>Check-out</h6>
                            <p class="text-muted mb-0">
                                <?php echo date('d F Y', strtotime($tamu->getTanggalKunjungan())); ?><br>
                                <?php echo date('H:i', strtotime($tamu->getWaktuKeluar())); ?>
                            </p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <?php if ($tamu->getWaktuKeluar() === null): ?>
                        <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" 
                           class="btn btn-success">
                            <i class="fas fa-sign-out-alt"></i> Set Check-out
                        </a>
                    <?php endif; ?>
                    <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Data
                    </a>
                    <a href="index.php?action=tamu_delete&id=<?php echo $tamu->getId(); ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Apakah Anda yakin ingin menghapus data tamu ini?')">
                        <i class="fas fa-trash"></i> Hapus Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>