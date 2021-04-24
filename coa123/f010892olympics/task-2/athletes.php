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

    .main-heading {
        background-color: #e3120b;
        color: #fafafa;
        padding: 20px;
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

    $conn = mysqli_connect($servername, $username, $password, $dbname); // connection to the database
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $ISO_id = $_REQUEST['country_id']; // ISO ID input value from athletes.html
    $part_name = $_REQUEST['part_name']; // part input value from athletes.html

    function generateTable() {
        /* 
        PARAMETERS
            * None
        RETURN VALUES
            * None
        WHAT DOES THIS FUNCTION DO?
            * generates a table representing the search results of a given database query
        */
        global $search_result;
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>";
        echo "<th class='main-heading' colspan='4'>Olympic Athletes</th>";
        echo "</tr>";
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

    function generateQuery() {
        /* 
        PARAMETERS
            * None
        RETURN VALUES
            * a string representing a query to the database
        WHAT DOES THIS FUNCTION DO?
            * creates a database query according to the given input values
        */
        global $ISO_id, $part_name;
        $base_query = "SELECT name, gender, ROUND(weight / POWER(height/100,2), 3) as BMI from Cyclist";
        if (trim($ISO_id) == "" && trim($part_name) == "") {
            return $base_query;
        } else if (trim($ISO_id) == "") {
            return $base_query . " WHERE name LIKE '%$part_name%'";
        } else if (trim($part_name) == "") {
            return $base_query . " WHERE ISO_id='$ISO_id'";
        } else {
            return $base_query . " WHERE name LIKE '%$part_name%' and ISO_id='$ISO_id'";
        }
    }

    $db_query = generateQuery();
    $search_result = mysqli_query($conn, $db_query);

    if (mysqli_num_rows($search_result) > 0){
        generateTable();
    } else {
        echo "<h2>No results matching your search -- Sorry 😬</h2>";
    }

    mysqli_close($conn);
?>
</body>
</html>