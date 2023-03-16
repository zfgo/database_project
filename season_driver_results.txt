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
  
$season = $_POST['season'];

$season = mysqli_real_escape_string($conn, $season);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT CONCAT(d.fname, ' ', d.lname) AS name, SUM(p.points) AS result\nFROM f1db.driver AS d JOIN f1db.result AS r ON d.driver_id = r.driver_driver_id\nJOIN f1db.points AS p ON r.points_position = p.position\nJOIN f1db.season AS s ON r.race_season_year = s.year\nWHERE s.year = ";
$query = $query.$season;
$query = $query."\nGROUP BY d.fname, d.lname\nORDER BY result DESC";

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

$mask = "| %-18s | %10s |\n";
print "<pre>";
printf($mask, "------------------", "----------");
printf($mask, "name", "points");
printf($mask, "------------------", "----------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    //print "\n";
    printf($mask, "$row[name]", "$row[result]");
}
printf($mask, "------------------", "----------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
	  
