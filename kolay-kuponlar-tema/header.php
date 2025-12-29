<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-top">
        <div class="container flex-row">
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <span class="site-title">Kolay Kuponlar</span>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <ul>
                    <li><a href="<?php echo home_url(); ?>"><i class="fas fa-home"></i> Ana Sayfa</a></li>
                    <li><a href="#"><i class="fas fa-chart-bar"></i> Bülten</a></li>
                    <li><a href="#"><i class="fas fa-star"></i> Popüler</a></li>
                    <li><a href="#"><i class="fas fa-ticket-alt"></i> Kuponlarım</a></li>
                </ul>
            </nav>

            <div class="header-actions">
                <a href="<?php echo wp_login_url(); ?>" class="btn btn-login">Giriş Yap</a>
            </div>
        </div>
    </div>
</header>
