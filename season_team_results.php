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

$query = "SELECT t.name AS team_name, SUM(p.points) AS total_points\n";
$query = $query."FROM f1db.team AS t JOIN f1db.driver AS d ON t.team_id = d.team_team_id\n";
$query = $query."JOIN f1db.result AS r ON r.driver_driver_id = d.driver_id\n";
$query = $query."JOIN f1db.points AS p ON p.position = r.points_position\n";
$query = $query."JOIN f1db.race AS ra ON ra.race_id = r.race_race_id AND ra.season_year = r.race_season_year\n";
$query = $query."WHERE ra.season_year = ";
$query = $query.$season;
$query = $query."\nGROUP BY t.name\nORDER BY total_points DESC;";

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

$mask = "| %-24s | %-18s |\n";
$alt_mask = "| %-.24s | %-18s |\n";
print "<pre>";
printf($mask, "------------------------", "------------------");
printf($mask, "name", "result");
printf($mask, "------------------------", "------------------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    if (strlen("$row[team_name]") > 24)
    {
        printf($alt_mask, "$row[team_name]", "$row[total_points]");
    }
    else
    {
        printf($mask, "$row[team_name]", "$row[total_points]");
    }
}
printf($mask, "------------------------", "------------------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
