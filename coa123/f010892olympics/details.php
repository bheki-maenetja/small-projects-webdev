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
        $db_query = "SELECT name, dob, country_name, gdp, population from Country join Cyclist on Country.ISO_id = Cyclist.ISO_id where dob BETWEEN '$firstDate' AND '$secondDate'";
        $search_result = mysqli_query($conn, $db_query);
        $dataArray = array();

        if (mysqli_num_rows($search_result) > 0) {
            while ($row = mysqli_fetch_array($search_result)) {
                array_push($dataArray, $row);
            }
            echo json_encode($dataArray);
        } else {
            echo "<h3>No results matching your search 😬</h3>";
        }
    }

    if (validateDate($firstDate) && validateDate($secondDate)) {
        if ($firstDate > $secondDate) {
            echo "<h3>Error - The first date is later than the second date</h3>";
        } else {
            $firstDate = reformatDate($firstDate);
            $secondDate = reformatDate($secondDate);
            getResults();
        }
    } else {
        echo "<h3>Error - one or more dates are invalid</h3>";
    }

    mysqli_close($conn);
?>
</body>
</html>