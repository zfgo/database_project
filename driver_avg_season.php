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

$query = "SELECT CONCAT(d.fname, " ", d.lname) AS driver_name, AVG(r.points_position) AS avg_position, AVG(p.points) AS avg_points
          FROM f1db.result r JOIN f1db.race ra ON r.race_race_id = ra.race_id AND r.race_season_year = ra.season_year
              JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
              JOIN f1db.points p ON r.points_position = p.position
          WHERE ra.season_year = ".$season."
          GROUP BY driver_name
          ORDER BY AVG(p.points) DESC;";

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

$mask = "| %-18s | %10s | %10s |\n";
print "<pre>";
printf($mask, "------------------", "----------", "----------");
printf($mask, "driver name", "avg position", "avg points");
printf($mask, "------------------", "----------", "----------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    printf($mask, "$row[driver_name]", "$row[avg_points]", "$row[avg_position]");
}
printf($mask, "------------------", "----------", "----------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
