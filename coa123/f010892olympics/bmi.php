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
    $minWeight = $_REQUEST['min_weight'];
    $maxWeight = $_REQUEST['max_weight'];
    $minHeight = $_REQUEST['min_height'];
    $maxHeight = $_REQUEST['max_height'];
    echo '<h1>THIS IS WEB DEVELOPMENT</h1>';
    echo 'Min & Max Weights: ' . $minWeight . " " . $maxWeight;
    echo 'Min & Max Heights: ' . $minHeight . " " . $maxHeight;

    echo "<table>";
    for ($w=$minWeight-5; $w<=$maxWeight; $w=$w+5) {
        echo '<tr>';
        for ($h=$minHeight-5; $h<=$maxHeight; $h=$h+5) {
            if ($w < $minWeight && $h < $minHeight) {
                echo '<td>' . 'Column 0 - \nRow 0' . '</td>';
            } else if ($w < $minWeight) {
                echo '<td>' . $h . '</td>';
            } else if ($h < $minHeight) {
                echo '<td>' . $w . '</td>';
            } else {
                echo '<td>' . $w . " + " . $h . '</td>';
            }
        }
        echo '</tr>';
    }
    echo "</table>";

?>
</body>
</html>