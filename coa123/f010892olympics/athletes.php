<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletes Task</title>
</head>
<body>
<?php 
    $username = "coa123cycle";
    $password = "bgt87awx";
    $dbname = "coa123cdb";
    $servername = "localhost";

    $ISO_id = $_REQUEST['country_id'];
    $part_name = $_REQUEST['part_name'];

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $db_query = "SELECT name, gender, weight / POWER(height/100,2) as BMI from Cyclist WHERE name LIKE '%$part_name%' and ISO_id='$ISO_id'";

    $search_result = mysqli_query($conn, $db_query);

    if (mysqli_num_rows($search_result) > 0){
        while ($row = mysqli_fetch_array($search_result)){
            echo $row["name"] . " " . $row["gender"] . " " . $row["BMI"] . "<br>";
        }
    }
    mysqli_close($conn);
?>
</body>
</html>