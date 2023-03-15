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
$race = mysqli_real_escape_string($conn, $race);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

$query = "SELECT @rank:=@rank+1 AS rank, t.name AS team_name, SUM(r.points_position) AS points
          FROM f1db.race ra JOIN f1db.result r ON ra.race_id = r.race_race_id AND ra.season_year = r.race_season_year
              JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
              JOIN f1db.team t ON d.team_team_id = t.team_id
              JOIN (SELECT @rank := 0) rnk
          WHERE ra.name LIKE '".$race."' AND ra.season_year = ".$season."
          GROUP BY t.name
          ORDER BY points DESC;";
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

$mask = "| %-10s | %-18s |\n";
print "<pre>";
printf($mask, "----------", "------------------");
printf($mask, "position", "driver");
printf($mask, "----------", "------------------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    //print "\n";
    printf($mask, "$row[position]", "$row[driver_name]");
}
printf($mask, "----------", "------------------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
