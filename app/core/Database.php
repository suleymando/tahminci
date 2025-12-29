<?php
// app/core/Database.php

class Database {
    private $pdo;

    public function __construct() {
        // Create data directory if not exists
        if (!file_exists(__DIR__ . '/../../data')) {
            mkdir(__DIR__ . '/../../data', 0777, true);
        }

        $dbPath = __DIR__ . '/../../data/database.sqlite';

        try {
            $this->pdo = new PDO("sqlite:" . $dbPath);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Initialize tables if needed
            $this->initTables();

        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    private function initTables() {
        // Users Table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // Settings Table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS settings (
            key TEXT PRIMARY KEY,
            value TEXT
        )");

        // Coupons Table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS coupons (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            type TEXT, -- Banko, Popular, etc.
            total_odds REAL,
            status TEXT DEFAULT 'pending', -- pending, won, lost
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )");

        // Matches Table
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS matches (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            coupon_id INTEGER,
            home_team TEXT,
            away_team TEXT,
            match_time TEXT,
            league TEXT,
            prediction TEXT,
            odds REAL,
            FOREIGN KEY(coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
        )");
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
