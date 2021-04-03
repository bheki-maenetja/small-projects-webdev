<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details Task</title>
</head>
<body>
<?php 
    $firstDate = $_REQUEST['date_1'];
    $secondDate = $_REQUEST['date_2'];
    echo "<h2>" . $firstDate . "</h2>";
    echo "<h2>" . $secondDate . "</h2>";

    function checkDates($inputDate) {
        $dateFormat = date_create_from_format('d/m/Y', $inputDate);
        return $dateFormat && $dateFormat->format('d/m/Y') == $inputDate;
    }

    if (checkDates($firstDate) && checkDates($secondDate)) {
        echo "<h2>All Good</h2>";
    } else {
        echo "<h2>We have a problem</h2>";
    }
?>
</body>
</html>