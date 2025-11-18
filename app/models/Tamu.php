<?php
require_once 'Database.php';

class Tamu {
    private $id;
    private $nama;
    private $email;
    private $telepon;
    private $instansi;
    private $keperluan;
    private $kategori;
    private $tanggal_kunjungan;
    private $waktu_masuk;
    private $waktu_keluar;
    private $status;
    private $created_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nama = $data['nama'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->telepon = $data['telepon'] ?? '';
        $this->instansi = $data['instansi'] ?? '';
        $this->keperluan = $data['keperluan'] ?? '';
        $this->kategori = $data['kategori'] ?? '';
        $this->tanggal_kunjungan = $data['tanggal_kunjungan'] ?? '';
        $this->waktu_masuk = $data['waktu_masuk'] ?? '';
        $this->waktu_keluar = $data['waktu_keluar'] ?? '';
        $this->status = $data['status'] ?? 'aktif';
        $this->created_at = $data['created_at'] ?? '';
    }

    // ===== GETTER METHODS =====
    public function getId() {
        return $this->id;
    }

    public function getNama() {
        return $this->nama;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelepon() {
        return $this->telepon;
    }

    public function getInstansi() {
        return $this->instansi;
    }

    public function getKeperluan() {
        return $this->keperluan;
    }

    public function getKategori() {
        return $this->kategori;
    }

    public function getTanggalKunjungan() {
        return $this->tanggal_kunjungan;
    }

    public function getWaktuMasuk() {
        return $this->waktu_masuk;
    }

    public function getWaktuKeluar() {
        return $this->waktu_keluar;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    // ===== SETTER METHODS =====
    public function setNama($nama) {
        $this->nama = $nama;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelepon($telepon) {
        $this->telepon = $telepon;
    }

    public function setInstansi($instansi) {
        $this->instansi = $instansi;
    }

    public function setKeperluan($keperluan) {
        $this->keperluan = $keperluan;
    }

    public function setKategori($kategori) {
        $this->kategori = $kategori;
    }

    public function setTanggalKunjungan($tanggal) {
        $this->tanggal_kunjungan = $tanggal;
    }

    public function setWaktuMasuk($waktu) {
        $this->waktu_masuk = $waktu;
    }

    public function setWaktuKeluar($waktu) {
        $this->waktu_keluar = $waktu;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
}

class TamuModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // CREATE
    public function create(Tamu $tamu) {
        $stmt = $this->db->prepare("
            INSERT INTO tamu (nama, email, telepon, instansi, keperluan, kategori, tanggal_kunjungan, waktu_masuk, status)
            VALUES (:nama, :email, :telepon, :instansi, :keperluan, :kategori, :tanggal_kunjungan, :waktu_masuk, :status)
        ");

        return $stmt->execute([
            ':nama' => $tamu->getNama(),
            ':email' => $tamu->getEmail(),
            ':telepon' => $tamu->getTelepon(),
            ':instansi' => $tamu->getInstansi(),
            ':keperluan' => $tamu->getKeperluan(),
            ':kategori' => $tamu->getKategori(),
            ':tanggal_kunjungan' => $tamu->getTanggalKunjungan(),
            ':waktu_masuk' => $tamu->getWaktuMasuk(),
            ':status' => $tamu->getStatus()
        ]);
    }

    // READ - Semua tamu
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM tamu ORDER BY tanggal_kunjungan DESC, waktu_masuk DESC");
        $result = $stmt->fetchAll();
        return array_map(function($row) {
            return new Tamu($row);
        }, $result);
    }

    // READ - Tamu yang sedang aktif (belum keluar)
    public function getAktif() {
        $stmt = $this->db->query("
            SELECT * FROM tamu 
            WHERE status = 'aktif' 
            ORDER BY waktu_masuk DESC
        ");
        $result = $stmt->fetchAll();
        return array_map(function($row) {
            return new Tamu($row);
        }, $result);
    }

    // READ - Riwayat tamu (yang sudah selesai/keluar)
    public function getRiwayat() {
        $stmt = $this->db->query("
            SELECT * FROM tamu 
            WHERE status = 'selesai' OR waktu_keluar IS NOT NULL
            ORDER BY tanggal_kunjungan DESC, waktu_masuk DESC
        ");
        $result = $stmt->fetchAll();
        return array_map(function($row) {
            return new Tamu($row);
        }, $result);
    }

    // READ - Tamu dengan status selesai
        public function getSelesai() {
            $stmt = $this->db->query("
                SELECT * FROM tamu 
                WHERE status = 'selesai'
                ORDER BY tanggal_kunjungan DESC, waktu_masuk DESC
            ");
            $result = $stmt->fetchAll();
            return array_map(function($row) {
                return new Tamu($row);
            }, $result);
    }

    // READ - By ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tamu WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ? new Tamu($row) : null;
    }

    // UPDATE - Data tamu
    public function update(Tamu $tamu) {
        $stmt = $this->db->prepare("
            UPDATE tamu 
            SET nama = :nama, email = :email, telepon = :telepon, 
                instansi = :instansi, keperluan = :keperluan, 
                kategori = :kategori, status = :status
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $tamu->getId(),
            ':nama' => $tamu->getNama(),
            ':email' => $tamu->getEmail(),
            ':telepon' => $tamu->getTelepon(),
            ':instansi' => $tamu->getInstansi(),
            ':keperluan' => $tamu->getKeperluan(),
            ':kategori' => $tamu->getKategori(),
            ':status' => $tamu->getStatus()
        ]);
    }

    // UPDATE - Status tamu (aktif/keluar)
    public function updateStatus($id, $status, $waktu_keluar = null) {
        $stmt = $this->db->prepare("
            UPDATE tamu 
            SET status = :status, waktu_keluar = :waktu_keluar
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':status' => $status,
            ':waktu_keluar' => $waktu_keluar ?: date('H:i:s')
        ]);
    }

    // STATS
    public function getStats() {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total_tamu,
                COUNT(CASE WHEN status = 'aktif' THEN 1 END) as tamu_aktif,
                COUNT(CASE WHEN status = 'selesai' THEN 1 END) as tamu_selesai,
                COUNT(CASE WHEN waktu_keluar IS NOT NULL THEN 1 END) as total_riwayat,
                COUNT(CASE WHEN kategori = 'orang_tua' THEN 1 END) as orang_tua,
                COUNT(CASE WHEN kategori = 'calon_siswa' THEN 1 END) as calon_siswa,
                COUNT(CASE WHEN kategori = 'mahasiswa' THEN 1 END) as mahasiswa,
                COUNT(CASE WHEN kategori = 'lainnya' THEN 1 END) as lainnya
            FROM tamu
        ");
        return $stmt->fetch();
    }
    
    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tamu WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
?>