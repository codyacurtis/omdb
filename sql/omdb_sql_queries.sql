/*Group Elephants SQL statements
Team query 7.33 Grab everything*/
SELECT movies.*, 
    movie_data.tag_line, movie_data.language, movie_data.country, movie_data.genre, movie_data.plot,
    COALESCE(trivia_count, 0) AS trivia_count, 
    COALESCE(keyword_count) AS keyword_count,
    COALESCE(movie_media_count) AS movie_media_count,
    COALESCE(movie_song_count) AS movie_song_count,
    COALESCE(movie_people_count) AS movie_people_count
    FROM movies
        LEFT JOIN movie_data
        ON movie_data.movie_id = movies.movie_id
        LEFT JOIN ( SELECT movie_id, COUNT(trivia) AS trivia_count
                   FROM movie_trivia
                   GROUP BY movie_id
        ) trivia_counts ON trivia_counts.movie_id = movies.movie_id
    
        LEFT JOIN ( SELECT movie_id, COUNT(movie_keywords.keyword) AS keyword_count
                   FROM movie_keywords
                   GROUP BY movie_id
        ) keyword_counts ON keyword_counts.movie_id = movies.movie_id
    
        LEFT JOIN ( SELECT movie_id, COUNT(movie_media.movie_media_id) AS movie_media_count
                   FROM movie_media
                   GROUP BY movie_id
        ) movie_media_counts ON movie_media_counts.movie_id = movies.movie_id
    
        LEFT JOIN ( SELECT movie_id, COUNT(movie_song.song_id) AS movie_song_count
                   FROM movie_song
                   GROUP BY movie_id
        ) movie_song_counts ON movie_song_counts.movie_id = movies.movie_id
    
        LEFT JOIN ( SELECT movie_id, COUNT(movie_people.people_id) AS movie_people_count
                   FROM movie_people
                   GROUP BY movie_id
        ) movie_people_counts ON movie_people_counts.movie_id = movies.movie_id;

/*Query 7.25 Create a relationship between a movie and a song
Assigned to Benjamin Hanson*/
INSERT INTO songs VALUES ('9', 'so many tears', 'I shall not fear no man but God
Though I walk thr...');
INSERT INTO moive_song VALUES ('35','9');


/*Query 7.26 Create a relation between a song and a people (including role)
Assigned to Marshall Nguyen*/
INSERT INTO song_people (song_id,people_id,role) VALUES (`60`,`90`,`Singer`);


/*Query 7.27 Update a relation between a movie and a people (including role and screen name)
Assigned to Abdullahi Mohamed
Not completed as Abdullahi has not participated in this activity*/


/*Query 7.28 Update a relation between a movie and a song
Assigned to Cody Curtis*/
UPDATE movie_song SET movie_id = 1, song_id = 2 WHERE movie_id = 1;


/*Query 7.29 Update a relation between a song and a people (including role)
Assigned to Geoffery Jordan*/
UPDATE song_people SET song_id = '3', people_id = '28', role = 'backup singer' WHERE song_id = '3';

/*Query 7.30 Delete a relation between a movie and a people (including role and screen name)
Assigned to Isiah Taylor*/
DELETE FROM movie_people WHERE movie_id = 1;

/*Query 7.68 Return the movie with most number of anagrams
Assigned to Cody Curtis*/
SELECT movies.english_name, COUNT(movie_anagrams.anagram) AS Anagram_Count
FROM movies
INNER JOIN movie_anagrams
ON movies.movie_id = movie_anagrams.movie_id
GROUP BY movies.movie_id
ORDER BY Anagram_Count DESC
LIMIT 1;

/*Query 7.55 Give me the list of all the movies based on a genre (“genre” is the input)
Assigned to #55 Geoff Jordan*/
Select native_name, genre
from movies
RIGHT outer join movie_data
on movies.movie_id = movie_data.movie_id
where genre = "Musical";

/*Query 7.66 Given a string X, return all the movies whose length (i.e the length of native name) is equal to the length of String X
Assinged to Isiah Taylor*/
SELECT native_name FROM movies
WHERE(LENGTH(movies.native_name)) = LENGTH("toxic");

/*7.48: Give me the list of all songs written by a lyricist (or a song performed by a singer/performer)
Assinged to Marshall Nquyen*/
Select screen_name,title,lyrics
FROM songs 
RIGHT OUTER JOIN song_people
on songs.song_id = song_people.song_id
RIGHT OUTER JOIN people
ON song_people.people_id = people.people_id
where screen_name = "Frank Sinatra";

/*Give me the list of all the movies that do NOT have any songs
Assigned to Ben Hanson*/
SELECT
    movies.movie_id, 
    movies.english_name,
    movie_song.movie_id
FROM
    movies
LEFT JOIN movie_song ON movies.movie_id = movie_song.movie_id
WHERE movie_song.movie_id IS null;