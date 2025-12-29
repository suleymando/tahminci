<?php
/**
 * Plugin Name: Kolay Kuponlar Core
 * Description: Kuponlar Özel Yazı Türü ve Meta Kutularını ekler.
 * Version: 1.0
 * Author: Jules
 * Text Domain: kolay-kuponlar-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Register Custom Post Type 'Kupon'
function kkc_register_kupon_cpt() {
    $labels = array(
        'name'                  => _x( 'Kuponlar', 'Post Type General Name', 'kolay-kuponlar-core' ),
        'singular_name'         => _x( 'Kupon', 'Post Type Singular Name', 'kolay-kuponlar-core' ),
        'menu_name'             => __( 'Kuponlar', 'kolay-kuponlar-core' ),
        'name_admin_bar'        => __( 'Kupon', 'kolay-kuponlar-core' ),
        'add_new'               => __( 'Yeni Ekle', 'kolay-kuponlar-core' ),
        'add_new_item'          => __( 'Yeni Kupon Ekle', 'kolay-kuponlar-core' ),
        'new_item'              => __( 'Yeni Kupon', 'kolay-kuponlar-core' ),
        'edit_item'             => __( 'Kuponu Düzenle', 'kolay-kuponlar-core' ),
        'view_item'             => __( 'Kuponu Görüntüle', 'kolay-kuponlar-core' ),
        'all_items'             => __( 'Tüm Kuponlar', 'kolay-kuponlar-core' ),
        'search_items'          => __( 'Kupon Ara', 'kolay-kuponlar-core' ),
    );
    $args = array(
        'label'                 => __( 'Kupon', 'kolay-kuponlar-core' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'custom-fields' ), // Editor for notes if needed
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-tickets',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'kupon', $args );
}
add_action( 'init', 'kkc_register_kupon_cpt', 0 );

// 2. Add Meta Box for Matches
function kkc_add_meta_boxes() {
    add_meta_box(
        'kkc_kupon_details',
        __( 'Kupon Detayları', 'kolay-kuponlar-core' ),
        'kkc_render_meta_box',
        'kupon',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'kkc_add_meta_boxes' );

function kkc_render_meta_box( $post ) {
    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'kkc_save_meta_box_data', 'kkc_meta_box_nonce' );

    $kupon_type = get_post_meta( $post->ID, '_kkc_kupon_type', true );
    $total_odds = get_post_meta( $post->ID, '_kkc_total_odds', true );
    $matches = get_post_meta( $post->ID, '_kkc_matches', true );

    if ( ! is_array( $matches ) ) {
        $matches = array(); // Initialize if empty
    }
    ?>
    <style>
        .kkc-row { margin-bottom: 10px; display: flex; gap: 10px; align-items: center; }
        .kkc-matches-wrapper { margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; }
        .match-row { background: #f9f9f9; padding: 10px; border: 1px solid #ddd; margin-bottom: 5px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
        .match-row input { max-width: 150px; }
        .remove-match { color: red; cursor: pointer; }
    </style>

    <div class="kkc-row">
        <label for="kkc_kupon_type">Kupon Türü (Örn: Banko, Popüler): </label>
        <input type="text" id="kkc_kupon_type" name="kkc_kupon_type" value="<?php echo esc_attr( $kupon_type ); ?>">
    </div>
    <div class="kkc-row">
        <label for="kkc_total_odds">Toplam Oran: </label>
        <input type="text" id="kkc_total_odds" name="kkc_total_odds" value="<?php echo esc_attr( $total_odds ); ?>">
    </div>

    <div class="kkc-matches-wrapper">
        <h3>Maçlar</h3>
        <div id="matches-container">
            <?php
            if ( ! empty( $matches ) ) {
                foreach ( $matches as $index => $match ) {
                    ?>
                    <div class="match-row">
                        <input type="text" name="matches[<?php echo $index; ?>][home]" placeholder="Ev Sahibi" value="<?php echo esc_attr($match['home']); ?>">
                        <input type="text" name="matches[<?php echo $index; ?>][away]" placeholder="Deplasman" value="<?php echo esc_attr($match['away']); ?>">
                        <input type="text" name="matches[<?php echo $index; ?>][time]" placeholder="Saat (Örn: 22:00)" value="<?php echo esc_attr($match['time']); ?>">
                        <input type="text" name="matches[<?php echo $index; ?>][prediction_label]" placeholder="Tahmin Türü (MS)" value="<?php echo esc_attr($match['prediction_label']); ?>">
                        <input type="text" name="matches[<?php echo $index; ?>][prediction_value]" placeholder="Tahmin (1)" value="<?php echo esc_attr($match['prediction_value']); ?>">
                        <input type="text" name="matches[<?php echo $index; ?>][odds]" placeholder="Oran" value="<?php echo esc_attr($match['odds']); ?>">
                        <span class="remove-match" onclick="this.parentElement.remove()">Sil</span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <button type="button" class="button" id="add-match">Maç Ekle</button>
    </div>

    <script>
        // Start index from current count to avoid collisions
        var matchIndex = <?php echo count($matches); ?>;

        document.getElementById('add-match').addEventListener('click', function() {
            var container = document.getElementById('matches-container');
            var html = `
            <div class="match-row">
                <input type="text" name="matches[${matchIndex}][home]" placeholder="Ev Sahibi">
                <input type="text" name="matches[${matchIndex}][away]" placeholder="Deplasman">
                <input type="text" name="matches[${matchIndex}][time]" placeholder="Saat (Örn: 22:00)">
                <input type="text" name="matches[${matchIndex}][prediction_label]" placeholder="Tahmin Türü (MS)">
                <input type="text" name="matches[${matchIndex}][prediction_value]" placeholder="Tahmin (1)">
                <input type="text" name="matches[${matchIndex}][odds]" placeholder="Oran">
                <span class="remove-match" onclick="this.parentElement.remove()">Sil</span>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            matchIndex++;
        });
    </script>
    <?php
}

// 3. Save Meta Data
function kkc_save_meta_box_data( $post_id ) {
    if ( ! isset( $_POST['kkc_meta_box_nonce'] ) ) { return; }
    if ( ! wp_verify_nonce( $_POST['kkc_meta_box_nonce'], 'kkc_save_meta_box_data' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    if ( isset( $_POST['kkc_kupon_type'] ) ) {
        update_post_meta( $post_id, '_kkc_kupon_type', sanitize_text_field( $_POST['kkc_kupon_type'] ) );
    }
    if ( isset( $_POST['kkc_total_odds'] ) ) {
        update_post_meta( $post_id, '_kkc_total_odds', sanitize_text_field( $_POST['kkc_total_odds'] ) );
    }

    if ( isset( $_POST['matches'] ) && is_array( $_POST['matches'] ) ) {
        $matches = array();
        foreach ( $_POST['matches'] as $match ) {
            // Sanitize each field in the match array
            $clean_match = array(
                'home' => sanitize_text_field( $match['home'] ),
                'away' => sanitize_text_field( $match['away'] ),
                'time' => sanitize_text_field( $match['time'] ),
                'prediction_label' => sanitize_text_field( $match['prediction_label'] ),
                'prediction_value' => sanitize_text_field( $match['prediction_value'] ),
                'odds' => sanitize_text_field( $match['odds'] ),
            );
            $matches[] = $clean_match;
        }
        update_post_meta( $post_id, '_kkc_matches', $matches );
    } else {
        delete_post_meta( $post_id, '_kkc_matches' );
    }
}
add_action( 'save_post', 'kkc_save_meta_box_data' );
