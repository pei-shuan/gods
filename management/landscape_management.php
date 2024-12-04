<?php
$servername = "localhost";
$username = "root";
$password = "a26656901";
$dbname = "religiongis";

// 建立資料庫連接
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // 查詢縣市資料
    if ($action === 'getCounties') {
        $sql = "SELECT id, name FROM county"; // 從 county 表格抓取縣市名稱
        $result = $conn->query($sql);
        $counties = [];
        while ($row = $result->fetch_assoc()) {
            $counties[] = $row;
        }
        echo json_encode($counties); // 返回縣市資料
    }

    // 查詢市區資料
    if ($action === 'getCities') {
        $country_id = $_POST['country_id'];
        $sql = "SELECT id, name FROM city WHERE country_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $country_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cities = [];
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }
        echo json_encode($cities); // 返回市區資料
    }

    // 搜尋地景資料
    if ($action === 'searchLandscapes') {
        $country_id = $_POST['country_id'];
        $city_id = $_POST['city_id'];
        $name = $_POST['name'];
        $sql = "SELECT id, name, addr FROM landscape WHERE country_id LIKE ? AND city_id LIKE ? AND name LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $country_id, $city_id, "%$name%");
        $stmt->execute();
        $result = $stmt->get_result();
        $landscapes = [];
        while ($row = $result->fetch_assoc()) {
            $landscapes[] = $row;
        }
        echo json_encode($landscapes); // 返回搜尋結果
    }

    // 刪除地景
    if ($action === 'deleteLandscape') {
        $id = $_POST['id'];
        $sql = "DELETE FROM landscape WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(['status' => 'success']); // 回應刪除結果
    }
}

$conn->close();
?>
