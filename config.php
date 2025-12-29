<?php
session_start();

// Database Configuration
define('DB_PATH', __DIR__ . '/data/database.sqlite');

try {
    // Create data directory if not exists
    if (!file_exists(dirname(DB_PATH))) {
        mkdir(dirname(DB_PATH), 0777, true);
    }

    $pdo = new PDO("sqlite:" . DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Auto-create Tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS coupons (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        type TEXT, -- Banko, Popüler, Sistem, Tekli
        total_odds REAL,
        confidence INTEGER, -- 1 to 100
        status TEXT DEFAULT 'pending', -- pending, won, lost
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS matches (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        coupon_id INTEGER,
        home_team TEXT,
        away_team TEXT,
        league TEXT,
        match_time TEXT,
        prediction TEXT,
        odds REAL,
        FOREIGN KEY(coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
    )");

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}

// Localization Logic
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'tr';
$lang_file = __DIR__ . "/lang/{$current_lang}.php";

if (file_exists($lang_file)) {
    $lang = require $lang_file;
} else {
    $lang = require __DIR__ . "/lang/tr.php"; // Fallback
}

function __($key) {
    global $lang;
    return isset($lang[$key]) ? $lang[$key] : $key;
}

// Helper: Check Admin
function check_admin() {
    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: login.php");
        exit;
    }
}
