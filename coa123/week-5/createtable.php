<!DOCTYPE html>
<html lang="en">
<head>
<title>CSS Template</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{
  background-color:#aaaabb;}
table.table{
  font-size:1.5em;
  text-align:center;
  width:60%;
  margin-left:auto;
  margin-right:auto;
  border-style:outset;
  border-width:0.3em;
  border-color:#6666dd;}
th.head{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#44bbbb;}
td.cell1{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#8888ff;}
td.cell2{
  border-style:inset;
  border-width:0.15em;
  border-color:#9999ff;
  background-color:#88ff88;
}
td:hover{
  background-color:#ffbbff;}

</style>
<title>PHP generated table </title>
</head>

<body>
<!-- two rows of numbers using HTML  --> 
<table class="table">
  <th class="head">Heading 1</th><th class="head">Heading 2</th><th class="head">Heading 3</th>
  <tr>
    <td class="cell1">1</td><td class="cell1">1</td><td class="cell1">1</td>
  </tr>
  <tr>
    <td class="cell1">2</td><td class="cell1">2</td><td class="cell1">2</td>
  </tr>
</table>
<br>

<!-- Task1: use PHP to create 10 rows of numbers with alternative colours along each column   -->
<table class="table">
<th class="head">Heading 1</th><th class="head">Heading 2</th><th class="head">Heading 3</th>
<?php
for ($x = 1; $x < 11; $x++) {
    echo "<tr>";
    for ($i = 1; $i < 4; $i++) {
        $themod = $i % 3;
        if ($themod == 2) {
            echo "<td class='cell2'>$x</td>";
        } else {
            echo "<td class='cell1'>$x</td>";
        }
    }
    echo "</tr>";
}
?>

</table>
<br>
<br>

<!-- Task2: use PHP to create 10x10 multiplication table --> 
<table class="table">
<?php
$NumRows=10;
for($x=1;$x<=$NumRows;$x++){
	echo "<tr>";
    for ($i = 1; $i < 11; $i++) {
        $theproduct = $x * $i;
        if ($x == 1 || $i == 1) {
            echo "<td class='cell1'>$theproduct</td>";
        } else {
            echo "<td class='cell2'>$theproduct</td>";
        }
    }
    echo "</tr>";
}
?>
</table>

<br>

</table>

</body>
</html>