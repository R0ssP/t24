<?php
$color = $_GET['color'];
// Connect to your MySQL database
$mysqli = new mysqli('faure', 'EID', 'Password', 'EID');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$query = "SELECT name, hex_value FROM colors WHERE hex_value = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $color);
$stmt->execute();

// Check for errors
if ($stmt->error) {
    die('Query Error: ' . $stmt->error);
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);
?>