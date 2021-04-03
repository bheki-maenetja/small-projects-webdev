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
    $username = "coa123cycle";
    $password = "bgt87awx";
    $dbname = "coa123cdb";
    $servername = "localhost";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $firstDate = $_REQUEST['date_1'];
    $secondDate = $_REQUEST['date_2'];
    echo "<h2>" . $firstDate . "</h2>";
    echo "<h2>" . $secondDate . "</h2>";

    function validateDate($inputDate) {
        $dateFormat = date_create_from_format('d/m/Y', $inputDate);
        return $dateFormat && $dateFormat->format('d/m/Y') == $inputDate;
    }

    function reformatDate($date) {
        $dateObj = date_create_from_format('d/m/Y', $date);
        return date_format($dateObj, 'Y-m-d');
    }

    function getResults() {
        global $firstDate, $secondDate, $conn;
        $db_query = "SELECT name, country_name, gdp, population from Country join Cyclist on Country.ISO_id = Cyclist.ISO_id where dob BETWEEN '$firstDate' AND '$secondDate'";
        $search_result = mysqli_query($conn, $db_query);

        if (mysqli_num_rows($search_result) > 0) {
            while ($row = mysqli_fetch_array($search_result)) {
                echo $row['name'] . " " . $row['country_name'] . "<br>";
            }
        }
    }

    if (validateDate($firstDate) && validateDate($secondDate)) {
        echo "<h2>All Good</h2>";
        $firstDate = reformatDate($firstDate);
        $secondDate = reformatDate($secondDate);
        echo "<h3>" . $firstDate . "</h3>";
        echo "<h3>" . $secondDate . "</h3>";
        getResults();
    } else {
        echo "<h2>We have a problem</h2>";
    }
?>
</body>
</html>