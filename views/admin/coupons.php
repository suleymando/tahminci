<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kuponlar - BetPro Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background: #f4f7f6; }
        .sidebar { width: 250px; background: #2c3e50; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 1.2rem; font-weight: bold; border-bottom: 1px solid #34495e; }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu a { display: block; padding: 15px 20px; color: #bdc3c7; text-decoration: none; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #34495e; color: white; border-left-color: #00904a; }
        .main-content { margin-left: 250px; flex: 1; padding: 20px; }

        .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; color: white; font-weight: bold; font-size: 0.9rem; border: none; cursor: pointer; }
        .btn-green { background: #00904a; }
        .btn-green:hover { background: #007a3e; }

        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; color: #7f8c8d; font-weight: 600; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-transform: uppercase; }
        .status-won { background: #d4edda; color: #155724; }
        .status-lost { background: #f8d7da; color: #721c24; }
        .status-pending { background: #fff3cd; color: #856404; }

        .action-icon { margin-right: 10px; color: #7f8c8d; }
        .action-icon:hover { color: #333; }
        .action-win { color: #27ae60; }
        .action-loss { color: #c0392b; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="sidebar-menu">
        <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="/admin/coupons" class="active"><i class="fas fa-ticket-alt"></i> Kuponlar</a></li>
        <li><a href="/admin/logout"><i class="fas fa-sign-out-alt"></i> Çıkış</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header-actions">
        <h1>Kupon Yönetimi</h1>
        <a href="/admin/add_coupon" class="btn btn-green"><i class="fas fa-plus"></i> Yeni Kupon Ekle</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Başlık</th>
                <th>Tip</th>
                <th>Oran</th>
                <th>Durum</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['coupons'] as $coupon): ?>
            <tr>
                <td>#<?php echo $coupon['id']; ?></td>
                <td><?php echo htmlspecialchars($coupon['title']); ?></td>
                <td><?php echo htmlspecialchars($coupon['type']); ?></td>
                <td><strong><?php echo $coupon['total_odds']; ?></strong></td>
                <td>
                    <span class="status-badge status-<?php echo $coupon['status']; ?>">
                        <?php echo $coupon['status']; ?>
                    </span>
                </td>
                <td><?php echo date('d.m.Y H:i', strtotime($coupon['created_at'])); ?></td>
                <td>
                    <a href="/admin/update_status/<?php echo $coupon['id']; ?>/won" class="action-icon action-win" title="Kazandı İşaretle"><i class="fas fa-check-circle"></i></a>
                    <a href="/admin/update_status/<?php echo $coupon['id']; ?>/lost" class="action-icon action-loss" title="Kaybetti İşaretle"><i class="fas fa-times-circle"></i></a>
                    <a href="/admin/delete_coupon/<?php echo $coupon['id']; ?>" class="action-icon" onclick="return confirm('Silmek istediğine emin misin?')" title="Sil"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
