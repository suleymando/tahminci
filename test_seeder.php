<?php
// Bu dosya, temanın ve eklentinin çalıştığını doğrulamak için yapay veri oluşturur.
// Normalde bu işlem manuel yapılır, ancak teslimat öncesi doğrulama için bu script kullanılır.

require_once 'wordpress/wp-load.php'; // Bu yol sandbox ortamına göre değişebilir, ancak temsili.

// 1. Önce eklentinin fonksiyonlarının yüklü olduğundan emin olmalıyız.
// Sandbox ortamında WP tam olarak çalışmayabilir, bu yüzden bu adımı simüle ediyoruz.
// Normal bir WP kurulumunda bu script tema aktif edildiğinde veya manuel çalıştırıldığında işler.

function create_dummy_content() {
    // Check if CPT exists
    if (!post_type_exists('kupon')) {
        echo "HATA: 'kupon' CPT bulunamadı. Eklenti aktif mi?\n";
        return;
    }

    // Create a Banko Kupon
    $post_data = array(
        'post_title'    => 'Banko Kupon - ' . date('d.m.Y'),
        'post_content'  => 'Günün en güvenilir maçlarından oluşan banko kuponumuz.',
        'post_status'   => 'publish',
        'post_type'     => 'kupon',
    );
    $post_id = wp_insert_post($post_data);

    if ($post_id) {
        update_post_meta($post_id, '_kkc_kupon_type', 'Banko Kupon');
        update_post_meta($post_id, '_kkc_total_odds', '1.83');

        $matches = array(
            array(
                'home' => 'Zambiya',
                'away' => 'Fas',
                'time' => '22:00',
                'prediction_label' => 'MS',
                'prediction_value' => '2',
                'odds' => '1.13'
            ),
            array(
                'home' => 'Persija Jakarta',
                'away' => 'Bhayangkara',
                'time' => '15:00',
                'prediction_label' => 'MS',
                'prediction_value' => '1',
                'odds' => '1.23'
            ),
            array(
                'home' => 'AL Taawoun FC',
                'away' => 'AL Najma',
                'time' => '20:30',
                'prediction_label' => 'MS',
                'prediction_value' => '1',
                'odds' => '1.32'
            )
        );
        update_post_meta($post_id, '_kkc_matches', $matches);
        echo "Kupon oluşturuldu: ID $post_id\n";
    }

    // Create a Popular Kupon
    $post_data_pop = array(
        'post_title'    => 'Popüler Kupon - ' . date('d.m.Y'),
        'post_content'  => 'Çok oynanan maçlardan oluşan yüksek oranlı kupon.',
        'post_status'   => 'publish',
        'post_type'     => 'kupon',
    );
    $post_id_pop = wp_insert_post($post_data_pop);

    if ($post_id_pop) {
        update_post_meta($post_id_pop, '_kkc_kupon_type', 'Popüler Kupon');
        update_post_meta($post_id_pop, '_kkc_total_odds', '3.37');

        $matches_pop = array(
            array(
                'home' => 'AS Roma',
                'away' => 'Genoa',
                'time' => '22:45',
                'prediction_label' => 'MS',
                'prediction_value' => '1',
                'odds' => '1.50'
            ),
            array(
                'home' => 'Zimbabve',
                'away' => 'Güney Afrika',
                'time' => '19:00',
                'prediction_label' => 'MS',
                'prediction_value' => '2',
                'odds' => '1.58'
            ),
             array(
                'home' => 'Komorlar',
                'away' => 'Mali',
                'time' => '22:00',
                'prediction_label' => 'MS',
                'prediction_value' => '2',
                'odds' => '1.42'
            )
        );
        update_post_meta($post_id_pop, '_kkc_matches', $matches_pop);
        echo "Popüler Kupon oluşturuldu: ID $post_id_pop\n";
    }
}

// In this environment I cannot execute PHP with WordPress context directly via bash unless I setup a full stack.
// However, the code above is valid for use in 'functions.php' temporarily to seed data if the user installs it.
// I will instead perform a manual verification of the file contents to ensure logic is correct.
?>
