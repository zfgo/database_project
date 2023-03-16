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
  
$driver = $_POST['driver'];
$season = $_POST['season'];

$season = mysqli_real_escape_string($conn, $season);
$driver = mysqli_real_escape_string($conn, $driver);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT ra.name AS race_name, r.points_position AS position, p.points AS points
          FROM f1db.result r JOIN f1db.race ra ON r.race_race_id = ra.race_id AND r.race_season_year = ra.season_year
              JOIN f1db.points p ON r.points_position = p.position
              JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
          WHERE d.lname = '".$driver."' AND ra.season_year = ".$season."
          ORDER BY ra.date;";

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

$mask = "| %-26s | %10s | %10s |\n";
print "<pre>";
printf($mask, "--------------------------", "----------", "----------");
printf($mask, "race name", "position", "points");
printf($mask, "--------------------------", "----------", "----------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    printf($mask, "$row[race_name]", "$row[position]", "$row[points]");
}
printf($mask, "--------------------------", "----------", "----------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
