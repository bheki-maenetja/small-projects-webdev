<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access MySQL</title>
  <style>
	body{background-color:#E1E4E7;font-size:0.8em;text-align:center;}
	#jsonDiv{text-align:left;}
  </style>
</head>
<body>
<div> 
  <h3>Access MySQL Database with MySQLi</h3>
  <hr>
</div>
	

<?php
include "coa123-mysql-connect.php"; 

//Task1. Define $servername and $dbName (coa123wdb) below or in the above inclided file. 
 
 

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$table_country="venue";

//Task2. Search venues with capacity more than 280 and sort the result-set by "name", and save the result-set in $result
$venue_search = "SELECT * FROM venue WHERE capacity > 280";
$result_set = mysqli_query($conn, $venue_search);



//Task3.echo the SQL search string and total number of search results
echo $venue_search . "<br>";
echo $result_set->num_rows . "<br>";




//Task4. Display venue_id, name, capacity anf weekday_price of each venues in the result-set using mysqli_fetch_array 
if (mysqli_num_rows($result_set) > 0){
    while ($row = mysqli_fetch_array($result_set)){
        echo $row["venue_id"] . " " . $row["name"] . " " . $row["capacity"] . " " . $row["weekday_price"] . "<br>";
    }
}





/////end of Task4/////
echo "<hr>";
echo "<div id='jsonDiv'>" ; 
//Task5. display all query results in JSON style using json_encode  
$allDataArray = array();
$new_results = mysqli_query($conn, $venue_search);
if (mysqli_num_rows($new_results) > 0) {
    while ($row = mysqli_fetch_array($new_results, MYSQLI_ASSOC)) {
        array_push($allDataArray, $row);
    }
}
echo json_encode($allDataArray);






mysqli_close($conn);
/////end of Task5/////	
echo "</div>";  
?>
</body>
</html>