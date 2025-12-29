<?php
require_once '../config.php';
check_admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();

        $title = $_POST['title'];
        $type = $_POST['type'];
        $confidence = (int)$_POST['confidence'];
        $total_odds = $_POST['total_odds'];

        $stmt = $pdo->prepare("INSERT INTO coupons (title, type, total_odds, confidence, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->execute([$title, $type, $total_odds, $confidence]);
        $coupon_id = $pdo->lastInsertId();

        // Add Matches
        if (isset($_POST['matches'])) {
            $sql = "INSERT INTO matches (coupon_id, home_team, away_team, league, match_time, prediction, odds) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            foreach ($_POST['matches'] as $match) {
                $stmt->execute([
                    $coupon_id,
                    $match['home'],
                    $match['away'],
                    $match['league'],
                    $match['time'],
                    $match['pred'],
                    $match['odds']
                ]);
            }
        }

        $pdo->commit();
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Hata: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kupon Ekle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f4f6f9; }
        .sidebar { width: 250px; background: #343a40; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 20px; font-weight: bold; background: #23272b; }
        .menu { list-style: none; padding: 0; margin: 0; }
        .menu li a { display: block; padding: 15px 20px; color: #c2c7d0; text-decoration: none; border-bottom: 1px solid #3f474e; }
        .content { margin-left: 250px; padding: 20px; }

        .form-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #495057; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 4px; box-sizing: border-box; }

        .match-list { margin-top: 20px; border-top: 2px solid #eee; padding-top: 20px; }
        .match-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: flex-end; background: #f8f9fa; padding: 15px; border-radius: 6px; }
        .match-row .field { flex: 1; }
        .remove-btn { background: #dc3545; color: white; border: none; padding: 10px; border-radius: 4px; cursor: pointer; height: 40px; }

        .btn-add { background: #17a2b8; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        .btn-save { background: #28a745; color: white; border: none; padding: 15px 30px; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; margin-top: 20px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="menu">
        <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <?php echo __('dashboard'); ?></a></li>
        <li><a href="add_coupon.php"><i class="fas fa-plus-circle"></i> <?php echo __('add_coupon'); ?></a></li>
    </ul>
</div>

<div class="content">
    <h1><?php echo __('add_coupon'); ?></h1>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label><?php echo __('title'); ?></label>
                <input type="text" name="title" required placeholder="Örn: Günün Bankosu">
            </div>

            <div class="form-group">
                <label><?php echo __('coupon_type'); ?></label>
                <select name="type">
                    <option value="Banko"><?php echo __('type_banko'); ?></option>
                    <option value="Popüler"><?php echo __('type_popular'); ?></option>
                    <option value="Sistem"><?php echo __('type_system'); ?></option>
                    <option value="Tekli"><?php echo __('type_single'); ?></option>
                </select>
            </div>

            <div class="form-group">
                <label><?php echo __('confidence_score'); ?> (1-100)</label>
                <input type="number" name="confidence" min="1" max="100" value="90" required>
            </div>

            <h3><?php echo __('matches'); ?></h3>
            <div id="matches-container">
                <!-- Matches will be added here -->
            </div>

            <button type="button" class="btn-add" onclick="addMatch()">+ <?php echo __('add_match'); ?></button>

            <div class="form-group" style="margin-top: 20px; text-align: right; font-size: 20px; font-weight: bold;">
                <?php echo __('total_odds'); ?>: <span id="display-odds">0.00</span>
                <input type="hidden" name="total_odds" id="input-odds" value="0">
            </div>

            <button type="submit" class="btn-save"><?php echo __('save'); ?></button>
        </form>
    </div>
</div>

<script>
let matchCount = 0;

function addMatch() {
    const container = document.getElementById('matches-container');
    const index = matchCount++;

    const html = `
    <div class="match-row" id="match-${index}">
        <div class="field"><label>Lig</label><input type="text" name="matches[${index}][league]" required placeholder="PL"></div>
        <div class="field"><label>Ev Sahibi</label><input type="text" name="matches[${index}][home]" required></div>
        <div class="field"><label>Deplasman</label><input type="text" name="matches[${index}][away]" required></div>
        <div class="field"><label>Saat</label><input type="text" name="matches[${index}][time]" value="20:00" required></div>
        <div class="field"><label>Tahmin</label><input type="text" name="matches[${index}][pred]" required></div>
        <div class="field"><label>Oran</label><input type="number" step="0.01" class="odd-input" name="matches[${index}][odds]" required onchange="calcTotal()"></div>
        <button type="button" class="remove-btn" onclick="removeMatch(${index})"><i class="fas fa-trash"></i></button>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}

function removeMatch(index) {
    document.getElementById('match-' + index).remove();
    calcTotal();
}

function calcTotal() {
    const inputs = document.querySelectorAll('.odd-input');
    let total = 1;
    let hasOdds = false;

    inputs.forEach(input => {
        const val = parseFloat(input.value);
        if(val > 0) {
            total *= val;
            hasOdds = true;
        }
    });

    if(!hasOdds) total = 0;

    const formatted = total.toFixed(2);
    document.getElementById('display-odds').innerText = formatted;
    document.getElementById('input-odds').value = formatted;
}

// Add one match by default
addMatch();
</script>

</body>
</html>
