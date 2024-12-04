<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

// 資料庫連線設定
$host = 'localhost'; // 主機
$dbname = 'religiongis'; // 資料庫名稱
$username = 'root'; // 使用者名稱
$password = '12345678'; // 密碼

try {
    // 建立資料庫連線
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 接收搜尋參數
    $name = isset($_GET['name']) ? trim($_GET['name']) : '';

    // SQL 查詢
    $sql = "SELECT id, name, latitude, longitude FROM rel_location WHERE name LIKE :name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => "%$name%"]);

    // 取得查詢結果
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 回傳 JSON
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
