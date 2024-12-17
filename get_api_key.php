<?php
// 啟用錯誤顯示
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// 載入 dotenv 環境變數
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 從環境變數中取得 API Key
$apiKey = $_ENV['GOOGLE_MAPS_API_KEY'];

echo json_encode(['apiKey' => $apiKey]);
?>
