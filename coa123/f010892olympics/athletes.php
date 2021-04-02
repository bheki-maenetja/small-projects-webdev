<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athletes Task</title>
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

    .column-heading {
        position: sticky;
        background-color: #4a4a4a;
        color: white;
        top: 0;
    }

    td {
        background-color: #acc8d4;
    }

    table {
        max-height: 100%;
    }
</style>
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
        generateTable();
    }
    
    function generateTable() {
        global $search_result;
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        echo "<th class='column-heading'>Name</th>";
        echo "<th class='column-heading'>Gender</th>";
        echo "<th class='column-heading'>BMI</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($search_result)){
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>"; 
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['BMI'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    mysqli_close($conn);
?>
</body>
</html>