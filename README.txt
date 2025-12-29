# BetPro - Premium Betting Script (PHP)

BetPro, spor bahis tahminlerinizi paylaşabileceğiniz modern, hızlı ve kurulum gerektirmeyen bir PHP scriptidir.

## Özellikler
- **Modern Tasarım:** Şık kupon kartları, Güven Barı (Confidence Meter), Kazandı/Kaybetti damgaları.
- **Yönetim Paneli:** Kullanımı kolay arayüz. Kupon eklerken maçları dinamik olarak girin, oranlar otomatik çarpılsın.
- **Filtreleme:** Banko, Popüler, Sistem, Tekli kuponları kolayca filtreleyin.
- **Çoklu Dil:** Türkçe ve İngilizce desteği (otomatik veya manuel geçiş).
- **Kurulumsuz:** SQLite veritabanı sayesinde veritabanı oluşturmanıza gerek yok. Dosyaları atın ve çalışın.

## Kurulum
1. Tüm dosyaları sunucunuza (public_html) yükleyin.
2. Tarayıcınızdan sitenize girin. Otomatik olarak kurulum ekranı (`install.php`) açılacaktır (veya `site.com/install.php` adresine gidin).
3. Admin kullanıcı adı ve şifrenizi belirleyin.
4. Kurulum bitti! `/admin` adresinden panele girip kupon eklemeye başlayın.
5. Güvenlik için `install.php` dosyasını silin.

## Gereksinimler
- PHP 7.4 veya üzeri
- SQLite eklentisi (Standart olarak tüm hostinglerde açıktır)
