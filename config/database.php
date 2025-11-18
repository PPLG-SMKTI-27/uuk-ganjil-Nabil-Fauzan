<?php
class DatabaseConfig {
    private $host = 'localhost';
    private $db_name = 'buku_tamu_digital';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';

    public function getConfig() {
        return [
            'host' => $this->host,
            'db_name' => $this->db_name,
            'username' => $this->username,
            'password' => $this->password,
            'charset' => $this->charset
        ];
    }
}
?>