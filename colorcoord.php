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

$color_options = ['red', 'orange', 'yellow', 'green', 'blue', 'purple', 'grey', 'brown', 'black', 'teal'];

echo "<form method='post' action='printable_view.php'>";
echo "<input type='hidden' name='colors' value='$colors'>"; 

echo "<table border='1' class='table firsttable'>";
for ($i = 0; $i < $colors; $i++) {
    echo "<tr>";
    echo "<td width='10%'><input type='radio' name='selectedColor' value='$i'" . ($i == 0 ? " checked" : "") . "></td>";
    echo "<td width='10%'><select class='option color-dropdown' name='color$i'>";
    foreach ($color_options as $index => $option) {
        $selected = $i === $index ? 'selected' : '';
        echo "<option value='$option' $selected>$option</option>";
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
        dropdown.addEventListener('change', function() {
            var oldColor = selectedColors[index];
            var newColor = this.value;
            selectedColors[index] = newColor;

            // Select all cells in the coordinate table with the old color
            var cells = document.querySelectorAll('#coordinateTable td');
            cells.forEach(function(cell) {
                if (cell.style.backgroundColor === oldColor) {
                    // Change their color to the new one
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
    var table = document.getElementById('coordinateTable');
    var cells = table.getElementsByTagName('td');
    var colorCoordinates = [];
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
            var coordinate = String.fromCharCode(65 + this.cellIndex - 1) + this.parentNode.rowIndex;
            if (!colorCoordinates[selectedColor]) {
                colorCoordinates[selectedColor] = [];
            }
            colorCoordinates[selectedColor].push(coordinate);
            colorCoordinates[selectedColor].sort();
            var colorRow = document.querySelector('.firsttable tr:nth-child(' + (parseInt(selectedColor) + 1) + ') td:last-child');
            colorRow.innerText = colorCoordinates[selectedColor].join(', ');
        });
    }
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
