<?php
// Enable error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set CORS and content-type headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "gis2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get city and town from request parameters
$city = isset($_GET['city']) ? $_GET['city'] : '';
$town = isset($_GET['town']) ? $_GET['town'] : '';

// Prepare the SQL query with city and town filters
$sql = "SELECT temple_name, address, city, town, cenx, ceny 
        FROM temples
        JOIN coordinates ON temples.temple_id = coordinates.coordinates_id
        WHERE 1=1";

// Add conditions based on city and town
if (!empty($city)) {
    $sql .= " AND city = '" . $conn->real_escape_string($city) . "'";
}
if (!empty($town)) {
    $sql .= " AND town = '" . $conn->real_escape_string($town) . "'";
}

$result = $conn->query($sql);
$temples = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $temples[] = array(
            'name' => $row['temple_name'],
            'address' => $row['address'] . ', ' . $row['city'] . ', ' . $row['town'],
            'position' => array(
                'lat' => floatval($row['cenx']),
                'lng' => floatval($row['ceny']),
            ),
            'city' => $row['city'],
            'town' => $row['town']
        );
    }
}

echo json_encode($temples);

$conn->close();
?>