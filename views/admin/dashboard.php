<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - BetPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background: #f4f7f6; }
        .sidebar { width: 250px; background: #2c3e50; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 1.2rem; font-weight: bold; border-bottom: 1px solid #34495e; }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu a { display: block; padding: 15px 20px; color: #bdc3c7; text-decoration: none; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #34495e; color: white; border-left-color: #00904a; }
        .main-content { margin-left: 250px; flex: 1; padding: 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .stat-card h3 { margin: 0 0 10px; font-size: 0.9rem; color: #7f8c8d; }
        .stat-card .value { font-size: 2rem; font-weight: bold; color: #2c3e50; }
        .btn-logout { margin-top: auto; color: #e74c3c !important; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="sidebar-menu">
        <li><a href="/admin" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="/admin/coupons"><i class="fas fa-ticket-alt"></i> Kuponlar</a></li>
        <li><a href="/admin/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Çıkış</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Genel Bakış</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Toplam Kupon</h3>
            <div class="value"><?php echo $data['stats']['total']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Kazanan</h3>
            <div class="value" style="color: #27ae60"><?php echo $data['stats']['won']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Kaybeden</h3>
            <div class="value" style="color: #c0392b"><?php echo $data['stats']['lost']; ?></div>
        </div>
        <div class="stat-card">
            <h3>Bekleyen</h3>
            <div class="value" style="color: #f39c12"><?php echo $data['stats']['pending']; ?></div>
        </div>
    </div>
</div>

</body>
</html>
