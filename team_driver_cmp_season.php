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
$team = $_POST['team'];

$season = mysqli_real_escape_string($conn, $season);
$team = mysqli_real_escape_string($conn, $team);
// this is a small attempt to avoid SQL injection
// better to use prepared statements

// $query = "SELECT CONCAT(d.fname, ' ', d.lname) as driver_name, d.code AS driver_code, d.number AS driver_num, SUM(p.points) AS total_points, COUNT(r.race_race_id) AS num_races
//           FROM f1db.result r JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
//               JOIN f1db.team t ON d.team_team_id = t.team_id
//               JOIN f1db.points p ON r.points_position = p.position
//           WHERE t.name LIKE '".$team."' AND r.race_season_year = ".$season."
//           GROUP BY d.driver_id, d.fname, d.lname, d.code, d.number
//           ORDER BY total_points DESC;";
$query = "SELECT CONCAT(d.fname, ' ', d.lname) as driver_name, d.code AS driver_code, d.number AS driver_num, r.race_season_year-YEAR(d.dob) AS driver_age, SUM(p.points) AS total_points, COUNT(r.race_race_id) AS num_races
          FROM f1db.result r JOIN f1db.driver d ON r.driver_driver_id = d.driver_id
              JOIN f1db.team t ON d.team_team_id = t.team_id
              JOIN f1db.points p ON r.points_position = p.position
          WHERE t.name LIKE '".$team."' AND r.race_season_year = ".$season."
          GROUP BY d.driver_id, d.fname, d.lname, d.code, d.number, driver_age
          ORDER BY total_points DESC;";
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

$mask = "| %-18s | %-12s | %10s | %4s | %12s | %9s |\n";
print "<pre>";
printf($mask, "------------------", "------------", "----------", "----", "------------", "---------");
printf($mask, "driver name", "driver code", "driver num", "age", "total points", "num races");
printf($mask, "------------------", "------------", "----------", "----", "------------", "---------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    printf($mask, "$row[driver_name]", "$row[driver_code]", "$row[driver_num]", "$row[driver_age]", "$row[total_points]", "$row[num_races]");
}
printf($mask, "------------------", "------------", "----------", "----", "------------", "---------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
