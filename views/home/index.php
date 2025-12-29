<!doctype html>
<html lang="<?php echo $language->getCurrentLang(); ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BetPro - Premium Predictions</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<header class="site-header">
    <div class="container flex-row">
        <div class="site-branding">
            <a href="/" class="site-title">BetPro Script</a>
        </div>

        <nav class="main-navigation">
            <ul>
                <li><a href="/"><i class="fas fa-home"></i> <?php echo __('home'); ?></a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> <?php echo __('newsletter'); ?></a></li>
                <li><a href="#"><i class="fas fa-star"></i> <?php echo __('popular'); ?></a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <div class="lang-switch">
                <a href="?lang=tr" class="<?php echo $language->getCurrentLang() == 'tr' ? 'active' : ''; ?>">TR</a> |
                <a href="?lang=en" class="<?php echo $language->getCurrentLang() == 'en' ? 'active' : ''; ?>">EN</a>
            </div>
            <!-- If admin logged in show Admin Link -->
             <?php if(isset($_SESSION['admin_logged_in'])): ?>
                <a href="/admin" class="btn btn-login"><?php echo __('admin_dashboard'); ?></a>
             <?php else: ?>
                <a href="/admin/login" class="btn btn-login"><?php echo __('login'); ?></a>
             <?php endif; ?>
        </div>
    </div>
</header>

<div class="container main-content">

    <!-- Search and Filter -->
    <div class="search-filter-row">
        <div class="search-bar">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="<?php echo __('search_placeholder'); ?>">
        </div>
        <div class="filter-buttons">
            <?php
            $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
            ?>
            <a href="?filter=all" class="filter-btn <?php echo $filter == 'all' ? 'active' : ''; ?>"><?php echo __('all'); ?></a>
            <a href="?filter=Banko" class="filter-btn <?php echo $filter == 'Banko' ? 'active' : ''; ?>">Banko</a>
            <a href="?filter=Popüler" class="filter-btn <?php echo $filter == 'Popüler' ? 'active' : ''; ?>">Popüler</a>
        </div>
    </div>

    <div class="content-grid">
        <div class="main-column">

            <div class="coupons-grid">
                <?php if(empty($data['coupons'])): ?>
                    <p style="text-align:center; padding: 20px;">Henüz kupon eklenmemiş.</p>
                <?php else: ?>
                    <?php foreach($data['coupons'] as $coupon):
                        $headerClass = 'card-header-default';
                        if(stripos($coupon['type'], 'Banko') !== false) $headerClass = 'card-header-banko';
                        if(stripos($coupon['type'], 'Popüler') !== false) $headerClass = 'card-header-popular';
                    ?>
                    <div class="coupon-card <?php echo 'status-' . $coupon['status']; ?>">
                        <!-- Status Stamp -->
                        <?php if($coupon['status'] == 'won'): ?>
                            <div class="stamp stamp-won"><?php echo __('status_won'); ?></div>
                        <?php elseif($coupon['status'] == 'lost'): ?>
                            <div class="stamp stamp-lost"><?php echo __('status_lost'); ?></div>
                        <?php endif; ?>

                        <div class="coupon-header <?php echo $headerClass; ?>">
                            <span class="coupon-type">
                                <?php if($headerClass == 'card-header-banko') echo '<i class="fas fa-thumbs-up"></i>'; ?>
                                <?php if($headerClass == 'card-header-popular') echo '<i class="fas fa-star"></i>'; ?>
                                <strong><?php echo htmlspecialchars($coupon['type']); ?></strong>
                            </span>
                            <i class="fas fa-info-circle info-icon"></i>
                        </div>

                        <div class="coupon-body">
                            <?php foreach($coupon['matches'] as $match): ?>
                                <div class="match-item">
                                    <div class="match-meta-top">
                                        <i class="fas fa-futbol match-icon"></i>
                                        <span class="match-teams"><?php echo htmlspecialchars($match['home_team'] . ' - ' . $match['away_team']); ?></span>
                                    </div>
                                    <div class="match-details">
                                        <div class="match-info">
                                            <span class="match-time"><?php echo htmlspecialchars($match['match_time']); ?></span>
                                            <span class="prediction-badge">
                                                <span class="pred-value"><?php echo htmlspecialchars($match['prediction']); ?></span>
                                            </span>
                                        </div>
                                        <div class="match-odds">
                                            <?php echo htmlspecialchars($match['odds']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="coupon-footer">
                            <div class="total-odds">
                                <span class="label"><?php echo __('total_odds'); ?>:</span>
                                <span class="value"><?php echo $coupon['total_odds']; ?></span>
                            </div>
                            <a href="/coupon/<?php echo $coupon['id']; ?>" class="btn-play"><?php echo __('details'); ?></a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div> <!-- End Main Column -->

        <div class="sidebar-column">
            <!-- Special Offer Widget -->
            <div class="widget special-offer">
                <h3><?php echo __('special_offer'); ?></h3>
                <p><?php echo __('special_offer_desc'); ?></p>
                <a href="#" class="btn-cta"><?php echo __('register'); ?></a>
            </div>
        </div>

    </div>
</div>

<footer class="site-footer">
    <div class="container text-center">
        <div class="site-info">
            © <?php echo date('Y'); ?> BetPro Script. <?php echo __('footer_text'); ?>
        </div>
    </div>
</footer>

</body>
</html>
