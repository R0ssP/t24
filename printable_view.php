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
    </style>
</head>

<body>
    <div class="container">
        <img src="images/logo_grayscale.png" alt="Company Logo" class="logo">
        <h1><center>Tridentech Dynamics</center></h1>
        <h2>Color Coordinate Generation</h2>

        <?php
session_start();

// Check if colors are set in POST
if (isset($_POST['colors'])) {
    $num_colors = $_POST['colors'];

    // Display a table with the selected colors
    echo "<table border='1'>";

    for ($i = 0; $i < $num_colors; $i++) {
        $colorKey = 'color' . $i;
        if (isset($_POST[$colorKey])) {
            $selected_color = $_POST[$colorKey];
            echo "<tr><td width='20%'>$selected_color "  . "</td><td width='80%'></td></tr>";
        }
    }
    echo "</table>";
} else {
    echo "No colors selected.";
}
    ?>
        </table>

        <h3>Coordinate Table</h3>
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
