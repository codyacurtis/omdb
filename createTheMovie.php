<?php
 $nav_selected = "LIST";
  $left_buttons = "NO";
  $left_selected = "";
  include("./nav.php");
  include("./footer.php");  
  include_once 'db_configuration.php';


    // Initialize variables        
	$native_name = mysqli_real_escape_string($db,$_POST['native_name']);
    $english_name = mysqli_real_escape_string($db,$_POST['english_name']);
    $year_made = mysqli_real_escape_string($db,$_POST['year_made']);
    $language = mysqli_real_escape_string($db,$_POST['language']);
    $Country = mysqli_real_escape_string($db,$_POST['Country']);
    $genre = mysqli_real_escape_string($db,$_POST['genre']);
    $plot = mysqli_real_escape_string($db,$_POST['plot']);
    $tag_line = mysqli_real_escape_string($db,$_POST['tag_line']);
    $Keyword = mysqli_real_escape_string($db,$_POST['Keyword']);
    $m_link = mysqli_real_escape_string($db,$_POST['m_link']);
    $m_link_type = mysqli_real_escape_string($db,$_POST['m_link_type']);
    $Image = basename($_FILES["Image"]["name"]);



    $validate = true;    
    

    $sql = "INSERT INTO movies(native_name, english_name, year_made)
    VALUES ('test','test','1234');
    
    INSERT INTO movie_data(language, country, genre, plot, tag_line)
    VALUES ('en','usa','death','death','death');
    
    INSERT INTO movie_keyword(keyword)
    VALUES ('death');
    
    INSERT INTO movie_media(m_link, m_link_type)
    VALUES ('death','death');
    ";

    $result = $db->query($sql);
    header('location: movies.php?create_movie=Success');
    ?>
	<link rel="stylesheet" href="css/mainStyleSheet.css" type="text/css">



   