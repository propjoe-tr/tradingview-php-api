<?php
/**
 * TradingView Fiyat API
 * Kullanım: tradingview.php?symbol=OANDA:XAUUSD
 * Birden fazla: tradingview.php?symbol=OANDA:XAUUSD,BINANCE:BTCUSDT
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$symbolParam = $_GET['symbol'] ?? null;

if (!$symbolParam) {
    echo json_encode([
        'success' => false,
        'error' => 'Sembol belirtilmedi',
        'usage' => 'tradingview.php?symbol=OANDA:XAUUSD'
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$symbols = array_map('trim', explode(',', $symbolParam));

$fields = [
    'price_52_week_high',
    'price_52_week_low',
    'sector',
    'market',
    'Low.1M',
    'High.1M',
    'Perf.W',
    'Perf.1M',
    'Perf.3M',
    'Perf.6M',
    'Perf.Y',
    'Perf.YTD',
    'Recommend.All',
    'average_volume_10d_calc',
    'average_volume_30d_calc',
    'close',
    'open',
    'high',
    'low',
    'change',
    'change_abs',
    'volume'
];

function getSymbolData(string $symbol, array $fields): ?array
{
    $url = 'https://scanner.tradingview.com/symbol?' . http_build_query([
        'symbol' => $symbol,
        'fields' => implode(',', $fields),
        'no_404' => 'true'
    ]);

    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Accept: application/json',
            'Origin: https://tr.tradingview.com',
            'Referer: https://tr.tradingview.com/'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => 'gzip',
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        return null;
    }

    return json_decode($response, true);
}

$results = [];
foreach ($symbols as $symbol) {
    $data = getSymbolData($symbol, $fields);
    
    if ($data) {
        $results[$symbol] = [
            'price' => $data['close'] ?? null,           // Güncel fiyat
            'open' => $data['open'] ?? null,
            'high' => $data['high'] ?? null,
            'low' => $data['low'] ?? null,
            'change_percent' => $data['change'] ?? null,
            'change' => $data['change_abs'] ?? null,
            'volume' => $data['volume'] ?? null,
            'avg_volume_10d' => $data['average_volume_10d_calc'] ?? null,
            'avg_volume_30d' => $data['average_volume_30d_calc'] ?? null,
            'high_52w' => $data['price_52_week_high'] ?? null,
            'low_52w' => $data['price_52_week_low'] ?? null,
            'high_1m' => $data['High.1M'] ?? null,
            'low_1m' => $data['Low.1M'] ?? null,
            'perf_week' => $data['Perf.W'] ?? null,
            'perf_month' => $data['Perf.1M'] ?? null,
            'perf_3month' => $data['Perf.3M'] ?? null,
            'perf_6month' => $data['Perf.6M'] ?? null,
            'perf_year' => $data['Perf.Y'] ?? null,
            'perf_ytd' => $data['Perf.YTD'] ?? null,
            'recommendation' => $data['Recommend.All'] ?? null,
            'sector' => $data['sector'] ?? null,
            'market' => $data['market'] ?? null
        ];
    } else {
        $results[$symbol] = ['error' => 'Veri alınamadı'];
    }
}

if (count($symbols) === 1) {
    $symbol = $symbols[0];
    echo json_encode([
        'success' => true,
        'symbol' => $symbol,
        'data' => $results[$symbol],
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        'success' => true,
        'count' => count($symbols),
        'data' => $results,
        'timestamp' => date('Y-m-d H:i:s')
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
