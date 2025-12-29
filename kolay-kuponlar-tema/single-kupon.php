<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();

    $kupon_type = get_post_meta(get_the_ID(), '_kkc_kupon_type', true);
    $total_odds = get_post_meta(get_the_ID(), '_kkc_total_odds', true);
    $matches = get_post_meta(get_the_ID(), '_kkc_matches', true);
?>

<div class="container" style="padding: 40px 0;">
    <div class="single-coupon-view">
        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="coupon-detail-card">
            <div class="coupon-header-detail">
                <span>Kupon Türü: <strong><?php echo esc_html($kupon_type); ?></strong></span>
                <span>Toplam Oran: <strong><?php echo esc_html($total_odds); ?></strong></span>
            </div>

            <div class="matches-list-detail">
                <?php if (!empty($matches)) : foreach ($matches as $match) : ?>
                    <div class="match-row-detail">
                        <div class="teams">
                            <i class="fas fa-futbol"></i>
                            <strong><?php echo esc_html($match['home']); ?></strong> - <strong><?php echo esc_html($match['away']); ?></strong>
                        </div>
                        <div class="meta">
                            <span class="date"><i class="far fa-clock"></i> <?php echo esc_html($match['time']); ?></span>
                            <span class="prediction">Tahmin: <strong><?php echo esc_html($match['prediction_label'] . ' ' . $match['prediction_value']); ?></strong></span>
                            <span class="odd badge"><?php echo esc_html($match['odds']); ?></span>
                        </div>
                    </div>
                <?php endforeach; endif; ?>
            </div>

            <div class="coupon-content">
                <h3>Analiz & Yorum</h3>
                <?php the_content(); ?>
            </div>

            <div class="action-area">
                <a href="#" class="btn-bet-now">Bu Kuponu Oyna</a>
            </div>
        </div>
    </div>
</div>

<style>
    .single-coupon-view {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .entry-title {
        text-align: center;
        margin-bottom: 30px;
        color: var(--primary-green);
    }
    .coupon-header-detail {
        display: flex;
        justify-content: space-between;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border-bottom: 2px solid var(--primary-green);
    }
    .match-row-detail {
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    .match-row-detail:last-child {
        border-bottom: none;
    }
    .match-row-detail .teams {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }
    .match-row-detail .meta {
        display: flex;
        gap: 20px;
        color: #666;
        align-items: center;
    }
    .badge {
        background: var(--primary-green);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: bold;
    }
    .coupon-content {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    .btn-bet-now {
        display: block;
        width: 100%;
        background: #e67e22;
        color: white;
        text-align: center;
        padding: 15px;
        font-size: 1.2rem;
        font-weight: bold;
        border-radius: 5px;
        margin-top: 20px;
    }
    .btn-bet-now:hover {
        background: #d35400;
    }
</style>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
