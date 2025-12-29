<?php
require_once 'config.php';

// Check if system is installed
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
$count = $stmt->fetch()['count'];

if ($count > 0 && !isset($_GET['force'])) {
    die("<h3>Sistem Zaten Kurulu!</h3><p><a href='admin/index.php'>Admin Paneline Git</a></p>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hash]);

        $success = "Kurulum Başarılı! <a href='admin/login.php'>Giriş Yap</a>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>BetPro Kurulum</title>
    <style>
        body { font-family: sans-serif; background: #1a1a1a; color: white; display:flex; justify-content:center; align-items:center; height:100vh; }
        .box { background: #2d2d2d; padding: 30px; border-radius: 8px; width: 350px; text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 4px; }
        button { background: #00b894; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;}
        h2 { color: #00b894; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Sistem Kurulumu</h2>
        <?php if(isset($success)) echo "<p style='color:#00b894'>$success</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Admin Kullanıcı Adı" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <button type="submit">Kurulumu Tamamla</button>
        </form>
    </div>
</body>
</html>
