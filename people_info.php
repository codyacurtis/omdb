<?php
$nav_selected = "PEOPLE";
$left_buttons = "YES";
$left_selected = "NO";

include("./nav.php");
require 'bin/functions.php';
require 'db_configuration.php';
global $db;
?>

<!-- =====================================================================================================

This page displays the information about people given a people_id.
The input is "people_id". 
This "people_id" is passed to people_info.php as a URL parameter.

This pages displays the people information in four sections.

[A] PEOPLE data 
[B] PEOPLE aggregation
[C] PEOPLE - Movies
[D] PEOPLE - Songs

The above three sections are outlined below

[A] PEOPLE data 
people_id
stage_name
first_name
middle_name
last_name
gender
image_name

[B] PEOPLE aggegation
(display this as a table or name value pairs;
Do whatever is easier for you)

No of Movies as <role1>: 
No of Movies as <role2>: 
No of Movies as <role3>: 
No of Songs as Composer: 
No of Songs as Lyricist:
No of Songs as Music Director:

[C] PEOPLE - Movies
(display this as a table)

movie_id, native_name, english_name, year_made, role, screen_name


[D} PEOPLE - Songs

Display Type: Show this as a table

song_id
title 
lyrics (show first 30 characters)
role (from song_people)

===================================================================================================== -->

<!-- ========== Getting the movie id =====================================
// This is the movie_id coming to this page as GET parameter
// We will fetch it and save it as $movie_id to be used in our queries
======================================================================== -->
<?php
if (isset($_GET['people_id'])) {
  $people_id = mysqli_real_escape_string($db, $_GET['people_id']);
}
?>


<!-- ================ [A] Basic Data (table: people) ======================
Display Type: Name - value pairs

[A] PEOPLE data 
people_id
stage_name
first_name
middle_name
last_name
gender
image_name
========================================================================= -->

<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[A] People -> Basic Data</h3>

    <?php


    // query string for the Query A
    $sql_A = "SELECT stage_name, first_name, middle_name, last_name, gender, image_name 
              FROM people 
              WHERE people_id =". $people_id;

    if (!$sql_A_result = $db->query($sql_A)) {
      die('There was an error running query[' . $connection->error . ']');
    }

    if ($sql_A_result->num_rows > 0) {
      $a_tuple = $sql_A_result->fetch_assoc();
      echo '<br> People ID : ' . $a1_tuple["people_id"] .
        '<br> Stage Name : ' . $a1_tuple["native_name"] .
        '<br> First Name : ' . $a1_tuple["english_name"] .
        '<br> Middle Name :  ' . $a1_tuple["year_made"].
        '<br> Last Name :  ' . $a1_tuple["year_made"].
        '<br> Gender :  ' . $a1_tuple["year_made"].
        '<br> image_name :  ' . $a1_tuple["year_made"];
    } //end if
    else {
      echo "0 results";
    } //end else

    $sql_A_result->close();
    ?>
  </div>
</div>



<!-- ================ [A.2] Extended Data (table: movie_data) ======================
Display Type: Name - value pairs

language
country
genre
plot

TODO: Copy the code snippet from A.1, change the code to reflect Extended data
========================================================================= -->
<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[A.2] Movies -> Extended Data</h3>

    <?php

    $sql_A2 = "SELECT language, country, genre, plot FROM `movie_data` WHERE movie_data.movie_id =" . $movie_id;

   if (!$sql_A2_result = $db->query($sql_A2)) { 
     die('There was an error running query[' . $connection->error . ']');
    }

  if ($sql_A2_result->num_rows > 0) {
    $a2_tuple = $sql_A2_result->fetch_assoc();
      echo '<br> Language : ' . $a2_tuple["language"] .
      '<br> Country : ' . $a2_tuple["country"] .
      '<br> Genre : ' . $a2_tuple["genre"] .
      '<br> Plot :  ' . $a2_tuple["plot"];
  } //end if
  else {
    echo "0 results";
  } //end else

  $sql_A2_result->close(); 
    ?>

  </div>
</div>


<!-- ================ [A.3] Movie Media (table: movie_media) ======================
Display Type: Show this as a table

m_media_id
m_link  (preferable to display the media on the page)
m_link_type
========================================================================= -->

