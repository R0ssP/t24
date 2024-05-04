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

// Table name
$tableName = "colors";

// Drop the table if it exists
$sql_drop_table = "DROP TABLE IF EXISTS $tableName";
if ($conn->query($sql_drop_table) === TRUE) {
} else {
    echo "Error dropping table: " . $conn->error;
}

// SQL to create table
$sql_create_table = "CREATE TABLE $tableName (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    hex_value VARCHAR(7) NOT NULL
)";

// Execute create table query
if ($conn->query($sql_create_table) === TRUE) {
} else {
    echo "Error creating table: " . $conn->error;
}

// SQL to insert data
$sql_insert_data = "INSERT INTO $tableName (ID, name, hex_value) VALUES
    ('1', 'Red', '#FF0000'),
    ('2', 'Orange', '#FFA500'),
    ('3', 'Yellow', '#FFFF00'),
    ('4', 'Green', '#008000'),
    ('5', 'Blue', '#0000FF'),
    ('6', 'Purple', '#800080'),
    ('7', 'Gray', '#808080'),
    ('8', 'Brown', '#A52A2A'),
    ('9', 'Black', '#000000'),
    ('10', 'Teal', '#008080')";

// Execute insert data query
if ($conn->query($sql_insert_data) === TRUE) {
} else {
    echo "Error inserting data: " . $conn->error;
}

// Close connection
$conn->close();
?>
