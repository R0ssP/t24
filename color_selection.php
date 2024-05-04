<!DOCTYPE html>
<html>
    <?php
    session_start();
    ?>
<head>
    <title>Color Coordinate Generation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="CSU CS312 HTML Group Project">
    <meta name="description" content="Milestone 1 Group project submission">
    <meta name="keywords" content="HTML5">
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
<div class="Header">
    <img src="./images/logo.png" alt="Trident rising from the waves" class="logo">

    <div class="NavBar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
            <li><a href="colorcoord.php">Color Coordination</a></li>
            <li><a href="color_selection.php">Color Selection</a></li>
        </ul>
    </div>

    <header><h1>Color Selector</h1></header>
</div>


<?php
if(!isset($_SESSION['load'])) {
    require_once 'create_color_selection.php';

    $_SESSION['load'] = true;
}
?>

<?php
include 'show_color_selection.php';
?>

<form id="reset">
    <button type="button" onclick="resetTable()">Reset Table</button>
</form>



<div class="Add">
<h2>Add Color</h2>
    <form action="add_color.php" method="post" id="add">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="hex">Hex Value:</label><br>
        <input type="text" id="hex" name="hex"><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<div class="Edit">
<h2>Edit Color</h2>
    <form action="edit_color.php" method="post" id="edit">
        <label for="edit_ID">ID:</label><br>
        <input type="text" id="edit_ID" name="edit_ID"><br>
        <label for="edit_name">Name:</label><br>
        <input type="text" id="edit_name" name="edit_name"><br>
        <label for="edit_hex">Hex Value:</label><br>
        <input type="text" id="edit_hex" name="edit_hex"><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<div class="Remove">
    <h2>Remove Color</h2>
    <form action="remove_color.php" method="post" id="remove">
        <label for="delete_ID">ID:</label><br>
        <input type="text" id="delete_ID" name="delete_ID"><br>
        <input type="submit" value="Submit">
    </form>
</div>


    <?php
    
    if(isset($_SESSION['alert'])) {
        echo "<script>alert('" . $_SESSION['alert'] . "');</script>";
        unset($_SESSION['alert']);
    }
    ?>




<!-- Leave this div empty it is for the waves above the footer -->
<div class="footerImg"></div>
<footer>
    <p>
        Website created by CS312 Group 24. Logo from Marine Vectors Logo by Vecteezy. Waves from istockphoto.
    </p>
</footer>
</body>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Find the form element
        var form = document.getElementById("yourFormId");

        // Add event listener for form submission
        form.addEventListener("submit", function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Create a new XMLHttpRequest object
            var xhttp = new XMLHttpRequest();

            // Define the PHP file to call
            var phpFile = "/s/bach/l/under/zrnall/local_html/t24/show_color_selection.php";

            // Set up the request
            xhttp.open("GET", phpFile, true);

            // Define what to do when the response comes back
            xhttp.onreadystatechange = function() {
                // Check if the request is complete
                if (this.readyState == 4 && this.status == 200) {
                    // Response from the server
                    console.log(this.responseText);
                    // Optionally, you can do something with the response here
                }
            };

            // Send the request
            xhttp.send();
        });
    });
</script>

<script>
    function resetTable() {
        // Send a request to the PHP file
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "create_color_selection.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Output the response from the PHP file
                console.log(xhr.responseText);
                // Reload the page to update the color selection table
                window.location.reload(true);
            }
        };
        xhr.send();
    }
</script>


</html>
