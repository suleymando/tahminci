# Kolay Kuponlar - WordPress Tema ve Eklenti Paketi

Bu proje, spor bahis tahminleri ve kupon paylaşımları için özel olarak tasarlanmış bir WordPress teması ve çekirdek eklentisinden oluşur.

## Kurulum Talimatları

Sistemi çalıştırmak için hem temayı hem de eklentiyi kurmanız gerekmektedir.

### 1. Dosyaların Hazırlanması
İndirdiğiniz proje klasöründeki şu iki klasörü ayrı ayrı `.zip` formatında sıkıştırın:
- `kolay-kuponlar-tema` -> `kolay-kuponlar-tema.zip`
- `kolay-kuponlar-core` -> `kolay-kuponlar-core.zip`

### 2. Eklentinin Kurulması (Önemli: Önce bunu yapın)
1. WordPress Admin Paneline giriş yapın.
2. Sol menüden **Eklentiler > Yeni Ekle** sayfasına gidin.
3. **Eklenti Yükle** butonuna tıklayın.
4. `kolay-kuponlar-core.zip` dosyasını seçip yükleyin ve **Etkinleştirin**.
   - *Bu işlem sol menüye "Kuponlar" özelliğini getirecektir.*

### 3. Temanın Kurulması
1. Sol menüden **Görünüm > Temalar** sayfasına gidin.
2. **Yeni Ekle** butonuna ve ardından **Tema Yükle** butonuna tıklayın.
3. `kolay-kuponlar-tema.zip` dosyasını seçip yükleyin ve **Etkinleştirin**.

## Kullanım (Kupon Ekleme)

Kurulum tamamlandıktan sonra kupon paylaşmak için:

1. Sol menüdeki **Kuponlar > Yeni Ekle** sayfasına gidin.
2. Kupon başlığını girin (Örn: "Günün Bankosu").
3. **Kupon Detayları** kutusuna gelin:
   - **Kupon Türü:** "Banko Kupon" veya "Popüler Kupon" yazın (Renkler buna göre otomatik değişir).
   - **Toplam Oran:** Kuponun toplam oranını yazın (Örn: 3.50).
   - **Maç Ekle Butonu:** Her bir maç için butona tıklayın ve Takım isimleri, Saat, Tahmin ve Oran bilgilerini girin.
4. Sağ taraftan **Yayımla** butonuna basın.

## Notlar
- "Banko Kupon" yazarsanız başlık koyu lacivert/gri olur.
- "Popüler Kupon" yazarsanız başlık yine koyu tema uyumlu olur ve yıldız ikonu çıkar.
- "Hemen Oyna" butonları kuponun detay sayfasına yönlendirir.
