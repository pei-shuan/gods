<?php
// 啟用錯誤回報（僅用於開發階段）
error_reporting(E_ALL);
ini_set('display_errors', 1);


// 設定 CORS 和內容類型
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


// 資料庫連線設定
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// 取得篩選條件
$city_id = isset($_GET['city_id']) ? (int)$_GET['city_id'] : 0;
$town_name = isset($_GET['town_name']) ? $_GET['town_name'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';


// SQL 查詢
$sql = "
    SELECT
        rel_location.name AS temple_name,
        rel_location.addr AS location_address,
        city.name AS city,
        county.name AS town,
        ST_X(rel_location.location) AS lng,
        ST_Y(rel_location.location) AS lat
    FROM
        rel_location
    JOIN
        city ON rel_location.city_id = city.ID
    JOIN
        county ON city.county_id = county.ID
    WHERE 1=1
";


$params = [];
$types = "";


// 加入 county.ID 條件
if ($city_id > 0) {
    $sql .= " AND county.ID = ?";
    $params[] = $city_id;
    $types .= "i";
}


// 加入 town_name 條件
if (!empty($town_name)) {
    $sql .= " AND county.name = ?";
    $params[] = $town_name;
    $types .= "s";
}


// 加入 temple_name 模糊查詢條件
if (!empty($name)) {
    $sql .= " AND rel_location.name LIKE ?";
    $params[] = "%" . $name . "%";
    $types .= "s";
}


// 預備語句
$stmt = $conn->prepare($sql);


// 綁定參數
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}


$stmt->execute();
$result = $stmt->get_result();


// 構造輸出結果
$output = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output[] = [
            'name' => $row['temple_name'],
            'address' => $row['location_address'],
            'position' => [
                'lat' => (float)$row['lat'],
                'lng' => (float)$row['lng'],
            ],
        ];
    }
} else {
    echo json_encode(["message" => "No temples found for the given criteria."]);
    exit;
}


// 輸出 JSON 結果
echo json_encode($output);
$stmt->close();
$conn->close();
?>

