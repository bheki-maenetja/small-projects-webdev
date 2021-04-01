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
    }

    body {
        width: 100vw;
        height: 100vh;
        background-color: dodgerblue;
    }

    .table-container {
        max-width: 80%;
        max-height: 90%;
        padding: 50px;
        margin: auto auto;
        overflow: scroll;
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        background-color: deepskyblue;
    }

    table, th, td {
        border: 1px solid blue;
        border-collapse: collapse;
    }

    table {
        width: 80%;
        min-height: 40%;
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
                echo '<h2>Error - One or more of your values is invalid</h2>';
                return FALSE;
            } else if ((int) $value < 0) {
                echo '<h2>Error - One or more of your values is less than zero</h2>';
                return FALSE;
            }
            $values[$key] = (int) $value;
        }

        if ($values['maxWeight'] < $values['minWeight']) {
            echo '<h2>Error - The maximum weight is less than the minimum weight</h2>';
            if ($values['maxHeight'] < $values['minHeight']) {
                echo '<h2>Error - The maximum height is less than the minimum height</h2>';
            }
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
                    echo '<td>'; 
                    echo 'Height (cm) →';
                    echo '<br>';
                    echo 'Weight (kg) ↓'; 
                    echo '</td>';
                } else if ($w < $minWeight) {
                    echo '<td>' . $h . '</td>';
                } else if ($h < $minHeight) {
                    echo '<td>' . $w . '</td>';
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