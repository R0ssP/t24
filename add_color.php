<?php
session_start();

// MySQLi connection
$servername = "faure";
$username = "EID";
$password = "*****";
$database = "EID";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data for insertion
    $name = $_POST['name'];
    $hex = $_POST['hex'];

    // Check if name or hex already exists
    $check_sql = "SELECT COUNT(*) AS count FROM colors WHERE name = ? OR hex_value = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $name, $hex);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();
    $existing_count = $row['count'];

    if ($existing_count > 0) {
        $_SESSION['alert'] = "Color with the same name or hex already exists. Please choose a different name or hex value.";
    } else {
        // SQL query to insert data into table
        $sql = "INSERT INTO colors (name, hex_value) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $hex);

        if ($stmt->execute() === TRUE) {
            // Success message if insertion is successful
            $_SESSION['success'] = "Color added successfully!";
        } else {
            // Error message if insertion fails
            $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
        }
        // Close the connection
        $stmt->close();
    }

    // Close check statement
    $check_stmt->close();

    // Close the connection
    $conn->close();

    // Redirect back to the form page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // If not submitted, redirect to home page or display an error message
    header("Location: index.php");
    exit();
}
?>