<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[A.3] Movie -> Media</h3>


    <table class="display" id="movie_media_table" style="width:100%">
      <div class="table responsive">

        <thead>
          <tr>
            <th> Movie ID </th>
            <th> Media Id</th>
            <th> Media Link</th>
            <th> Link Type</th>
          </tr>
        </thead>

        <?php

        // query string for the Query A.1
        $sql_A3 = "SELECT movie_id, movie_media_id, m_link, m_link_type FROM movie_media WHERE movie_id =" . $movie_id;

        if (!$sql_A3_result = $db->query($sql_A3)) {
          die('There was an error running query[' . $connection->error . ']');
        }

        // this is 1 to many relationship
        // So, many tuples may be returned
        // We will display those in a table in a while loop
        if ($sql_A3_result->num_rows > 0) {
          // output data of each row
          while ($a3_tuple = $sql_A3_result->fetch_assoc()) {
            echo '<tr>
                      <td>' . $a3_tuple["movie_id"] . '</td>
                      <td>' . $a3_tuple["movie_media_id"] . '</td>
                      <td>' . $a3_tuple["m_link"] . '</td>
                      <td>' . $a3_tuple["m_link_type"] . ' </span> </td>
                  </tr>';
          } //end while

        } //end second if 

        $sql_A3_result->close();
        ?>

    </table>
  </div>
</div>



<!-- ================ [A.4] Movie Key Words (table: movie_keywords) ======================
Display Type: Name - value pairs

keywords (show it as a comma separated list) 

ADD THIS SOMEHOW:
$keyword = "";
$keyword = $keyword  .$row["keyword"] . ",";

========================================================================= -->

<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[A.4] Movie -> Key Words</h3>

    <table class="display" id="keywords_table" style="width:100%">
      <div class="table responsive">

        <thead>
          <tr>
            <th> Keywords </th>
            
          </tr>
        </thead>

        <?php

        // query string for the Query A.1
        $sql_A4 = "SELECT keyword FROM movie_keywords WHERE movie_id=" . $movie_id;

        // echo $sql_A4;

        if (!$sql_A4_result = $db->query($sql_A4)) {
          die('There was an error running query[' . $db->error . ']');
        }

        // this is 1 to many relationship
        // So, many tuples may be returned
        // We will display those in a table in a while loop
        if ($sql_A4_result->num_rows > 0) {
          // output data of each row
          while ($a4_tuple = $sql_A4_result->fetch_assoc()) {
            echo '<tr>
                      <td>' . $a4_tuple["keyword"] . ' </span> </td>
                  </tr>';
          } //end while

        } //end second if 

        $sql_A4_result->close();
        ?>

    </table>
  </div>
</div>


<!-- ================ [A.5] (table: movie_trivia) ======================
Display Type: Heading and set of values (ordered by serial number starting with 1)

trivia (show these as a list)
========================================================================= -->



<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[A.5] Movie -> Trivia</h3>

    <table class="display" id="trivia_table" style="width:100%">
      <div class="table responsive">

        <thead>
          <tr>
            <th> Trivia </th>
            
          </tr>
        </thead>

        <?php

        // query string for the Query A.1
        $sql_A5 = "SELECT movie_trivia_name FROM `movie_trivia` WHERE movie_id=" . $movie_id;

        if (!$sql_A5_result = $db->query($sql_A5)) {
          die('There was an error running query[' . $db->error . ']');
        }

        // this is 1 to many relationship
        // So, many tuples may be returned
        // We will display those in a table in a while loop
        if ($sql_A5_result->num_rows > 0) {
          // output data of each row
          $s_no = 1;
          while ($a5_tuple = $sql_A5_result->fetch_assoc()) {
            echo '<tr>
                     <td> ' .$s_no .' : </td>
                      <td>' . $a5_tuple["movie_trivia_name"] . ' </span> </td>
                  </tr>';
            $s_no = $s_no + 1;
          } //end while

        } //end second if 

        $sql_A5_result->close();
        ?>

    </table>
  </div>
</div>



<!-- ================ [B.1] People  (table: movie_people and people)   ======================
Display Type: Show this as a table

role 
screen_name
first_name
middle_name
last_name 
image_name  
========================================================================= -->

