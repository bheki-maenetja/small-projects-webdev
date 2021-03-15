<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
body {font-family: Arial, Helvetica, sans-serif;}



input[type=text], input[type=email], input[type=number], select{

  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 6px;
  margin-bottom: 16px;
}


input[type=submit] {
  background-color: #1943DD;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

input[type=submit]:hover {
  background-color: #0A1B5D;
  color:#E0BF1B;
  
}

.main {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  display: inline-block;
  border: black 1px solid;
}


</style>
<script>
function validateEmails(e) {
	/* Task 3: Check if the value of email and confirm email inputs are the same. If they are not, the form cannot be submitted. */
	ogEmail = document.querySelector('#email')
	cEmail = document.querySelector('#cemail')

    return ogEmail.value === cEmail.value
	 
}
</script>
</head>
<body>
    <?php 
        $registeredEmails = array("h.nevisi@lboro.ac.uk","test@test.com","hello@test.com");
        if (isset($_REQUEST['submit'])) {
            $firstName = $_REQUEST['firstname'];
            $lastName = $_REQUEST['lastname'];
            $backgroundColor = $_REQUEST['backgroundcolor'];
            $tableSize = $_REQUEST['tablesize'];
            $email = $_REQUEST['email'];

            echo 'Hello ' . $firstName;
            echo '<br>';
            if (in_array($email, $registeredEmails)) {
                echo 'Welcome back!';
            } 

            echo "<table style='background-color: {$backgroundColor}'>";
            for($i=1;$i<=$tableSize;$i=$i+1){
                echo '<tr>';
                for($j=1; $j <= $tableSize; $j++) {
                    echo '<td>'.$i*$j.'</td>';
                }
                echo '</tr>';
            }
            echo "</table>";
        }
    ?>
<div class="main">
<form action="" onsubmit="return validateEmails()" method="get">
    <label for="firstname">First name:</label><br>
    <input type="text" id="firstname" name="firstname" required><br>
    <br>
    <label for="lastname">Last name:</label><br>
    <input type="text" id="lastname" name="lastname"><br>
    <label for="color">Choose Color</label><br>
        <select id="color" name="backgroundcolor">
        <option value="#FF0000">Red Background</option>
        <option value="#FFFF00">Yellow Background</option>
        <option value="#FFFFFF">White Background</option>
        </select><br>	
    <label for="tablesize">Size of table to be generated (between 2 and 6)</label><br>
    <input type="number" id="tablesize" name="tablesize" min="2" max="6" />
    <br>  
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email"><br>
    <label for="cemail">Confirm Email:</label><br>
    <input type="email" id="cemail" name="confirmemail"><br>
    <br><br>
    <input type="submit" name="submit" value="submit">
</form> 
</div>
</body>
</html>