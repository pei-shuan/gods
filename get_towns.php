<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cityId = $_GET['city_id'];

$query = "SELECT town_id, town_name FROM towns WHERE city_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $cityId);
$stmt->execute();
$result = $stmt->get_result();

$towns = [];
while ($row = $result->fetch_assoc()) {
    $towns[] = $row;
}

echo json_encode($towns);
?>