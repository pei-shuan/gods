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
$dbname = "religiongis";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get city and town from request parameters
$city = isset($_GET['city']) ? $conn->real_escape_string($_GET['city']) : '';
$town = isset($_GET['town']) ? $conn->real_escape_string($_GET['town']) : '';

// Prepare the base SQL query
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
        county ON city.county_id = county.ID";

// Add conditions based on provided parameters
if (!empty($city) && !empty($town)) {
    // Both city and town are selected
    $sql .= " WHERE county.name = '$city' AND city.name = '$town'";
} elseif (!empty($city)) {
    // Only city is selected
    $sql .= " WHERE county.name = '$city'";
}

// Execute the query
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

// Return the results as JSON
echo json_encode($temples);

$conn->close();
