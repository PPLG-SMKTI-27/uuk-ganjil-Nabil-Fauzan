<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Tamu yang Sedang Berada</h2>
            <p class="text-muted">Daftar pengunjung yang masih berada di lokasi</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if (empty($tamuAktif)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Tidak ada tamu yang sedang berada.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Instansi</th>
                                        <th>Kategori</th>
                                        <th>Waktu Masuk</th>
                                        <th>Durasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tamuAktif as $index => $tamu): ?>
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
                                            <?php
                                            $kategoriLabels = [
                                                'orang_tua' => 'Orang Tua',
                                                'calon_siswa' => 'Calon Siswa',
                                                'mahasiswa' => 'Mahasiswa',
                                                'lainnya' => 'Lainnya'
                                            ];
                                            echo $kategoriLabels[$tamu->getKategori()] ?? $tamu->getKategori();
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo date('H:i', strtotime($tamu->getWaktuMasuk())); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $waktuMasuk = new DateTime($tamu->getTanggalKunjungan() . ' ' . $tamu->getWaktuMasuk());
                                            $sekarang = new DateTime();
                                            $durasi = $sekarang->diff($waktuMasuk);
                                            echo $durasi->h . 'j ' . $durasi->i . 'm';
                                            ?>
                                        </td>
                                        <td>
                                            <a href="index.php?action=tamu_show&id=<?php echo $tamu->getId(); ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                            <form method="POST" action="index.php?action=tamu_update_status&id=<?php echo $tamu->getId(); ?>" style="display:inline;">
                                                <input type="hidden" name="status" value="keluar">
                                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Tandai tamu sebagai keluar?')">
                                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                                </button>
                                            </form>
                                            <a href="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="index.php?action=tamu_delete&id=<?php echo $tamu->getId(); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data tamu?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <a href="index.php?action=tamu_create" class="btn btn-primary">
                <i class="bi bi-plus"></i> Tambah Tamu
            </a>
            <a href="index.php?action=tamu" class="btn btn-secondary">
                <i class="bi bi-list"></i> Lihat Semua Tamu
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>