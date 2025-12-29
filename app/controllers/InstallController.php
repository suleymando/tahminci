<?php
class InstallController extends Controller {
    public function index() {
        // Simple Installation Logic
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $db = new Database(); // This triggers table creation

            $userModel = $this->model('User');

            // Check if user already exists
            if ($userModel->count() == 0) {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $userModel->create($username, $password);
                $success = "Kurulum Başarılı! Yönetim paneline giriş yapabilirsiniz.";
            } else {
                $error = "Sistem zaten kurulu.";
            }
        }

        // Render Install View (Inline for simplicity)
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>BetPro Installer</title>
            <style>
                body { font-family: sans-serif; background: #2c3e50; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; }
                .box { background: white; color: #333; padding: 40px; border-radius: 8px; width: 400px; }
                input { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; box-sizing: border-box; }
                button { width: 100%; padding: 10px; background: #00904a; color: white; border: none; cursor: pointer; }
                .success { color: green; margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <div class="box">
                <h2>BetPro Kurulum Sihirbazı</h2>
                <?php if(isset($success)) echo "<div class='success'>$success <br> <a href='/admin'>Admin Paneline Git</a></div>"; ?>
                <?php if(!isset($success)): ?>
                <p>Yönetici hesabı oluşturun:</p>
                <form method="POST">
                    <input type="text" name="username" placeholder="Admin Kullanıcı Adı" required>
                    <input type="password" name="password" placeholder="Şifre" required>
                    <button type="submit">Sistemi Kur</button>
                </form>
                <?php endif; ?>
            </div>
        </body>
        </html>
        <?php
    }
}
