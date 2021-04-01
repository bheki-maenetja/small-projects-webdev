<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table, th, td {
        border: 1px solid blue;
        border-collapse: collapse;
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
    echo '<h1>THIS IS WEB DEVELOPMENT!!!</h1>';
    echo 'Min & Max Weights: ' . $values['minWeight'] . " " . $values['maxWeight'];
    echo 'Min & Max Heights: ' . $values['minHeight'] . " " . $values['maxHeight'];
    
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
        echo "<table>";
        for ($w=$minWeight-5; $w<=$maxWeight; $w=$w+5) {
            echo '<tr>';
            for ($h=$minHeight-5; $h<=$maxHeight; $h=$h+5) {
                if ($w < $minWeight && $h < $minHeight) {
                    echo '<td>'; 
                    echo 'Column 0 -';
                    echo '<br>';
                    echo '\nRow 0'; 
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