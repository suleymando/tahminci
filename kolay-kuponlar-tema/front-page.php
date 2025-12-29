<?php
get_header();

// Query for Coupons
$args = array(
    'post_type' => 'kupon',
    'posts_per_page' => 6,
    'post_status' => 'publish'
);
$kupon_query = new WP_Query($args);

// Query for News (Standard Posts)
$news_args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post_status' => 'publish'
);
$news_query = new WP_Query($news_args);
?>

<div class="container main-content">

    <!-- Search and Filter Section -->
    <div class="search-filter-row">
        <div class="search-bar">
            <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <i class="fas fa-search search-icon"></i>
                <input type="search" class="search-field" placeholder="Takım veya lig ara..." value="<?php echo get_search_query(); ?>" name="s" />
            </form>
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active">Tümü</button>
            <button class="filter-btn">Futbol</button>
            <button class="filter-btn">Basketbol</button>
        </div>
    </div>

    <div class="content-grid">
        <div class="main-column">

            <!-- Coupons Grid -->
            <div class="coupons-grid">
                <?php if ($kupon_query->have_posts()) : while ($kupon_query->have_posts()) : $kupon_query->the_post();
                    $kupon_type = get_post_meta(get_the_ID(), '_kkc_kupon_type', true);
                    $total_odds = get_post_meta(get_the_ID(), '_kkc_total_odds', true);
                    $matches = get_post_meta(get_the_ID(), '_kkc_matches', true);

                    // Determine header class based on type (visual sugar)
                    $header_class = 'card-header-default';
                    if (stripos($kupon_type, 'Banko') !== false) { $header_class = 'card-header-banko'; }
                    if (stripos($kupon_type, 'Popüler') !== false) { $header_class = 'card-header-popular'; }
                ?>
                    <div class="coupon-card">
                        <div class="coupon-header <?php echo $header_class; ?>">
                            <span class="coupon-type">
                                <?php if ($header_class == 'card-header-banko') echo '<i class="fas fa-thumbs-up"></i>'; ?>
                                <?php if ($header_class == 'card-header-popular') echo '<i class="fas fa-star"></i>'; ?>
                                <strong><?php echo esc_html($kupon_type); ?></strong>
                            </span>
                            <i class="fas fa-info-circle info-icon"></i>
                        </div>

                        <div class="coupon-body">
                            <?php if (!empty($matches)) : foreach ($matches as $match) : ?>
                                <div class="match-item">
                                    <div class="match-meta-top">
                                        <i class="fas fa-futbol match-icon"></i>
                                        <span class="match-teams"><?php echo esc_html($match['home'] . ' - ' . $match['away']); ?></span>
                                        <span class="match-result-icon"><i class="fas fa-trophy"></i></span>
                                    </div>
                                    <div class="match-details">
                                        <div class="match-info">
                                            <span class="match-time">Bugün <?php echo esc_html($match['time']); ?></span>
                                            <span class="prediction-badge">
                                                <span class="pred-label"><?php echo esc_html($match['prediction_label']); ?>:</span>
                                                <span class="pred-value"><?php echo esc_html($match['prediction_value']); ?></span>
                                            </span>
                                        </div>
                                        <div class="match-odds">
                                            <?php echo esc_html($match['odds']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>

                        <div class="coupon-footer">
                            <div class="total-odds">
                                <span class="label">Toplam Oran:</span>
                                <span class="value"><?php echo esc_html($total_odds); ?></span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn-play">DETAYLARI GÖR</a>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); else : ?>
                    <p>Henüz kupon bulunmamaktadır.</p>
                <?php endif; ?>
            </div>

            <!-- News Section -->
            <div class="news-section">
                <div class="section-title">
                    <i class="fas fa-newspaper"></i> Günün Haberleri
                </div>
                <?php if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <div class="news-card">
                        <div class="news-thumb">
                            <?php if (has_post_thumbnail()) {
                                the_post_thumbnail('thumbnail');
                            } else {
                                echo '<div class="placeholder-thumb"><i class="fas fa-image"></i></div>';
                            } ?>
                        </div>
                        <div class="news-content">
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="news-excerpt"><?php the_excerpt(); ?></div>
                            <div class="news-meta"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' önce'; ?></div>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>

        </div> <!-- End Main Column -->

        <div class="sidebar-column">
            <!-- Special Offer Widget -->
            <div class="widget special-offer">
                <h3>Özel Fırsat!</h3>
                <p>Yeni üyelere özel %100 Hoşgeldin Bonusu seni bekliyor.</p>
                <a href="#" class="btn-cta">Kayıt Ol</a>
            </div>
        </div>

    </div>
</div>

<?php get_footer(); ?>
