<?php
require_once 'Database.php';

abstract class User {
    protected $id;
    protected $username;
    protected $email;
    protected $role;
    protected $created_at;

    public function __construct($id, $username, $email, $role, $created_at) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->role = $role;
        $this->created_at = $created_at;
    }

    // Getter methods dengan encapsulation
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    abstract public function getDashboardUrl();
}

class Admin extends User {
    public function __construct($id, $username, $email, $created_at) {
        parent::__construct($id, $username, $email, 'admin', $created_at);
    }

    public function getDashboardUrl() {
        return 'dashboard.php';
    }
}

class Staff extends User {
    public function __construct($id, $username, $email, $created_at) {
        parent::__construct($id, $username, $email, 'staff', $created_at);
    }

    public function getDashboardUrl() {
        return 'dashboard.php';
    }
}

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, md5($password)]);
        $userData = $stmt->fetch();

        if ($userData) {
            if ($userData['role'] === 'admin') {
                return new Admin($userData['id'], $userData['username'], $userData['email'], $userData['created_at']);
            } else {
                return new Staff($userData['id'], $userData['username'], $userData['email'], $userData['created_at']);
            }
        }
        return null;
    }

    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $userData = $stmt->fetch();

        if ($userData) {
            if ($userData['role'] === 'admin') {
                return new Admin($userData['id'], $userData['username'], $userData['email'], $userData['created_at']);
            } else {
                return new Staff($userData['id'], $userData['username'], $userData['email'], $userData['created_at']);
            }
        }
        return null;
    }
}
?>