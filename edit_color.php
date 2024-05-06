<?php
// MySQLi connection
$servername = "faure";
$username = "rossp";
$password = "833018712";
$database = "rossp";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data for insertion
    $ID = $_POST['edit_ID'];

    // Retrieve original values from the database
    $original_values = $conn->query("SELECT name, hex_value FROM colors WHERE ID=$ID")->fetch_assoc();

    // Check if input is empty, if so, use original values
    $name = !empty($_POST['edit_name']) ? $_POST['edit_name'] : $original_values['name'];
    $hex = !empty($_POST['edit_hex']) ? $_POST['edit_hex'] : $original_values['hex_value'];

    echo $name . $hex; // Debugging purposes

    // SQL query to update data in the table
    $sql = "UPDATE colors SET name=?, hex_value=? WHERE ID=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $hex, $ID); 

    if ($stmt->execute() === TRUE) {
        echo "Record updated successfully"; // Debugging purposes
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();

    // Redirect to the page from where the request was made
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    exit();
} else {
    // If not submitted, redirect to home page or display an error message
    header("Location: index.php");
    exit();
}
?>
