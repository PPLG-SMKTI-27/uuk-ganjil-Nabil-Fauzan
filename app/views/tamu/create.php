<?php
$title = "Tambah Tamu - Buku Tamu Digital";
$current_page = 'tamu_create';
require_once __DIR__ . '/../templates/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-plus"></i> Tambah Data Tamu
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

        <form method="POST" action="index.php?action=tamu_create">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="nama" name="nama" required
                               value="<?php echo $_POST['nama'] ?? ''; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo $_POST['email'] ?? ''; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="tel" class="form-control" id="telepon" name="telepon"
                               value="<?php echo $_POST['telepon'] ?? ''; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="instansi" class="form-label">Instansi/Perusahaan *</label>
                        <input type="text" class="form-control" id="instansi" name="instansi" required
                               value="<?php echo $_POST['instansi'] ?? ''; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori *</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="orang_tua" <?php echo ($_POST['kategori'] ?? '') == 'orang_tua' ? 'selected' : ''; ?>>Orang Tua Siswa</option>
                            <option value="calon_siswa" <?php echo ($_POST['kategori'] ?? '') == 'calon_siswa' ? 'selected' : ''; ?>>Calon Siswa</option>
                            <option value="mahasiswa" <?php echo ($_POST['kategori'] ?? '') == 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                            <option value="lainnya" <?php echo ($_POST['kategori'] ?? '') == 'lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan *</label>
                        <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan" required
                               value="<?php echo $_POST['tanggal_kunjungan'] ?? date('Y-m-d'); ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan *</label>
                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" required
                          placeholder="Jelaskan keperluan kunjungan..."><?php echo $_POST['keperluan'] ?? ''; ?></textarea>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>