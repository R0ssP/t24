<!DOCTYPE html>
<html>
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

        <header><h1>Color Coordinate Generation</h1></header>
    </div>

    <div class="content">
        <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="rows_columns">Enter number of rows & columns:</label>
            <input type="number" id="rows_columns" name="rows_columns" class="button" placeholder="Enter a number">
            <br>
            <label for="colors">Enter number of colors:</label>
            <input type="number" id="colors" name="colors" class="button" placeholder="Enter a number">
            <br>
            <input type="submit" value="Generate" class="button">
        </form>
        <div id="message"></div>
        <?php
        function validateInput($value, $min, $max, $name)
        {
            if (!is_numeric($value) || $value < $min || $value > $max) {
                echo "Error: $name must be a number between $min and $max.<br>";
                return false;
            }
            return true;
        }

        $valid = true;
$rows_columns = isset($_GET['rows_columns']) ? $_GET['rows_columns'] : null;
$colors = isset($_GET['colors']) ? $_GET['colors'] : null;

$valid = validateInput($rows_columns, 1, 26, "Rows & Columns") && $valid;
$valid = validateInput($colors, 1, 10, "Number of colors") && $valid;

if (!$valid) {
    exit;
}

// Connect to your database
$db = new mysqli('faure', 'zrnall', 'Tiffany06833157', 'zrnall');

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Execute a query to fetch the color options
$result = $db->query("SELECT name, hex_value FROM colors");

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $db->error);
}

// Fetch the color options and store them in an associative array
$color_options = [];
while ($row = $result->fetch_assoc()) {
    $color_options[$row['name']] = $row['hex_value'];
}

// Close the database connection
$db->close();

echo "<form method='post' action='printable_view.php'>";
echo "<input type='hidden' name='colors' value='$colors'>"; 

echo "<table border='1' class='table firsttable'>";
$color_names = array_keys($color_options);
for ($i = 0; $i < $colors; $i++) {
    echo "<tr>";
    echo "<td width='10%'><input type='radio' name='selectedColor' value='$i'" . ($i == 0 ? " checked" : "") . "></td>";
    echo "<td width='10%'><select class='option color-dropdown' name='color$i'>";
    foreach ($color_options as $name => $hex) {
        $selected = $color_names[$i] === $name ? 'selected' : '';
        echo "<option value='$hex' $selected>$name</option>";
    }
    echo "</select></td>";
    echo "<td width='80%'></td>";
    echo "</tr>";
}
echo "</table>";

echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedColors = [];
    var dropdowns = document.querySelectorAll('.color-dropdown');
    dropdowns.forEach(function(dropdown, index) {
        selectedColors[index] = dropdown.value;

        // Add an event listener to each dropdown
        dropdown.addEventListener('change', function() {
            // Get the old and new color values
            var oldColor = selectedColors[index];
            var newColor = dropdown.value;

            // Update the selected color for this dropdown
            selectedColors[index] = newColor;

            // Change the color of the cells in the coordinate table that match the old color
            var cells = document.querySelectorAll('.coordinate-table td');
            cells.forEach(function(cell) {
                if (cell.style.backgroundColor === oldColor) {
                    cell.style.backgroundColor = newColor;
                }
            });
        });
    });
});
</script>";

//debugging
echo "<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectedColors = [];
    var dropdowns = document.querySelectorAll('.color-dropdown');
    dropdowns.forEach(function(dropdown, index) {
        selectedColors[index] = dropdown.value;
        dropdown.addEventListener('change', function() {
            selectedColors[index] = this.value;
            console.log(selectedColors);
        });
    });
});
</script>";
        
        
    
        
echo "<form method='get' action='printable_view.php'>";

echo "<h2>Coordinate Table</h2>";
echo "<table border='1' class='table' id='coordinateTable'>";
echo "<tr><td></td>";
for ($i = 0; $i < $rows_columns; $i++) {
    echo "<td style='width: 15px; height: 15px;'>" . chr(65 + $i) . "</td>"; 
}
echo "</tr>";
for ($i = 0; $i < $rows_columns; $i++) {
    echo "<tr>";
    echo "<td style='width: 15px; height: 15px;'>" . ($i + 1) . "</td>"; 
    for ($j = 0; $j < $rows_columns; $j++) {
        echo "<td style='width: 15px; height: 15px;'></td>"; 
    }
    echo "</tr>";
}
echo "</table>";
echo "<form method='post' action='printable_view.php'>";
echo "<input type='hidden' name='colors' value='$colors'>"; 
if (isset($_GET['rows_columns']) && isset($_GET['colors'])) {
    echo "<input type='hidden' name='rows_columns' value='" . htmlspecialchars($_GET['rows_columns']) . "'>";
    echo "<input type='hidden' name='colors' value='" . htmlspecialchars($_GET['colors']) . "'>";
    for ($i = 0; $i < $_GET['colors']; $i++) {
        $colorName = 'color' . $i;
        if (isset($_GET[$colorName])) { 
            echo "<input type='hidden' name='$colorName' value='" . htmlspecialchars($_GET[$colorName]) . "'>";
        }
    }
}
echo "<input type='submit' value='Print' class='button'>";