<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[B.1] Movie -> People</h3>

    <table class="display" id="movie_people_table" style="width:100%">
      <div class="table responsive">

        <thead>
          <tr>
            <th> Stage Name</th>
            <th> First Name</th>
            <th> Middle Name</th>
            <th> Last Name</th>
            <th> Role </th>
            <th> Screen Name</th>
            <th> Image name</th>

          </tr>
        </thead>

        <?php

        // query string for the Query A.1
        $sql_B1 = "SELECT stage_name, first_name, middle_name, last_name, gender, `role`, screen_name, image_name 
                   FROM movie_people INNER JOIN people 
                   ON movie_people.people_id = people.people_id 
                   WHERE movie_people.movie_id=" . $movie_id;


        if (!$sql_B1_result = $db->query($sql_B1)) {
          die('There was an error running query[' . $connection->error . ']');
        }

        // this is 1 to many relationship
        // So, many tuples may be returned
        // We will display those in a table in a while loop
        if ($sql_B1_result->num_rows > 0) {
          // output data of each row
          while ($b1_tuple = $sql_B1_result->fetch_assoc()) {
            echo '<tr>
                      <td>' . $b1_tuple["stage_name"] . '</td>
                      <td>' . $b1_tuple["first_name"] . '</td>
                      <td>' . $b1_tuple["middle_name"] . '</td>
                      <td>' . $b1_tuple["last_name"] . '</td>
                      <td>' . $b1_tuple["role"] . '</td>
                      <td>' . $b1_tuple["screen_name"] . '</td>
                      <td>' . $b1_tuple["image_name"] . ' </span> </td>
                  </tr>';
          } //end while

        } //end second if 

        $sql_B1_result->close();
        ?>

    </table>
  </div>
</div>



<!-- ================ [C.1] Songs (table: movie_song, songs, song_media, song_people, song_keywords)   ======================
Display Type: Show this as a table

title 
lyrics (first 30 characters)
role (from song_people)
keywords (from song_keywords, show this info as comma separated list
media (from songs_media - show the IDs as comma separated list, media_link will be a hyper link)
========================================================================= -->

<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[C.1] Movie -> Songs</h3>

    <table class="display" id="songs_table" style="width:100%">
      <div class="table responsive">

        <thead>
          <tr>
            <th> Title </th>
            <th> Lyrics </th>
          </tr>
        </thead>

        <?php

        // query string for the Query A.1
        $sql_C1 = "SELECT title, LEFT(lyrics,10) AS lyrics10
                  FROM songs INNER JOIN movie_song 
                  ON (movie_song.song_id = songs.song_id)
                  WHERE movie_id=" . $movie_id;

        if (!$sql_C1_result = $db->query($sql_C1)) {
          die('There was an error running query[' . $db->error . ']');
        }

        // this is 1 to many relationship
        // So, many tuples may be returned
        // We will display those in a table in a while loop
        if ($sql_C1_result->num_rows > 0) {
          // output data of each row
          while ($c1_tuple = $sql_C1_result->fetch_assoc()) {
            echo '<tr>
                      <td>' . $c1_tuple["title"] . '</td>
                      <td>' . $c1_tuple["lyrics10"] . '</td>
                  </tr>';
          } //end while

        } //end second if 

        $sql_C1_result->close();
        ?>

    </table>
  </div>
</div>


<!-- ================== JQuery Data Table script ================================= -->

<script type="text/javascript" language="javascript">
  $(document).ready(function() {

    $('#info').DataTable({
      dom: 'lfrtBip',
      buttons: [
        'copy', 'excel', 'csv', 'pdf'
      ]
    });

    $('#info thead tr').clone(true).appendTo('#info thead');
    $('#info thead tr:eq(1) th').each(function(i) {
      var title = $(this).text();
      $(this).html('<input type="text" placeholder="Search ' + title + '" />');

      $('input', this).on('keyup change', function() {
        if (table.column(i).search() !== this.value) {
          table
            .column(i)
            .search(this.value)
            .draw();
        }
      });
    });

    var table = $('#info').DataTable({
      orderCellsTop: true,
      fixedHeader: true,
      retrieve: true
    });

  });
</script>



<style>
  tfoot {
    display: table-header-group;
  }
</style>

<?php include("./footer.php"); ?>