--Cody's Optimization

--[1] SQL query
Select movies.*, COUNT(movie_people.people_id)
FROM movies LEFT JOIN movie_people
ON movies.movie_id = movie_people.movie_id
GROUP BY movie_id

--[2] EXPLAIN for inital query
127.0.0.1/omdb/movie_people/		http://localhost/phpmyadmin/tbl_sql.php?db=omdb&table=movie_people
Your SQL query has been executed successfully.

EXPLAIN Select movies.*, COUNT(movie_people.people_id)
FROM movies LEFT JOIN movie_people
ON movies.movie_id = movie_people.movie_id
GROUP BY movie_id



1	SIMPLE	movies	ALL	
    NULL
	
    NULL
	
    NULL
	
    NULL
	190671	Using temporary; Using filesort	
1	SIMPLE	movie_people	ALL	
    NULL
	
    NULL
	
    NULL
	
    NULL
	23	Using where; Using join buffer (flat, BNL join)	

--No index or primary keys in the movie_people table.
--Showing rows 0 - 24 (192448 total, Query took 1.9066 seconds.)

--[3] Steps taken to optimize query
--Index and Primary keys added to use index, reduced execution time by +100 times

--[4]EXPLAIN numbers for optimized query
127.0.0.1/omdb/movies/		http://localhost/phpmyadmin/db_sql.php?db=omdb
Your SQL query has been executed successfully.

EXPLAIN Select movies.*, COUNT(movie_people.people_id)
FROM movies LEFT JOIN movie_people
ON movies.movie_id = movie_people.movie_id
GROUP BY movie_id



1	SIMPLE	movies	index	
    NULL
	PRIMARY	4	
    NULL
	190671		
1	SIMPLE	movie_people	ref	PRIMARY	PRIMARY	4	omdb.movies.movie_id	2	Using index	

--Showing rows 0 - 24 (192448 total, Query took 0.0102 seconds.)