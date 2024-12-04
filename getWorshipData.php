<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";

// 建立連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 接收前端傳遞的關鍵字
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// SQL 語句（支援關鍵字查詢）
$sql = "SELECT `id`, `name`, `desc` FROM deities WHERE `name` LIKE ?";
$stmt = $conn->prepare($sql);

// 綁定參數並執行
$searchParam = "%" . $keyword . "%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();

$result = $stmt->get_result();
$data = array();

if ($result->num_rows > 0) {
    // 輸出每一行資料
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// 關閉連接
$stmt->close();
$conn->close();

// 將資料轉換為 JSON 格式
header('Content-Type: application/json');
echo json_encode($data);
?>


