<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        font-family: helvetica;
    }

    body {
        width: 100vw;
        height: 100vh;
        background-color: #d4dddd;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .table-container {
        max-width: 80%;
        max-height: 90%;
        margin: 100px auto;
        overflow: scroll;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        box-shadow: 0 0 20px 5px black;
    }

    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    td, th {
        padding: 10px;
        text-align: center;
    }

    .row-heading {
        position: sticky;
        background-color: #d4dddd;
        color: #4a4a4a;
        left: 0;
    }
    .column-heading {
        position: sticky;
        background-color: #4a4a4a;
        color: white;
        top: 0;
    }

    .column-heading:first-child {
        background-color: #e3120b;
        color: #fafafa;
        padding: 20px;
    }

    td {
        background-color: #acc8d4;
    }


    table {
        height: 100%;
    }
</style>
<body>
<?php
    $values = array(
        "minWeight"=>$_REQUEST['min_weight'], 
        "maxWeight"=>$_REQUEST['max_weight'], 
        "minHeight"=>$_REQUEST['min_height'], 
        "maxHeight"=>$_REQUEST['max_height']
    );
    
    $inputsValid = validateInputs();
    function validateInputs() {
        global $values;

        foreach ($values as $key => $value) {
            if (!is_numeric(trim($value))) {
                echo '<h2>Error - One or more of your input values is invalid</h2>';
                return FALSE;
            } else if ((int) $value < 0) {
                echo '<h2>Error - One or more of your input values is less than zero</h2>';
                return FALSE;
            }
            $values[$key] = (int) $value;
        }

        if ($values['maxWeight'] < $values['minWeight']) {
            echo '<h2>Error - The maximum weight is less than the minimum weight</h2>';
            return FALSE;
        }
        if ($values['maxHeight'] < $values['minHeight']) {
            echo '<h2>Error - The maximum height is less than the minimum height</h2>';
            return FALSE;
        }
        return TRUE;
    }

    if ($inputsValid) {
        generateTable($values['minWeight'], $values['maxWeight'], $values['minHeight'], $values['maxHeight']);
    }

    function generateTable($minWeight, $maxWeight, $minHeight, $maxHeight) {
        echo "<div class='table-container'>";
        echo "<table>";
        for ($w=$minWeight-5; $w<=$maxWeight; $w=$w+5) {
            echo '<tr>';
            for ($h=$minHeight-5; $h<=$maxHeight; $h=$h+5) {
                if ($w < $minWeight && $h < $minHeight) {
                    echo "<th class='column-heading'>"; 
                    echo 'Height (cm) →';
                    echo '<br>';
                    echo 'Weight (kg) ↓'; 
                    echo "</th>";
                } else if ($w < $minWeight) {
                    echo "<th class='column-heading'>" . $h . "</th>";
                } else if ($h < $minHeight) {
                    echo "<th class='row-heading'>" . $w . "</th>";
                } else {
                    echo '<td>' . getBmi($w, $h) . '</td>';
                }
            }
            echo '</tr>';
        }
        echo "</table>";
        echo "</div>";
    }

    function getBmi($weight, $height) {
        if ($height == 0) {
            return 'N/a';
        }
        $bmi = (float) ($weight / pow($height / 100, 2));
        return round($bmi, 3);
    }

?>
</body>
</html>