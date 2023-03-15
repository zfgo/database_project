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

$query = "SELECT r.name AS race_name, c.name AS circuit_name, c.length AS circuit_length, c.n_laps AS laps, r.date AS race_date, ROUND(c.length * c.n_laps, 3) AS total_race_length
          FROM f1db.race r JOIN f1db.circuit c ON r.circuit_circuit_id = c.circuit_id
          WHERE r.season_year = ".$season."
          ORDER BY r.date;";

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
//    race name,circ name,date,circ len, laps,total len
$mask = "| %-30s | %-30s | %-12s | %14s | %4s | %12s |\n";
print "<pre>";
printf($mask, "------------------------------", "------------------------------", "------------", "--------------", "----", "------------");
printf($mask, "race name", "circuit name", "race date", "circuit length", "laps", "total length");
printf($mask, "------------------------------", "------------------------------", "------------", "--------------", "----", "------------");
while($row = mysqli_fetch_array($result, MYSQLI_BOTH))
{
    printf($mask, "row[race_name]", "row[circuit_name]", "row[race_date]", "row[circuit_length]", "row[laps]", "row[total_race_length]");
}
printf($mask, "------------------------------", "------------------------------", "------------", "--------------", "----", "------------");
print "</pre>";

mysqli_free_result($result);

mysqli_close($conn);

?>

<p>
<hr>

<p>
 
</body>
</html>
