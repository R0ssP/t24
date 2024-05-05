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
            <input type="number" id="num_of_colors" name="num_of_colors" class="button" placeholder="Enter a number">
            <br>
            <input type="submit" value="Generate" class="button">
        </form>
        <div>
            <?php 
                function validateInput($value, $min, $max, $name) {
                    if (!is_numeric($value) || $value < $min || $value > $max) {
                        echo "Error: $name must be a number between $min and $max.<br>";
                        return false;
                    }
                    return true;
                }

                $valid = true;
                $rows_columns = isset($_GET['rows_columns']) ? $_GET['rows_columns'] : null;
                $num_of_colors = isset($_GET['num_of_colors']) ? $_GET['num_of_colors'] : null;

                $valid = validateInput($rows_columns, 1, 26, "Rows & Columns") && $valid;
                $valid = validateInput($num_of_colors, 1, 10, "Number of colors") && $valid;

                if (!$valid) {
                    exit;
                }

                echo "<p id=\"clickedButton\"></p>";
            ?>
        </div>
        <div id="message"></div>
        <?php
$servername = "faure";
$username = "rossp";
$password = "833018712";
$database = "rossp";


    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_fetch_colors = "SELECT name FROM colors";

    $result = $conn->query($sql_fetch_colors);

    if ($result->num_rows > 0) {
        $color_options = [];
        while ($row = $result->fetch_assoc()) {
            $color_options[] = $row["name"];
        }

        echo "<form method='post' action='printable_view.php'>";
        echo "<input type='hidden' name='colors' value='" . count($color_options) . "'>";

        echo "<table border='1' class='table firsttable'>";
        for ($i = 0; $i < $num_of_colors; $i++) {
            echo "<tr>";
            echo "<td width='20%'><select class='option color-dropdown' name='color$i'>"; //color selector
            for ($j = 0; $j < count($color_options); $j++) {
                $option = $color_options[$j];
                if($j === $i ){
                    echo "<option value='$option' selected>$option</option>";
                }else {
                    echo "<option value='$option'>$option</option>";
                }
            }
            echo "</select>";
            echo "<input type='radio' name='current_color' value='color$i'";
            if ($i === 0) {
                echo " checked";
            }
            echo ">";
            echo "</td>";

            echo "<td width='80%'><div><p id='dropdown$i'></p></div></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";

        echo "<div class='selectedButton'></div>";
    } else {
        echo "No colors found in the database";
    }


        echo "<form method='get' action='printable_view.php'>";
        echo "<h2>Coordinate Table</h2>";
        echo "<table border='1' class='table'>";
        echo "<tr><td></td>";
        for ($i = 0; $i < $rows_columns; $i++) {
            echo "<td style='width: 20px; height: 20px;'>" . chr(65 + $i) . "</td>"; //Color table
        }
        echo "</tr>";
        for ($i = 0; $i < $rows_columns; $i++) {
            echo "<tr>";
            echo "<td style='width: 20px; height: 20px;'>" . ($i + 1) . "</td>"; 
            for ($j = 0; $j < $rows_columns; $j++) {
                $colLetter = chr(65 + $j);
                $col = $j;
                $row = $i;
                
                echo "<td style='width: 20px; height: 20px;'>
                <form method=\"post\">
                    <input type=\"submit\" class=\"button table2button\"  data-row= \"$row\" data-col=\"$col\" value=\"\">
                </td>"; 
            }
            echo "</tr>";
        }
        echo "</table>";
        echo "</form>";

        echo "<form method='post' action='printable_view.php'>";
        echo "<input type='hidden' name='colors' value='$num_of_colors'>"; 
        
        if (isset($_GET['rows_columns']) && isset($_GET['num_of_colors'])) {
            echo "<input type='hidden' name='rows_columns' value='" . htmlspecialchars($_GET['rows_columns']) . "'>";
            echo "<input type='hidden' name='colors' value='" . htmlspecialchars($_GET['num_of_colors']) . "'>";
        }
        for ($i = 0; $i < $_GET['num_of_colors']; $i++) {
            $colorName = 'color' . $i;
            if (isset($_GET[$colorName])) { 
                echo "<input type='hidden' name='$colorName' value='" . htmlspecialchars($_GET[$colorName]) . "'>";
            }
        }
        echo "<input type='submit' value='Print' class='button'>";
        echo "<input type='hidden' name='dropdownValues' id='dropdownValuesInput'>";
        echo "</form>";
    ?>
    </div>
    <!-- Leave this div empty it is for the waves above the footer -->
    <div class="footerImg"></div>
    <footer>
        <p>
            Website created by CS312 Group 24. Logo from Marine Vectors Logo by Vecteezy. Waves from istockphoto.
        </p>
    </footer>
</body>





<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedColor = '---'; 
    let selectedDropdown = 0;    
    let dropdownValuesString = "";
    const dropdowns = document.querySelectorAll('.color-dropdown');

    //initialize default array of values, to be updated once we fix the actual defaults to not be red for every one
    let dropdownValuesArray = Array.from({length: dropdowns.length }, () => '---');
    for (let i = 0; i < dropdownValuesArray.length; i++){
        addToDropdownArray(i, dropdownValuesArray[i]);
    }

    dropdowns.forEach((dropdown, index) => {
        let previousColor = dropdown.value;
        addToDropdownArray(index, previousColor);
        dropdown.addEventListener('change', event => {
            selectedColor = event.target.value;
            let validColor = true;

            //check if duplicate
            for (let i = 0; i < dropdownValuesArray.length; i++){
                if (dropdownValuesArray[i] === selectedColor){
                    let messageNode = document.createTextNode("Duplicate color selection! Reverting to previous value.");
                    let messageElement = document.getElementById("message");
                    messageElement.appendChild(messageNode);
                    dropdown.value = previousColor;
                    validColor = false;
                } 
            };

            if(validColor){
                addToDropdownArray(index, selectedColor);
            } 
            console.log(dropdownValuesArray);

        });
    });

    const radioButtons = document.querySelectorAll('input[name="current_color"]');
    radioButtons.forEach((radio, index) => {
        radio.addEventListener('change', () => {
            selectedColor = dropdowns[index].value;
        });
    });

    let clickedCellsArray = Array.from({length: dropdowns.length }, () => []);

    let table2Buttons = document.querySelectorAll('.table2button');
    table2Buttons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            let row = parseInt(this.dataset.row) + 1;
            let col = parseInt(this.dataset.col);
            col += 65;
            colToLetter = String.fromCharCode(col);
            let clickedCoord = colToLetter + row;

            document.getElementById('clickedButton').innerText = "Clicked Button: " + clickedCoord;

            if (selectedColor !== '---') {
                let currentClasses = button.getAttribute("class");
                let classesList = currentClasses.split(" ");
                classesList[2] = selectedColor;
                let updatedClasses = classesList.join(" ");
                
                button.setAttribute("class", updatedClasses);

                selectedDropdown = Array.from(dropdowns).findIndex(dropdown => dropdown.value === selectedColor);

                clickedCellsArray = searchAndRemove(clickedCellsArray, clickedCoord);
                clickedCellsArray[selectedDropdown].push(clickedCoord);

                populateTable(clickedCellsArray);
            }
        })
    });

    function addToDropdownArray(index, selectedColor) {
        dropdownValuesArray[index] = selectedColor;
        dropdownValuesString = dropdownValuesArray.join(',');
        document.getElementById('dropdownValuesInput').value = dropdownValuesString;
    }

    function populateTable(outerArray) {
        for (let i=0; i < outerArray.length; i++) {
            let updateString = "dropdown" + i;
            let updateElement = document.getElementById(updateString);
            let stringUpdate = createString(clickedCellsArray[i]);
            updateElement.innerHTML = stringUpdate;
        }
    }

    function createString(innerArray) {
        let returnString = "";
        for (let i=0; i< innerArray.length; i++) {
            if (i === innerArray.length - 1) {
                returnString += innerArray[i];
            } else {
                returnString += innerArray[i];
                returnString += ", ";
            }
        }
        return returnString;
    }

    function searchAndRemove(outerArray, value) {
        for (let i = 0; i < outerArray.length; i++) {
            const innerArray = outerArray[i];
            const columnIndex = innerArray.indexOf(value);
            if (columnIndex !== -1) {
                innerArray.splice(columnIndex, 1);
                return outerArray;
            }
        }
        return outerArray;
    }
});
</script>
</html>