<?php
// install.php - Root level installer wrapper

// Define basic constants if needed by your App
define('ROOT', __DIR__);

// Route to the InstallController
require_once 'app/core/Database.php';
require_once 'app/core/Controller.php';
require_once 'app/core/App.php';
require_once 'app/models/User.php';

// Check if user table exists and has users
$db = new Database();
$stmt = $db->query("SELECT COUNT(*) as count FROM users");
$count = $stmt->fetch()['count'];

if ($count > 0 && !isset($_GET['force'])) {
    die("<h3>Sistem zaten kurulu!</h3><p>Admin paneline gitmek için <a href='/admin'>tıklayın</a>.</p>");
}

// Logic from InstallController inline for standalone usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Create User
        // Re-using User model logic manually since we are outside MVC router
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $db->query("INSERT INTO users (username, password) VALUES (:user, :pass)", [
            'user' => $username,
            'pass' => $passwordHash
        ]);

        $success = "Kurulum Başarılı! Yönetim paneline giriş yapabilirsiniz.";
    } else {
        $error = "Lütfen tüm alanları doldurun.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>BetPro Installer</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #2c3e50; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .box { background: white; color: #333; padding: 40px; border-radius: 8px; width: 400px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); text-align: center; }
        h2 { color: #00904a; margin-top: 0; }
        input { width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #00904a; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background: #007a3e; }
        .success { color: green; margin-bottom: 20px; font-weight: bold; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="box">
        <h2>BetPro Kurulum Sihirbazı</h2>
        <?php if(isset($success)): ?>
            <div class='success'><?php echo $success; ?></div>
            <a href='index.php?url=admin/login' style="display:block; text-decoration:none;">
                <button>Admin Paneline Git</button>
            </a>
        <?php else: ?>
            <p>Yönetici hesabı oluşturun:</p>
            <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Admin Kullanıcı Adı" required>
                <input type="password" name="password" placeholder="Şifre" required>
                <button type="submit">Sistemi Kur</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
