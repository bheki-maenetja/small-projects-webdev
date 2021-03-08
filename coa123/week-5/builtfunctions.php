<?php
$message = "PHP can be embedded into HTML.";
$num = 5;
?>
<!DOCTYPE html>
<html>
<head>
<title>
Built-in Functions
</title>
</head>

<body>
<!-- Task 1: Use php function date() to get the date and display the date using echo. -->
<h2>Today date is: <?php echo date("Y-m-d")  ?></h2>
<p>
<!-- Task 2: If the length of $messgae is greater than 20, display the value of $message in uppercase letters using echo  -->
<?php
if (strlen($message) > 20) {
    echo strtoupper($message);
}
?>
</p>

<!-- Task3: use rand() function to display a random number in the paragraph below -->
<p> Here is a random number between 1 and 10: <?php  echo rand(1, 10) ?> </p>

<!-- Task4: Define a PHP function (named it "fact") which gets an argument. If this argumnet is integer (use a prebuilt method to check this) and equal or greater than 0, the function return the factorial of that integer, otherwise, it returns: "The given data is not valid!". Name this function fact-->
<?php  
function fact($num) {
    if (is_integer($num) && $num > 0) {
        return getFact($num);
    } else {
        return "The given data is not valid!";
    }
}

function getFact($num) {
    if ($num == 1) {
        return 1;
    } else {
        return $num * getFact($num - 1);
    }
}

?>

<!-- Task5: Call fact function by passing $num to it and diplay its result in the paragraph below: -->

<p> 
<?php echo "The factorial of 5 is "; echo fact($num);  ?>
</p>

</body>
</html>
