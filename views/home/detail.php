<!doctype html>
<html lang="<?php echo $language->getCurrentLang(); ?>">
<head>
	<meta charset="UTF-8">
    <title><?php echo htmlspecialchars($data['coupon']['title']); ?> - BetPro</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header class="site-header">
    <div class="container flex-row">
        <div class="site-branding">
            <a href="/" class="site-title">BetPro Script</a>
        </div>
        <div class="header-actions">
            <a href="/" style="color:white; font-weight:bold;">&laquo; Geri Dön</a>
        </div>
    </div>
</header>

<div class="container" style="padding-top: 50px;">
    <div class="detail-view">
        <div class="detail-header">
            <h1><?php echo htmlspecialchars($data['coupon']['title']); ?></h1>
            <p>
                <span style="background: #2c3e50; color: #f1c40f; padding: 5px 10px; border-radius: 4px; font-weight: bold;"><?php echo htmlspecialchars($data['coupon']['type']); ?></span>
                <span style="margin-left: 10px; font-weight: bold; font-size: 1.2rem;">Toplam Oran: <?php echo $data['coupon']['total_odds']; ?></span>
            </p>
        </div>

        <div class="matches-list-detail">
            <?php foreach($data['coupon']['matches'] as $match): ?>
                <div class="match-item">
                    <div class="match-meta-top">
                        <i class="fas fa-futbol"></i>
                        <span><?php echo htmlspecialchars($match['home_team'] . ' - ' . $match['away_team']); ?></span>
                    </div>
                    <div class="match-details">
                        <span><?php echo htmlspecialchars($match['match_time']); ?></span>
                        <span class="prediction-badge">Tahmin: <span class="pred-value"><?php echo htmlspecialchars($match['prediction']); ?></span></span>
                        <span class="match-odds"><?php echo htmlspecialchars($match['odds']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="action-area">
            <a href="#" class="btn-bet-large">BU KUPONU OYNA</a>
        </div>
    </div>
</div>

</body>
</html>
