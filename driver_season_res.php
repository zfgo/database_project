<?php

include('connectionData.txt');

$conn = mysqli_connect($server, $user, $pass, $dbname, $port)
or die('Error connecting to MySQL server.');

?>

<html>

<a href="main.html" >go to the main page</a> 

<head>
  <title>Results of the Query</title>
</head>
  
  <body bgcolor="white">
  
  
  <hr>
  
  
<?php
  
$driver = $_POST['race'];
$season = $_POST['season'];

$season = mysqli_real_escape_string($conn, $season);
$driver = mysqli_real_escape_string($conn, $driver);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "";

?>

<p>
The query:
<p>
<?php
print $query;
?>

<hr>
<p>
Result of query:
<p>

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

$mask = "| %-10s | %-18s | %-10s |\n";
print "<pre>";
printf($mask, "----------", "------------------", "----------");
printf($mask, "position", "driver", "points");
printf($mask, "----------", "------------------", "----------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    //print "\n";
    printf($mask, "$row[position]", "$row[driver_name]", "$row[points]");
}
printf($mask, "----------", "------------------", "----------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
