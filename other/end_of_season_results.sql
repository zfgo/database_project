SELECT CONCAT(d.fname, " ", d.lname) AS name, SUM(p.points) as result
FROM f1db.driver as d JOIN f1db.result as r ON d.driver_id = r.driver_driver_id
	JOIN f1db.points as p ON r.points_position = p.position
    JOIN f1db.season AS s ON r.race_season_year = s.year
WHERE s.year = 2021
GROUP BY d.fname, d.lname
ORDER BY result DESC