<?php
$title = "Edit Tamu - Buku Tamu Digital";
$current_page = 'tamu';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit"></i> Edit Data Tamu
    </h1>
    <a href="index.php?action=tamu" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?action=tamu_edit&id=<?php echo $tamu->getId(); ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                               value="<?php echo htmlspecialchars($tamu->getNama()); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo htmlspecialchars($tamu->getEmail()); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon"
                               value="<?php echo htmlspecialchars($tamu->getTelepon()); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi/Perusahaan *</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required
                               value="<?php echo htmlspecialchars($tamu->getInstansi()); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori *</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="orang_tua" <?php echo $tamu->getKategori() == 'orang_tua' ? 'selected' : ''; ?>>Orang Tua Siswa</option>
                            <option value="calon_siswa" <?php echo $tamu->getKategori() == 'calon_siswa' ? 'selected' : ''; ?>>Calon Siswa</option>
                            <option value="mahasiswa" <?php echo $tamu->getKategori() == 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                            <option value="lainnya" <?php echo $tamu->getKategori() == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan *</label>
                        <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" required
                               value="<?php echo $tamu->getTanggalKunjungan(); ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                        <input type="time" class="form-control" id="waktu_masuk" name="waktu_masuk"
                               value="<?php echo $tamu->getWaktuMasuk(); ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="waktu_keluar" class="form-label">Waktu Keluar</label>
                        <input type="time" class="form-control" id="waktu_keluar" name="waktu_keluar"
                               value="<?php echo $tamu->getWaktuKeluar(); ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan *</label>
                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" required><?php echo htmlspecialchars($tamu->getKeperluan()); ?></textarea>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="index.php?action=tamu" class="btn btn-secondary me-md-2">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>