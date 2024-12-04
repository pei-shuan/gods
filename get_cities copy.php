<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT city_id, city_name FROM cities";
$result = $db->query($query);

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row;
}

echo json_encode($cities);
?>