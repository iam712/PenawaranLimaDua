<?php
// app/models/User.php
namespace App\Models;

use PDO;

class User {
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findUserByUsername($username) {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
