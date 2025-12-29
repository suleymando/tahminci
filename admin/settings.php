<?php
require_once '../config.php';
check_admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    update_setting('site_title', $_POST['site_title']);
    update_setting('site_desc', $_POST['site_desc']);
    update_setting('site_keywords', $_POST['site_keywords']);

    update_setting('ad_header', $_POST['ad_header']);
    update_setting('ad_footer', $_POST['ad_footer']);
    update_setting('ad_popup', $_POST['ad_popup']);

    update_setting('popup_status', isset($_POST['popup_status']) ? '1' : '0');

    $success = "Ayarlar kaydedildi.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo __('settings'); ?> - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f4f6f9; }
        .sidebar { width: 250px; background: #343a40; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 20px; font-weight: bold; background: #23272b; }
        .menu { list-style: none; padding: 0; margin: 0; }
        .menu li a { display: block; padding: 15px 20px; color: #c2c7d0; text-decoration: none; border-bottom: 1px solid #3f474e; }
        .content { margin-left: 250px; padding: 20px; }

        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }
        textarea { height: 100px; font-family: monospace; }

        .btn-save { background: #28a745; color: white; border: none; padding: 15px 30px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .success-msg { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }

        .switch-wrapper { display: flex; align-items: center; gap: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="menu">
        <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <?php echo __('dashboard'); ?></a></li>
        <li><a href="add_coupon.php"><i class="fas fa-plus-circle"></i> <?php echo __('add_coupon'); ?></a></li>
        <li><a href="settings.php" style="color:white; background:#3f474e;"><i class="fas fa-cog"></i> <?php echo __('settings'); ?></a></li>
    </ul>
</div>

<div class="content">
    <h1><?php echo __('settings'); ?></h1>

    <?php if(isset($success)) echo "<div class='success-msg'>$success</div>"; ?>

    <form method="POST">
        <div class="card">
            <h3><?php echo __('seo_settings'); ?></h3>
            <div class="form-group">
                <label><?php echo __('site_title'); ?></label>
                <input type="text" name="site_title" value="<?php echo htmlspecialchars(get_setting('site_title', 'BetPro - Premium Predictions')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo __('site_desc'); ?></label>
                <input type="text" name="site_desc" value="<?php echo htmlspecialchars(get_setting('site_desc', 'Best betting tips and coupons.')); ?>">
            </div>
            <div class="form-group">
                <label><?php echo __('site_keywords'); ?></label>
                <input type="text" name="site_keywords" value="<?php echo htmlspecialchars(get_setting('site_keywords', 'bet, iddaa, kupon, banko')); ?>">
            </div>
        </div>

        <div class="card">
            <h3><?php echo __('ad_settings'); ?></h3>
            <div class="form-group">
                <label><?php echo __('ad_header'); ?></label>
                <textarea name="ad_header" placeholder="<script>..."><?php echo htmlspecialchars(get_setting('ad_header')); ?></textarea>
            </div>
            <div class="form-group">
                <label><?php echo __('ad_footer'); ?></label>
                <textarea name="ad_footer"><?php echo htmlspecialchars(get_setting('ad_footer')); ?></textarea>
            </div>
            <div class="form-group">
                <label><?php echo __('ad_popup'); ?></label>
                <textarea name="ad_popup"><?php echo htmlspecialchars(get_setting('ad_popup')); ?></textarea>
            </div>
            <div class="form-group switch-wrapper">
                <label><?php echo __('popup_status'); ?></label>
                <input type="checkbox" name="popup_status" <?php echo get_setting('popup_status') == '1' ? 'checked' : ''; ?>>
                <span><?php echo __('active'); ?></span>
            </div>
        </div>

        <button type="submit" class="btn-save"><?php echo __('save'); ?></button>
    </form>
</div>

</body>
</html>
