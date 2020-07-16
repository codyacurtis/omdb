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
    $sql_A = "SELECT people_id, screen_name, first_name, middle_name, last_name, gender, image_name 
              FROM people 
              WHERE people_id =". $people_id;

    if (!$sql_A_result = $db->query($sql_A)) {
      die('There was an error running query[' . $connection->error . ']');
    }

    if ($sql_A_result->num_rows > 0) {
      $a_tuple = $sql_A_result->fetch_assoc();
      echo '<br> People ID : ' . $a_tuple["people_id"] .
        '<br> Screen Name : ' . $a_tuple["screen_name"] .
        '<br> First Name : ' . $a_tuple["first_name"] .
        '<br> Middle Name :  ' . $a_tuple["middle_name"].
        '<br> Last Name :  ' . $a_tuple["last_name"].
        '<br> Gender :  ' . $a_tuple["gender"].
        '<br> image_name :  ' . $a_tuple["image_name"].
        '<br><img src="images/'.$a_tuple["image_name"].'" style="width:100px;height:120px;">';
    } //end if
    else {
      echo "0 results";
    } //end else

    $sql_A_result->close();
    ?>
  </div>
</div>



<!-- ================ [B]======================
[B] PEOPLE aggegation
(display this as a table or name value pairs;
Do whatever is easier for you)

No of Movies as <role1>: 
No of Movies as <role2>: 
No of Movies as <role3>: 
No of Songs as Composer: 
No of Songs as Lyricist:
No of Songs as Music Director:
========================================================================= -->


<div class="right-content">
  <div class="container">
    <h3 style="color: #01B0F1;">[B.1] People  (table: movie_people and people)</h3>
    <table>
    <tr>
      <th>role</th>
      <th>count</th>
    </tr>
    
    <?php


    // query string for the Query A
    $sql_B = "SELECT COUNT(role),role
              FROM movie_people
              WHERE people_id = $people_id
              GROUP by role
              UNION
              SELECT COUNT(role),role
              FROM song_people
              WHERE people_id = $people_id
              GROUP BY role";
              
    $sql_B_result = $db -> query($sql_B);

    if($sql_B_result -> num_rows > 0){
      while($row = $sql_B_result -> fetch_assoc()){
        echo "<tr><td>" . $row["role"] . "</td><td>" . $row["COUNT(role)"]."</td></tr>";
      }
      echo"</table>";
    }else {
        echo "0 results";
      }

    $sql_B_result->close();
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