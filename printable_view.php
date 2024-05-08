<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .logo {
            display: block;
            height: 25%;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        @media print {
            body {
                width: 8.5in;
                height: 11in;
                margin: 0 auto;
            }
        }
        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="images/logo_grayscale.png" alt="Company Logo" class="logo">
        <h1>Tridentech Dynamics</h1>


        <h2>Color Coordinate Generation</h2>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var usedColors = JSON.parse(sessionStorage.getItem('usedColors')) || [];
    console.log("Colors: " + usedColors);

    // Create a table from the usedColors array
    var table = document.createElement('table');
    table.border = '1';
    table.style.width = '75%'; // Make the table take up the full width of its container
    table.style.margin = '0 auto'; // Center the table horizontally

    usedColors.forEach(function(color) {
        // Make an AJAX call to fetch color details
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_color.php?color=' + encodeURIComponent(color), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var result = JSON.parse(xhr.responseText);
                if (result && result.name && result.hex_value) {
                    var row = document.createElement('tr');
                    var cell1 = document.createElement('td');
                    cell1.textContent = result.name + " - " + result.hex_value;
                    cell1.style.width = '1%'; // Make the first column only as wide as the text
                    cell1.style.whiteSpace = 'nowrap'; // Prevent the text from wrapping to the next line
                    row.appendChild(cell1);

                    // Create a second empty cell and append it to the row
                    var cell2 = document.createElement('td');
                    row.appendChild(cell2);

                    table.appendChild(row);
                }
            }
        };
        xhr.send();
    });

    // Select the h2 element
    var h2 = document.querySelector('h2');

    // Insert the table before the h2 element
    h2.parentNode.insertBefore(table, h2);
});
</script>

        <?php      
            // Check if colors are set in POST
            if (isset($_GET['dropdownValues']) && isset($_GET['clickedCells'])) {
                echo("<p>hello world</p>");
                $dropdownValuesString = $_POST['dropdownValues'];
                $dropdownValues = explode(',', $dropdownValuesString);

                $clickedCellsString = $_POST['clickedCells'];
                $allClickedCells = explode('|', $clickedCellsString);
                
                echo "<h3>Colors:</h3>";
                // Display a table with the selected colors
                echo "<table border='1'>";

                for ($i = 0; $i < count($dropdownValues); $i++){
                    echo "<tr><td width='20%'>" . $dropdownValues[$i] . "</td><td width='80%'>" . $allClickedCells[$i] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "No colors selected.";
            }
        ?>

        <table>
            <tr>
                <th></th>
                <?php
                for ($i = 0; $i < $_POST['rows_columns']; $i++) {
                    echo "<th>" . chr(65 + $i) . "</th>";
                }
                ?>
            </tr>
            <?php
            for ($i = 0; $i < $_POST['rows_columns']; $i++) {
                echo "<tr>";
                echo "<td>" . ($i + 1) . "</td>";
                for ($j = 0; $j < $_POST['rows_columns']; $j++) {
                    echo "<td></td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>