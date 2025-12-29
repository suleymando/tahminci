<?php
require_once '../config.php';
check_admin();

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $pdo->prepare("DELETE FROM coupons WHERE id = ?")->execute([$id]);
    header("Location: index.php");
    exit;
}

// Handle Status Change
if (isset($_GET['status']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['status'];
    $pdo->prepare("UPDATE coupons SET status = ? WHERE id = ?")->execute([$status, $id]);
    header("Location: index.php");
    exit;
}

// Fetch Stats
$total_coupons = $pdo->query("SELECT COUNT(*) FROM coupons")->fetchColumn();
$won_coupons = $pdo->query("SELECT COUNT(*) FROM coupons WHERE status = 'won'")->fetchColumn();

// Fetch Coupons
$stmt = $pdo->query("SELECT * FROM coupons ORDER BY created_at DESC");
$coupons = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f4f6f9; }
        .sidebar { width: 250px; background: #343a40; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 20px; font-weight: bold; background: #23272b; }
        .menu { list-style: none; padding: 0; margin: 0; }
        .menu li a { display: block; padding: 15px 20px; color: #c2c7d0; text-decoration: none; border-bottom: 1px solid #3f474e; }
        .menu li a:hover { background: #3f474e; color: white; }
        .content { margin-left: 250px; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .card-row { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .stat-number { font-size: 24px; font-weight: bold; color: #27ae60; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; color: white; display: inline-block; font-size: 14px; }
        .btn-green { background: #28a745; }
        .btn-blue { background: #007bff; }
        .btn-red { background: #dc3545; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; font-weight: 600; color: #495057; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .bg-won { background: #28a745; }
        .bg-lost { background: #dc3545; }
        .bg-pending { background: #ffc107; color: #333; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="menu">
        <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <?php echo __('dashboard'); ?></a></li>
        <li><a href="add_coupon.php"><i class="fas fa-plus-circle"></i> <?php echo __('add_coupon'); ?></a></li>
        <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> Siteyi Görüntüle</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <?php echo __('logout'); ?></a></li>
    </ul>
</div>

<div class="content">
    <div class="header">
        <h1><?php echo __('dashboard'); ?></h1>
        <a href="add_coupon.php" class="btn btn-green">+ <?php echo __('add_coupon'); ?></a>
    </div>

    <div class="card-row">
        <div class="stat-card">
            <div>Toplam Kupon</div>
            <div class="stat-number"><?php echo $total_coupons; ?></div>
        </div>
        <div class="stat-card">
            <div>Kazanan Kuponlar</div>
            <div class="stat-number"><?php echo $won_coupons; ?></div>
        </div>
    </div>

    <h3>Son Kuponlar</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th><?php echo __('title'); ?></th>
                <th>Tip</th>
                <th>Oran</th>
                <th>Güven</th>
                <th>Durum</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($coupons as $c): ?>
            <tr>
                <td>#<?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['title']); ?></td>
                <td><?php echo htmlspecialchars($c['type']); ?></td>
                <td><?php echo $c['total_odds']; ?></td>
                <td>%<?php echo $c['confidence']; ?></td>
                <td><span class="badge bg-<?php echo $c['status']; ?>"><?php echo strtoupper($c['status']); ?></span></td>
                <td>
                    <?php if($c['status'] == 'pending'): ?>
                    <a href="?id=<?php echo $c['id']; ?>&status=won" class="btn btn-green btn-sm"><i class="fas fa-check"></i></a>
                    <a href="?id=<?php echo $c['id']; ?>&status=lost" class="btn btn-red btn-sm"><i class="fas fa-times"></i></a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $c['id']; ?>" class="btn btn-red btn-sm" onclick="return confirm('Silinsin mi?')"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
