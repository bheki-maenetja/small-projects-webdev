<?php 
    $username = "coa123cycle";
    $password = "bgt87awx";
    $dbname = "coa123cdb";
    $servername = "localhost";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $db_query = "SELECT * from Country";

    $search_result = mysqli_query($conn, $db_query);
    $countryArray = array();

    if (mysqli_num_rows($search_result) > 0) {
        while ($row = mysqli_fetch_array($search_result)) {
            $iso_id = $row['ISO_id'];
            $cycle_query = "SELECT * from Cyclist where ISO_id='$iso_id'";
            $cycle_results = mysqli_query($conn, $cycle_query);
            $cycle_array = array();
            while ($cycle_row = mysqli_fetch_array($cycle_results)) {
                array_push($cycle_array, $cycle_row);
            }
            $row['cyclists'] = $cycle_array;
            array_push($countryArray, $row);
        }
        echo json_encode($countryArray);
    } else {
        echo "<h3>No results matching your search 😬</h3>";
    }

?>