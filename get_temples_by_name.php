<?php
// 啟用錯誤顯示
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// 資料庫連線
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 接收地景名稱參數
$temple_name = isset($_GET['temple_name']) ? $conn->real_escape_string($_GET['temple_name']) : '';

if (empty($temple_name)) {
    echo json_encode([]);
    exit();
}

// SQL 查詢語句
$sql = "SELECT
            rel_location.name AS temple_name,
            rel_location.addr AS address,
            county.name AS city,
            city.name AS town,
            ST_Y(rel_location.location) AS cenx,
            ST_X(rel_location.location) AS ceny
        FROM
            rel_location
        JOIN
            city ON rel_location.city_id = city.ID
        JOIN
            county ON city.county_id = county.ID
        WHERE
            rel_location.name LIKE '%$temple_name%'";

$result = $conn->query($sql);
$temples = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $temples[] = [
            'name' => $row['temple_name'],
            'address' => $row['address'] . ', ' . $row['city'] . ', ' . $row['town'],
            'position' => [
                'lat' => floatval($row['cenx']),
                'lng' => floatval($row['ceny']),
            ],
            'city' => $row['city'],
            'town' => $row['town'],
        ];
    }
}

echo json_encode($temples);
$conn->close();
?>
