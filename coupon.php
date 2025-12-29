<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM coupons WHERE id = ?");
$stmt->execute([$id]);
$coupon = $stmt->fetch();

if (!$coupon) {
    die("Kupon bulunamadı.");
}

$stmt = $pdo->prepare("SELECT * FROM matches WHERE coupon_id = ?");
$stmt->execute([$id]);
$matches = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($coupon['title']); ?> - BetPro</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .detail-wrapper { max-width: 800px; margin: 40px auto; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .detail-header { background: #2d3436; color: white; padding: 30px; text-align: center; }
        .detail-title { font-size: 24px; margin: 0; }
        .detail-meta { margin-top: 10px; color: #b2bec3; }
        .match-list-lg { padding: 30px; }
        .match-row-lg { display: flex; align-items: center; justify-content: space-between; padding: 20px; background: #f8f9fa; border-radius: 8px; margin-bottom: 15px; }
        .teams-lg { font-size: 18px; font-weight: bold; }
        .odds-badge { background: #00b894; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; }
        .cta-section { background: #f1f2f6; padding: 40px; text-align: center; }
        .btn-register { background: #d63031; color: white; padding: 15px 40px; border-radius: 30px; font-size: 18px; font-weight: bold; text-decoration: none; display: inline-block; transition: transform 0.2s; }
        .btn-register:hover { transform: scale(1.05); }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">BetPro</a>
        <a href="index.php" style="color:white; text-decoration:none;"><i class="fas fa-arrow-left"></i> Geri Dön</a>
    </div>
</header>

<div class="container">
    <div class="detail-wrapper">
        <div class="detail-header">
            <h1 class="detail-title"><?php echo htmlspecialchars($coupon['title']); ?></h1>
            <div class="detail-meta">
                <?php echo htmlspecialchars($coupon['type']); ?> • %<?php echo $coupon['confidence']; ?> Güven
            </div>
            <h2 style="color: #00b894; margin-bottom: 0; font-size: 36px;"><?php echo $coupon['total_odds']; ?></h2>
            <span style="font-size: 12px; color: #b2bec3;">TOPLAM ORAN</span>
        </div>

        <div class="match-list-lg">
            <?php foreach($matches as $match): ?>
            <div class="match-row-lg">
                <div>
                    <div style="font-size: 12px; color: #636e72; font-weight: bold; text-transform: uppercase;"><?php echo htmlspecialchars($match['league']); ?> • <?php echo htmlspecialchars($match['match_time']); ?></div>
                    <div class="teams-lg"><?php echo htmlspecialchars($match['home_team']); ?> - <?php echo htmlspecialchars($match['away_team']); ?></div>
                    <div style="margin-top: 5px; color: #2d3436;">Tahmin: <strong><?php echo htmlspecialchars($match['prediction']); ?></strong></div>
                </div>
                <div class="odds-badge"><?php echo htmlspecialchars($match['odds']); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cta-section">
            <h3>Bu kuponu kaçırma!</h3>
            <p>Hemen üye ol, %100 Hoşgeldin bonusunu kap.</p>
            <a href="#" class="btn-register"><?php echo __('register_now'); ?></a>
        </div>
    </div>
</div>

</body>
</html>
