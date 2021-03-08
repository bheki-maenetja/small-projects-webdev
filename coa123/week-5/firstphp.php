<?php
$color = "darkblue";
$module = "Web Programming - COA123";
$link = "https://www.lboro.ac.uk";
$studentList = array("B12345"=>"Emma", "B22334"=>"Tom", "B55667"=>"Hannah");
?>
<!DOCTYPE html>
<html>
<head>
<title>
First PHP Script
</title>
<style>
body{
   /* Task 3: Using PHP, set the text color to $color */ 
}
</style>

</head>
<body>

<h2>Module name: <!-- Task 1: Using PHP, output the value of $module here --> <?php     ?></h2>
<p>This module is delivered in <a>Loughborough University</a><!-- Task 2: Using PHP, output the value of $link to href attribute of "a" element --></p>
<p>You can see below the list of the students:
<ul>
<!-- Task 4: Using foreach statement in PHP, try to create an HTML list here based on $studentList. Each item of the list should present one student as follows: "Student ID is: ... and student name is: ..." -->

</ul>
</p>

</body>
</html>
