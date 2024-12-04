<?php
$servername = "localhost";
$username = "root";
$password = "a26656901";
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗：" . $conn->connect_error);
}

$action = $_GET['action'] ?? '';

if ($action === 'fetch') {
    $name = $_GET['name'] ?? '';
    $sql = "SELECT * FROM rel_type WHERE name LIKE '%$name%'";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} elseif ($action === 'add') {
    $name = $_POST['name'] ?? '';
    $sql = "INSERT INTO rel_type (name) VALUES ('$name')";
    $conn->query($sql);
} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? 0;
    $sql = "DELETE FROM rel_type WHERE id = $id";
    $conn->query($sql);
}

$conn->close();
?>
