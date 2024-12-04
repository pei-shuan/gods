<?php
header('Content-Type: application/json');

// 資料庫連線
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// 接收關鍵字
$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : "";

// SQL 查詢，根據關鍵字篩選資料
$sql = "
    SELECT r.name AS name, c.name AS area, t.desc AS year
    FROM rel_location AS r
    INNER JOIN city AS c ON r.city_id = c.id
    INNER JOIN rel_location_timeline AS t ON r.id = t.id
    WHERE r.name LIKE '%$keyword%' -- 關鍵字篩選
    ORDER BY t.desc DESC
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "name" => $row["name"],
            "area" => $row["area"],
            "year" => $row["year"]
        ];
    }
}

$conn->close();

// 返回 JSON 資料
echo json_encode($data);
?>
