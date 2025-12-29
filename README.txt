# BetPro - Premium Betting Prediction Script

BetPro, spor bahis tahmin siteleri oluşturmak için hazırlanmış profesyonel bir PHP scriptidir. Hafif yapısı, veritabanı kurulumu gerektirmeyen (SQLite) mimarisi ve gelişmiş admin paneli ile hemen satışa sunabilirsiniz.

## Özellikler
- **Kurulumsuz:** Dosyaları atın ve çalıştırın. SQLite veritabanı kullanır.
- **Çoklu Dil Desteği:** Türkçe ve İngilizce hazır gelir. Kolayca yeni dil eklenebilir.
- **Profesyonel Admin Paneli:** Kupon ekleme, maç yönetimi, istatistikler.
- **Kupon Durum Yönetimi:** Kuponları "Kazandı" veya "Kaybetti" olarak işaretleyip ön yüzde damgalı gösterebilirsiniz.
- **Responsive Tasarım:** Tüm cihazlarla uyumludur.

## Kurulum
1. `BetPro-Script-v1.zip` dosyasını hostinginize (public_html veya www) yükleyin ve çıkarın.
2. Tarayıcınızdan `siteadresi.com/install` adresine gidin.
3. Yönetici kullanıcı adı ve şifrenizi belirleyip "Sistemi Kur" butonuna tıklayın.
4. Kurulum tamamlandıktan sonra `/admin` panelinden giriş yapabilirsiniz.

## Gereksinimler
- PHP 7.4 veya üzeri
- SQLite eklentisi (Genellikle tüm hostinglerde aktiftir)
- Apache Server (`.htaccess` desteği için)

## Güvenlik
Kurulumdan sonra güvenlik için `app/controllers/InstallController.php` dosyasını silebilir veya devre dışı bırakabilirsiniz.
