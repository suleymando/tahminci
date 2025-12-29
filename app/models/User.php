<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        $stmt = $this->db->query("SELECT * FROM users WHERE username = :username", ['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function create($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->db->query("INSERT INTO users (username, password) VALUES (:username, :password)", [
            'username' => $username,
            'password' => $hash
        ]);
    }

    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
        return $stmt->fetch()['count'];
    }
}
