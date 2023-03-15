SELECT t.name AS team_name, SUM(p.points) AS total_points
FROM f1db.team t JOIN f1db.driver d ON t.team_id = d.team_team_id
	JOIN f1db.result r ON r.driver_driver_id = d.driver_id
	JOIN f1db.points p ON p.position = r.points_position
	JOIN f1db.race ra ON ra.race_id = r.race_race_id AND ra.season_year = r.race_season_year
WHERE ra.season_year = 2021
GROUP BY t.name
ORDER BY total_points DESC;