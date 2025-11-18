<?php
require_once __DIR__ . '/../../config/database.php';

class Database {
    private $connection;
    private static $instance = null;
    private $config;

    private function __construct() {
        $this->config = (new DatabaseConfig())->getConfig();
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db_name']};charset={$this->config['charset']}";
        
        try {
            $this->connection = new PDO($dsn, $this->config['username'], $this->config['password']);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    // Prevent cloning and unserialization
    private function __clone() {}
    public function __wakeup() {}
}
?>