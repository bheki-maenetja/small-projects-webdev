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
            $cyclist_total_age = 0;
            while ($cycle_row = mysqli_fetch_array($cycle_results)) {
                $cyclist_age = (int) getAge($cycle_row['dob']);
                $cyclist_total_age += $cyclist_age;
                $cycle_row['age'] = $cyclist_age;
                array_push($cycle_array, $cycle_row);
            }
            $row['cyclists'] = $cycle_array;
            if (count($cycle_array) != 0) {
                $row['avg_cyclist_age'] = $cyclist_total_age / count($cycle_array);
            } else {
                $row['avg_cyclist_age'] = 0;
            }
            array_push($countryArray, $row);
        }
        echo json_encode($countryArray);
    } else {
        echo "<h3>No results matching your search 😬</h3>";
    }

    function getAge($dateString) {
        $dateObj = date_create($dateString);
        $currentDate = date_create(date('Y-m-d'));
        $dateDiff = date_diff($dateObj, $currentDate);
        return $dateDiff->format("%y");
    }
?>