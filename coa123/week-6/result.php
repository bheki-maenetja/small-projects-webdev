<!DOCTYPE html>
<html lang ="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width"/>

<title>Form Processing</title> 
</head>

<body>


<?php
$registeredEmails = array("h.nevisi@lboro.ac.uk","test@test.com","hello@test.com");
//Task1. get firsname, lastname, backgroundcolor, tablesize, email values from the query string and store them in $firsName, $lastName, $backgroundColor, $tableSize and $email





//Task2. greeting to the person using echo, and let them know whether their email address is in our registered email list $registeredEmails (you can use built-in function)





//Task3. Change the background of the table below to the background value that the user has submitted
echo "<table>";
for($i=1;$i<=$tableSize;$i=$i+1){
	echo '<tr>';
	for($j=1; $j <= $tableSize; $j++) {
		echo '<td>'.$i*$j.'</td>';
	}
	echo '</tr>';
}
echo "</table>";
?>

</body>
</html>