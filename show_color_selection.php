<?php
// MySQLi connection
$servername = "faure";
$username = "spazz";
$password = "835888859";
$database = "spazz";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the table
$sql_fetch_data = "SELECT * FROM colors";
$result = $conn->query($sql_fetch_data);

if (!$result) {
    die("Query failed: " . $conn->error);
}

echo "<h2>Colors Table</h2>";
echo "<table class='color-table'>";
echo "<tr><th>ID</th><th>Name</th><th>Hex Value</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['ID']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['hex_value']."</td>";
    echo "</tr>";
}
echo "</table>";

// Close the connection
$conn->close();
?>