<?php
require_once __DIR__ . '/../models/Tamu.php';
require_once __DIR__ . '/../models/User.php';

class TamuController {
    private $tamuModel;
    private $authController;

    public function __construct() {
        $this->tamuModel = new TamuModel();
        $this->authController = new AuthController();
    }

    // Halaman daftar semua tamu
    public function index() {
        $this->authController->checkAuth();
        $recentTamu = $this->tamuModel->getAll();
        require_once __DIR__ . '/../views/tamu/index.php';
    }

    // Halaman tamu yang sedang aktif (belum keluar)
    public function aktif() {
        $this->authController->checkAuth();
        $tamuAktif = $this->tamuModel->getAktif();
        require_once __DIR__ . '/../views/tamu/aktif.php';
    }

    // Halaman riwayat tamu (semua tamu yang sudah selesai)
    public function riwayat() {
        $this->authController->checkAuth();
        $riwayatTamu = $this->tamuModel->getRiwayat();
        require_once __DIR__ . '/../views/tamu/riwayat.php';
    }

    // Halaman tamu dengan status selesai
    public function selesai() {
        $this->authController->checkAuth();
        $tamuSelesai = $this->tamuModel->getSelesai();
        require_once __DIR__ . '/../views/tamu/selesai.php';
    }

    // Lihat detail tamu
    public function show($id) {
        $this->authController->checkAuth();
        $tamu = $this->tamuModel->getById($id);
        if (!$tamu) {
            header('Location: index.php?action=tamu');
            exit;
        }
        require_once __DIR__ . '/../views/tamu/show.php';
    }

    // Form tambah tamu
    public function create() {
        $this->authController->checkAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tamu = new Tamu([
                'nama' => $_POST['nama'] ?? '',
                'email' => $_POST['email'] ?? '',
                'telepon' => $_POST['telepon'] ?? '',
                'instansi' => $_POST['instansi'] ?? '',
                'keperluan' => $_POST['keperluan'] ?? '',
                'kategori' => $_POST['kategori'] ?? '',
                'tanggal_kunjungan' => $_POST['tanggal_kunjungan'] ?? date('Y-m-d'),
                'waktu_masuk' => date('H:i:s'),
                'status' => 'aktif'
            ]);

            if ($this->tamuModel->create($tamu)) {
                header('Location: index.php?action=tamu_aktif');
                exit;
            } else {
                $error = "Gagal menambah data tamu!";
            }
        }
        require_once __DIR__ . '/../views/tamu/create.php';
    }

    // Form edit tamu
    public function edit($id) {
        $this->authController->checkAuth();
        $tamu = $this->tamuModel->getById($id);
        
        if (!$tamu) {
            header('Location: index.php?action=tamu');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tamu->setNama($_POST['nama'] ?? '');
            $tamu->setEmail($_POST['email'] ?? '');
            $tamu->setTelepon($_POST['telepon'] ?? '');
            $tamu->setInstansi($_POST['instansi'] ?? '');
            $tamu->setKeperluan($_POST['keperluan'] ?? '');
            $tamu->setKategori($_POST['kategori'] ?? '');

            if ($this->tamuModel->update($tamu)) {
                header('Location: index.php?action=tamu');
                exit;
            } else {
                $error = "Gagal mengubah data tamu!";
            }
        }
        require_once __DIR__ . '/../views/tamu/edit.php';
    }

    // Update status tamu (aktif → keluar)
    public function updateStatus($id) {
        $this->authController->checkAuth();
        $status = $_POST['status'] ?? 'aktif';
        
        if ($this->tamuModel->updateStatus($id, $status)) {
            header('Location: index.php?action=tamu_aktif');
            exit;
        } else {
            $error = "Gagal mengubah status tamu!";
            $tamu = $this->tamuModel->getById($id);
            require_once __DIR__ . '/../views/tamu/aktif.php';
        }
    }

    // Hapus tamu
    public function delete($id) {
        $this->authController->checkAuth();
        
        if ($this->tamuModel->delete($id)) {
            header('Location: index.php?action=tamu');
            exit;
        }
    }
}
?>