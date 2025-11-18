<?php
$title = "Data Tamu - Buku Tamu Digital";
$current_page = 'tamu';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users"></i> Data Tamu
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="index.php?action=tamu_create" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Tamu
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
                           placeholder="Cari berdasarkan nama, instansi, email...">
                </div>
            </div>
            <div class="col-md-6 text-muted text-end">
                <small id="recordCount">Total: <span id="totalRecords">0</span> data</small>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <?php if (empty($tamuList)): ?>
            <div class="text-center py-5">
                <i class="fas fa-users fa-5x text-muted mb-3"></i>
                <h5>Belum ada data tamu</h5>
                <p class="text-muted mb-3">Mulai dengan menambahkan data tamu baru ke sistem.</p>
                <a href="index.php?action=tamu_create" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Tambah Tamu Pertama
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tamuTable">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 20%;">Nama</th>
                            <th style="width: 20%;">Instansi</th>
                            <th style="width: 15%;">Kategori</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 12%;">Waktu</th>
                            <th style="width: 8%;">Status</th>
                            <th style="width: 8%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tamuList as $index => $tamu): ?>
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
                                    'orang_tua' => 'fa-parent',
                                    'calon_siswa' => 'fa-graduation-cap',
                                    'mahasiswa' => 'fa-book',
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
                                <i class="fas fa-clock text-info"></i>
                                <?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?>
                                <?php if ($tamu->getWaktuKeluar()): ?>
                                    <br><small class="text-muted">- <?php echo date('H:i', strtotime($tamu->getWaktuKeluar())); ?></small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($tamu->getWaktuKeluar() === null): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times"></i> Selesai
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="index.php?action=tamu_show&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-info" 
                                       data-bs-toggle="tooltip"
                                       title="Lihat detail tamu">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-warning" 
                                       data-bs-toggle="tooltip"
                                       title="Edit data tamu">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?action=tamu_delete&id=<?php echo $tamu->getId(); ?>" 
                                       class="btn btn-danger" 
                                       data-bs-toggle="tooltip"
                                       title="Hapus data tamu"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data tamu ini?')">
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
                // Setup search filter untuk tabel tamu
                setupTableFilter('searchInput', 'tamuTable');
                
                // Update total records
                function updateRecordCount() {
                    const table = document.getElementById('tamuTable');
                    const visibleRows = Array.from(table.querySelectorAll('tbody tr:not(.no-results)'))
                        .filter(row => row.style.display !== 'none').length;
                    document.getElementById('totalRecords').textContent = visibleRows;
                }
                
                // Observer untuk update count
                const observer = new MutationObserver(updateRecordCount);
                observer.observe(document.getElementById('tamuTable').querySelector('tbody'), 
                    { attributes: true, subtree: true });
                
                updateRecordCount();
            </script>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>