echo "<script>
    function hexToRgb(hex) {
        var result = /^#?([a-f\\d]{2})([a-f\\d]{2})([a-f\\d]{2})$/i.exec(hex);
        return result ? 'rgb(' + parseInt(result[1], 16) + ', ' + parseInt(result[2], 16) + ', ' + parseInt(result[3], 16) + ')' : null;
    }

    var table = document.getElementById('coordinateTable');
    var cells = table.getElementsByTagName('td');
    var colorCoordinates = [];
    var selectedColors = {};

    for (var i = 0; i < cells.length; i++) {
        cells[i].addEventListener('click', function() {
            var parentRow = this.parentNode;
            var rowIndex = Array.from(parentRow.parentNode.children).indexOf(parentRow);
            var cellIndex = Array.from(parentRow.children).indexOf(this);

            // Ignore cells in the first row and first column
            if (rowIndex === 0 || cellIndex === 0) {
                return;
            }

            var selectedColor = document.querySelector('input[name=\"selectedColor\"]:checked').value;
            var colorDropdown = document.querySelector('select[name=\"color' + selectedColor + '\"]');
            this.style.backgroundColor = colorDropdown.value;
            selectedColors[selectedColor] = hexToRgb(colorDropdown.value);

            var coordinate = String.fromCharCode(65 + this.cellIndex - 1) + this.parentNode.rowIndex;
        if (!colorCoordinates[selectedColor]) {
            colorCoordinates[selectedColor] = [];
        }

        // Remove the coordinate from its previous color
for (var color in colorCoordinates) {
    var index = colorCoordinates[color].indexOf(coordinate);
    if (index !== -1) {
        colorCoordinates[color].splice(index, 1);

        // Update the color row of the old color
        var oldColorRow = document.querySelector('.firsttable tr:nth-child(' + (parseInt(color) + 1) + ') td:last-child');
        oldColorRow.innerText = colorCoordinates[color].join(', ');
    }
}

// Always add the coordinate to the selected color
colorCoordinates[selectedColor].push(coordinate);
colorCoordinates[selectedColor] = Array.from(new Set(colorCoordinates[selectedColor])); // Remove duplicates
colorCoordinates[selectedColor].sort();

var colorRow = document.querySelector('.firsttable tr:nth-child(' + (parseInt(selectedColor) + 1) + ') td:last-child');
colorRow.innerText = colorCoordinates[selectedColor].join(', ');
    });
    }

    var dropdowns = document.querySelectorAll('.firsttable select');
    dropdowns.forEach(function(dropdown) {
    dropdown.addEventListener('change', function() {
        var colorName = dropdown.name.replace('color', '');
        var oldColor = selectedColors[colorName];
        var newColor = hexToRgb(dropdown.value);

        for (var i = 0; i < cells.length; i++) {
            if (cells[i].style.backgroundColor === oldColor) {
                cells[i].style.backgroundColor = newColor;
            }
        }

        selectedColors[colorName] = newColor;

        // Update colorCoordinates array and first table
        if (colorCoordinates[colorName]) {
            var newColorName = 'color' + dropdown.selectedIndex;
            colorCoordinates[newColorName] = colorCoordinates[colorName];
            delete colorCoordinates[colorName];

            var colorRow = document.querySelector('.firsttable tr:nth-child(' + (dropdown.selectedIndex + 1) + ') td:last-child');
            colorRow.innerText = colorCoordinates[newColorName].join(', ');
        }
    });
});
</script>";
            echo "</form>";
        
        
        ?>
        <script>
        var selectedColors = [];
    
        function saveColor(color, index) {
            selectedColors[index] = color;
        }
        </script>

            <script>
const dropdowns = document.querySelectorAll('.color-dropdown');

dropdowns.forEach(dropdown => {
    let previousColor = dropdown.value;

    dropdown.addEventListener('change', event => {
        const selectedColor = event.target.value;

        dropdowns.forEach(otherDropdown => {
            if (otherDropdown !== dropdown && otherDropdown.value === selectedColor) {
        let messageNode = document.createTextNode("Duplicate color selection! Reverting to previous value.");
        let messageElement = document.getElementById("message");

        messageElement.appendChild(messageNode);

        dropdown.value = previousColor;
            }
        });

        previousColor = selectedColor; 
    });
});
</script>

<script>
// Use JavaScript to change the color of the table cells when clicked
document.querySelectorAll('.table.firsttable td').forEach(function(td) {
    td.addEventListener('click', function() {
        var colorHex = document.querySelector('input[name="selectedColor"]:checked').value;
        this.style.backgroundColor = colorHex;
    });
});
</script>


    </div>

    <!-- Leave this div empty it is for the waves above the footer -->
    <div class="footerImg"></div>
    </body>

    <footer>
    <p>
        Website created by CS312 Group 24. Logo from Marine Vectors Logo by Vecteezy. Waves from istockphoto.
    </p>
    </footer>

</html>
