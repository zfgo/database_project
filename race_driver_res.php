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
  
$race = $_POST['race'];
$season = $_POST['season'];

$season = mysqli_real_escape_string($conn, $season);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT r.points_position AS position, CONCAT(d.fname, ' ', d.lname) AS driver_name
          FROM f1db.race ra JOIN f1db.result r ON ra.race_id = r.race_race_id AND ra.season_year = r.race_season_year
              JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
              JOIN f1db.points p ON r.points_position = p.position
          WHERE ra.name LIKE ".$race." AND ra.season_year = ".$season" 
          ORDER BY r.points_position;";

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
<p

<?php
$result = mysqli_query($conn, $query)
or die(mysqli_error($conn));

$mask = "| %-18s | %-18s |\n";
print "<pre>";
printf($mask, "------------------", "------------------");
printf($mask, "position", "driver");
printf($mask, "------------------", "------------------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    //print "\n";
    printf($mask, "$row[position]", "$row[driver_name]");
}
printf($mask, "------------------", "------------------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
