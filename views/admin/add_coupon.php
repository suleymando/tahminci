<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kupon Ekle - BetPro Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; background: #f4f7f6; }
        .sidebar { width: 250px; background: #2c3e50; color: white; height: 100vh; position: fixed; }
        .sidebar-header { padding: 20px; font-size: 1.2rem; font-weight: bold; border-bottom: 1px solid #34495e; }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu a { display: block; padding: 15px 20px; color: #bdc3c7; text-decoration: none; border-left: 3px solid transparent; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: #34495e; color: white; border-left-color: #00904a; }
        .main-content { margin-left: 250px; flex: 1; padding: 20px; }

        .form-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 800px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }

        .matches-container { margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px; }
        .match-row { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #f9f9f9; padding: 10px; border: 1px solid #eee; }
        .match-row input { flex: 1; }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; color: white; font-weight: bold; font-size: 0.9rem; border: none; cursor: pointer; }
        .btn-green { background: #00904a; }
        .btn-blue { background: #3498db; }
        .btn-red { background: #e74c3c; padding: 5px 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">BetPro Admin</div>
    <ul class="sidebar-menu">
        <li><a href="/admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="/admin/coupons" class="active"><i class="fas fa-ticket-alt"></i> Kuponlar</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Yeni Kupon Ekle</h1>

    <div class="form-card">
        <form method="POST" action="/admin/add_coupon">
            <div class="form-group">
                <label>Kupon Başlığı</label>
                <input type="text" name="title" placeholder="Örn: Günün Bankosu" required>
            </div>

            <div class="form-group" style="display: flex; gap: 20px;">
                <div style="flex:1">
                    <label>Kupon Tipi</label>
                    <select name="type">
                        <option value="Banko Kupon">Banko Kupon</option>
                        <option value="Popüler Kupon">Popüler Kupon</option>
                        <option value="Sürpriz Kupon">Sürpriz Kupon</option>
                    </select>
                </div>
                <div style="flex:1">
                    <label>Toplam Oran</label>
                    <input type="text" name="total_odds" placeholder="Örn: 3.50" required>
                </div>
            </div>

            <div class="matches-container">
                <h3>Maçlar</h3>
                <div id="matches-wrapper">
                    <!-- Dynamic rows here -->
                </div>
                <button type="button" class="btn btn-blue" id="add-match-btn"><i class="fas fa-plus"></i> Maç Ekle</button>
            </div>

            <div style="margin-top: 30px; text-align: right;">
                <button type="submit" class="btn btn-green">Kuponu Kaydet</button>
            </div>
        </form>
    </div>
</div>

<script>
    let matchIndex = 0;
    const wrapper = document.getElementById('matches-wrapper');

    document.getElementById('add-match-btn').addEventListener('click', () => {
        const html = `
            <div class="match-row">
                <input type="text" name="matches[${matchIndex}][home]" placeholder="Ev Sahibi" required>
                <input type="text" name="matches[${matchIndex}][away]" placeholder="Deplasman" required>
                <input type="text" name="matches[${matchIndex}][time]" placeholder="Saat (22:00)" style="max-width: 100px;">
                <input type="text" name="matches[${matchIndex}][prediction]" placeholder="Tahmin (MS 1)" style="max-width: 120px;">
                <input type="text" name="matches[${matchIndex}][odds]" placeholder="Oran" style="max-width: 80px;">
                <button type="button" class="btn btn-red" onclick="this.parentElement.remove()">X</button>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        matchIndex++;
    });

    // Add one row by default
    document.getElementById('add-match-btn').click();
</script>

</body>
</html>
