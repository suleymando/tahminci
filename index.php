<?php
require_once 'config.php';

// Filter Logic
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$sql = "SELECT * FROM coupons WHERE 1=1";
$params = [];

if ($filter != 'all') {
    $sql .= " AND type = ?";
    $params[] = $filter;
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$coupons = $stmt->fetchAll();

// Fetch matches for each coupon
foreach ($coupons as &$coupon) {
    $stmt = $pdo->prepare("SELECT * FROM matches WHERE coupon_id = ?");
    $stmt->execute([$coupon['id']]);
    $coupon['matches'] = $stmt->fetchAll();
}
unset($coupon); // break ref

?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BetPro - Premium Betting Tips</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">BetPro</a>
        <nav class="nav-menu">
            <a href="index.php" class="active"><?php echo __('home'); ?></a>
            <a href="#"><?php echo __('special_offer'); ?></a>
        </nav>
        <div class="lang-switch">
            <a href="?lang=tr" class="<?php echo $current_lang == 'tr' ? 'active' : ''; ?>">TR</a> |
            <a href="?lang=en" class="<?php echo $current_lang == 'en' ? 'active' : ''; ?>">EN</a>
        </div>
    </div>
</header>

<div class="hero-filter">
    <div class="container">
        <div class="filter-row">
            <a href="?filter=all" class="filter-btn <?php echo $filter == 'all' ? 'active' : ''; ?>"><?php echo __('all'); ?></a>
            <a href="?filter=Banko" class="filter-btn <?php echo $filter == 'Banko' ? 'active' : ''; ?>"><?php echo __('type_banko'); ?></a>
            <a href="?filter=Popüler" class="filter-btn <?php echo $filter == 'Popüler' ? 'active' : ''; ?>"><?php echo __('type_popular'); ?></a>
            <a href="?filter=Sistem" class="filter-btn <?php echo $filter == 'Sistem' ? 'active' : ''; ?>"><?php echo __('type_system'); ?></a>
            <a href="?filter=Tekli" class="filter-btn <?php echo $filter == 'Tekli' ? 'active' : ''; ?>"><?php echo __('type_single'); ?></a>
        </div>
    </div>
</div>

<div class="container">
    <div class="coupon-grid">
        <?php if(empty($coupons)): ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 50px;">
                <h3><?php echo __('no_coupons'); ?></h3>
            </div>
        <?php endif; ?>

        <?php foreach($coupons as $coupon): ?>
        <div class="coupon-card">
            <?php if($coupon['status'] == 'won'): ?>
                <div class="stamp stamp-won"><?php echo __('status_won'); ?></div>
            <?php elseif($coupon['status'] == 'lost'): ?>
                <div class="stamp stamp-lost"><?php echo __('status_lost'); ?></div>
            <?php endif; ?>

            <div class="card-header">
                <div class="type-badge"><?php echo htmlspecialchars($coupon['type']); ?></div>
                <div class="confidence-wrapper">
                    <div class="confidence-bar">
                        <div class="confidence-fill" style="width: <?php echo $coupon['confidence']; ?>%;"></div>
                    </div>
                    <div class="confidence-text">%<?php echo $coupon['confidence']; ?> <?php echo __('confidence'); ?></div>
                </div>
            </div>

            <div class="card-body">
                <?php foreach($coupon['matches'] as $match): ?>
                <div class="match-item">
                    <div class="match-info">
                        <div class="match-league"><?php echo htmlspecialchars($match['league']); ?> • <?php echo htmlspecialchars($match['match_time']); ?></div>
                        <div class="match-teams"><?php echo htmlspecialchars($match['home_team']); ?> - <?php echo htmlspecialchars($match['away_team']); ?></div>
                    </div>
                    <div class="match-meta">
                        <div class="prediction-box"><?php echo htmlspecialchars($match['prediction']); ?></div>
                        <span class="match-odds"><?php echo htmlspecialchars($match['odds']); ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card-footer">
                <div class="total-odds">
                    <div class="total-odds-label"><?php echo __('total_odds'); ?></div>
                    <div class="total-odds-value"><?php echo $coupon['total_odds']; ?></div>
                </div>
                <a href="coupon.php?id=<?php echo $coupon['id']; ?>" class="btn-detail"><?php echo __('details'); ?></a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="site-footer">
    <div class="container">
        &copy; <?php echo date('Y'); ?> BetPro. All rights reserved.
    </div>
</footer>

</body>
</html>
