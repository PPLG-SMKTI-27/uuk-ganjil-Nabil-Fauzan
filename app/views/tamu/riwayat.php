<?php
$title = "Riwayat Pengunjung - Buku Tamu Digital";
$current_page = 'tamu_riwayat';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="fas fa-history"></i> Riwayat Pengunjung
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="index.php?action=tamu" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="index.php?action=tamu_selesai" class="btn btn-success">
            <i class="fas fa-check-circle"></i> Lihat Yang Selesai
        </a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-light">
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           id="searchInput" 
                           class="form-control" 
                           placeholder="Cari riwayat pengunjung...">
                </div>
            </div>
            <div class="col-md-6 text-muted text-end">
                <small>Total: <span id="totalRecords"><?php echo count($riwayatTamu); ?></span> data riwayat</small>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (empty($riwayatTamu)): ?>
            <div class="text-center py-5">
                <i class="fas fa-history fa-5x text-muted mb-3"></i>
                <h5>Belum ada riwayat pengunjung</h5>
                <p class="text-muted mb-3">Riwayat akan muncul setelah tamu menyelesaikan kunjungan.</p>
                <a href="index.php?action=tamu" class="btn btn-primary">
                    <i class="fas fa-users"></i> Lihat Data Tamu
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="riwayatTable">
                    <thead class="table-info">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 15%;">Instansi</th>
                            <th style="width: 12%;">Kategori</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 15%;">Waktu</th>
                            <th style="width: 8%;">Status</th>
                            <th style="width: 13%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayatTamu as $index => $tamu): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($tamu->getNama()); ?></strong>
                                <?php if ($tamu->getEmail()): ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope"></i> 
                                        <?php echo htmlspecialchars($tamu->getEmail()); ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <i class="fas fa-building text-muted"></i>
                                <?php echo htmlspecialchars($tamu->getInstansi()); ?>
                            </td>
                            <td>
                                <?php
                                $kategoriLabels = [
                                    'orang_tua' => 'Orang Tua',
                                    'calon_siswa' => 'Calon Siswa', 
                                    'mahasiswa' => 'Mahasiswa',
                                    'lainnya' => 'Lainnya'
                                ];
                                $kategoriIcons = [
                                    'orang_tua' => 'fa-user-friends',
                                    'calon_siswa' => 'fa-graduation-cap',
                                    'mahasiswa' => 'fa-user-graduate',
                                    'lainnya' => 'fa-user'
                                ];
                                $kategori = $tamu->getKategori();
                                ?>
                                <i class="fas <?php echo $kategoriIcons[$kategori] ?? 'fa-user'; ?> text-primary"></i>
                                <?php echo $kategoriLabels[$kategori] ?? $kategori; ?>
                            </td>
                            <td>
                                <i class="fas fa-calendar text-secondary"></i>
                                <?php echo date('d/m/Y', strtotime($tamu->getTanggalKunjungan())); ?>
                            </td>
                            <td>
                                <i class="fas fa-sign-in-alt text-success"></i>
                                <?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?>
                                <?php if ($tamu->getWaktuKeluar()): ?>
                                    <br>
                                    <i class="fas fa-sign-out-alt text-danger"></i>
                                    <?php echo date('H:i', strtotime($tamu->getWaktuKeluar())); ?>
                                    <?php
                                    $masuk = new DateTime($tamu->getWaktuMasuk());
                                    $keluar = new DateTime($tamu->getWaktuKeluar());
                                    $durasi = $masuk->diff($keluar);
                                    ?>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        <?php echo $durasi->h . 'j ' . $durasi->i . 'm'; ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($tamu->getStatus() === 'selesai'): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                <?php elseif ($tamu->getWaktuKeluar()): ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-door-closed"></i> Keluar
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Aktif
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
                                    <?php if ($tamu->getStatus() !== 'selesai' && $tamu->getWaktuKeluar()): ?>
                                        <form method="POST" action="index.php?action=tamu_update_status&id=<?php echo $tamu->getId(); ?>" style="display:inline;">
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit" 
                                                    class="btn btn-success" 
                                                    data-bs-toggle="tooltip"
                                                    title="Tandai sebagai selesai"
                                                    onclick="return confirm('Tandai kunjungan sebagai selesai?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <a href="index.php?action=tamu_delete&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-danger" 
                                       data-bs-toggle="tooltip"
                                       title="Hapus data"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data riwayat ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <script>
                // Setup search filter untuk tabel riwayat
                setupTableFilter('searchInput', 'riwayatTable');
            </script>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>