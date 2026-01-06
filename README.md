# 📈 TradingView PHP API

<p align="center">
  <img src="https://img.shields.io/badge/PHP-7.4+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
  <img src="https://img.shields.io/badge/TradingView-API-2962FF?style=for-the-badge&logo=tradingview&logoColor=white" alt="TradingView">
</p>

<p align="center">
  TradingView'den gerçek zamanlı fiyat, hacim ve performans verilerini çeken hafif PHP API.
  <br>
  <strong>Resmi olmayan API · Ücretsiz · Kolay Kullanım</strong>
</p>

---

## ✨ Özellikler

- 🚀 **Hızlı** - Tek HTTP isteği ile anlık veri
- 💰 **Ücretsiz** - API anahtarı gerektirmez
- 🌍 **Geniş Kapsam** - Forex, Kripto, Hisse, Emtia desteği
- 📊 **Zengin Veri** - Fiyat, hacim, performans, teknik analiz
- 🔄 **Çoklu Sembol** - Tek istekte birden fazla sembol sorgulama

---

## 🛠️ Kurulum

### Gereksinimler
- PHP 7.4+
- cURL extension

### Adımlar

```bash
# 1. Repo'yu klonla
git clone https://github.com/propjoe-tr/tradingview-php-api.git

# 2. Web sunucusuna kopyala
cp tradingview.php /var/www/html/
```

> 💡 **Laragon, XAMPP, WAMP** gibi local sunucularda direkt çalışır.

---

## 📖 Kullanım

### 🔹 Tek Sembol

```
GET /tradingview.php?symbol=OANDA:XAUUSD
```

### 🔹 Birden Fazla Sembol

```
GET /tradingview.php?symbol=OANDA:XAUUSD,BINANCE:BTCUSDT,BIST:THYAO
```

### 🔹 cURL ile

```bash
curl "http://localhost/tradingview.php?symbol=OANDA:XAUUSD"
```

### 🔹 JavaScript ile

```javascript
fetch('http://localhost/tradingview.php?symbol=BINANCE:BTCUSDT')
  .then(res => res.json())
  .then(data => console.log(data.data.price));
```

### 🔹 PHP ile

```php
$data = json_decode(file_get_contents('http://localhost/tradingview.php?symbol=BIST:THYAO'), true);
echo $data['data']['price'];
```

---

## 📋 Örnek Çıktı

```json
{
    "success": true,
    "symbol": "OANDA:XAUUSD",
    "data": {
        "price": 4480.53,
        "open": 4454.80,
        "high": 4494.16,
        "low": 4427.63,
        "change_percent": 0.70,
        "change": 31.36,
        "volume": 947654,
        "avg_volume_10d": 1090295,
        "avg_volume_30d": 830515,
        "high_52w": 4550.15,
        "low_52w": 2645.37,
        "high_1m": 4550.15,
        "low_1m": 4169.98,
        "perf_week": 3.19,
        "perf_month": 6.44,
        "perf_3month": 12.39,
        "perf_6month": 35.12,
        "perf_year": 69.72,
        "perf_ytd": 3.56,
        "recommendation": 0.46,
        "sector": "Metals",
        "market": "cfd"
    },
    "timestamp": "2026-01-06 19:59:11"
}
```

---

## 🏦 Desteklenen Borsalar

| Borsa | Prefix | Örnek |
|:------|:-------|:------|
| 🥇 Forex/Emtia | `OANDA` | `OANDA:XAUUSD`, `OANDA:EURUSD` |
| ₿ Kripto | `BINANCE` | `BINANCE:BTCUSDT`, `BINANCE:ETHUSDT` |
| 🇹🇷 BIST | `BIST` | `BIST:THYAO`, `BIST:GARAN`, `BIST:SISE` |
| 🇺🇸 NASDAQ | `NASDAQ` | `NASDAQ:AAPL`, `NASDAQ:MSFT` |
| 🇺🇸 NYSE | `NYSE` | `NYSE:TSLA`, `NYSE:BA` |
| 📊 Endeksler | `TVC` | `TVC:DXY`, `TVC:SPX` |

---

## 📊 Veri Alanları

| Alan | Açıklama | Örnek |
|:-----|:---------|:------|
| `price` | 💰 Güncel fiyat | `4480.53` |
| `open` | 📈 Açılış fiyatı | `4454.80` |
| `high` | 🔺 Günün en yükseği | `4494.16` |
| `low` | 🔻 Günün en düşüğü | `4427.63` |
| `change_percent` | 📊 Değişim (%) | `0.70` |
| `change` | 📉 Değişim (mutlak) | `31.36` |
| `volume` | 📦 İşlem hacmi | `947654` |
| `avg_volume_10d` | 📊 10 günlük ort. hacim | `1090295` |
| `avg_volume_30d` | 📊 30 günlük ort. hacim | `830515` |
| `high_52w` | 📈 52 haftalık en yüksek | `4550.15` |
| `low_52w` | 📉 52 haftalık en düşük | `2645.37` |
| `perf_week` | 📅 Haftalık performans (%) | `3.19` |
| `perf_month` | 📅 Aylık performans (%) | `6.44` |
| `perf_year` | 📅 Yıllık performans (%) | `69.72` |
| `recommendation` | 💡 Teknik analiz önerisi | `0.46` |
| `sector` | 🏭 Sektör | `Metals` |
| `market` | 🌐 Piyasa türü | `cfd` |

### 💡 Recommendation Değerleri

| Değer | Anlam |
|:------|:------|
| `0.5` ile `1.0` | 🟢 Güçlü Al |
| `0.1` ile `0.5` | 🟢 Al |
| `-0.1` ile `0.1` | ⚪ Nötr |
| `-0.5` ile `-0.1` | 🔴 Sat |
| `-1.0` ile `-0.5` | 🔴 Güçlü Sat |

---

## ⚠️ Önemli Notlar

> 🔸 Bu proje TradingView'in resmi API'si değildir.
> 
> 🔸 Kişisel kullanım ve eğitim amaçlıdır.
> 
> 🔸 Yoğun istek göndermekten kaçının (rate limit).
> 
> 🔸 Ticari kullanım için [TradingView API](https://www.tradingview.com/rest-api-spec/) lisansı alın.

---

## 📄 Lisans

MIT License - Dilediğiniz gibi kullanabilirsiniz.

---

<p align="center">
  ⭐ Beğendiyseniz yıldız vermeyi unutmayın!
</p>
