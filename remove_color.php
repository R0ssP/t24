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
    // Prepare data
    $ID = $_POST['delete_ID'];

    // Check if there are more than 2 records in the table
    $count_query = "SELECT COUNT(*) as count FROM colors";
    $count_result = $conn->query($count_query);
    if ($count_result && $count_result->num_rows == 1) {
        $row = $count_result->fetch_assoc();
        $count = $row['count'];
        if ($count > 2) { // Only proceed with deletion if more than 2 records
            // SQL query to delete data from the table
            $sql_delete = "DELETE FROM colors WHERE ID=?";

            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("i", $ID); // assuming ID is an integer

            if ($stmt_delete->execute() === TRUE) {
                // Deleting succeeded
                // Now, renumber the IDs
                $sql_update = "SET @num := 0; UPDATE colors SET ID = @num := (@num+1); ALTER TABLE colors AUTO_INCREMENT = 1;";
                if ($conn->multi_query($sql_update) === TRUE) {
                    echo "Record deleted and IDs renumbered successfully"; // Debugging purposes
                } else {
                    echo "Error updating IDs: " . $conn->error;
                }
            } else {
                echo "Error deleting record: " . $stmt_delete->error;
            }

            // Close the connection
            $stmt_delete->close();
        } else {
            session_start();
            $_SESSION['alert'] = "Cannot delete record. There must be at least two records in the table.";
            header("Location: color_selection.php");
        }
    } else {
        echo "Error retrieving record count: " . $conn->error;
    }

    // Close the connection
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
