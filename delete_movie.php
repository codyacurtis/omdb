<?php

  $nav_selected = "MOVIES"; 
  $left_buttons = "YES"; 
  $left_selected = "MOVIES"; 

  include("./nav.php");
  global $db;


if (isset($_GET['movie_id'])){

    $id = mysqli_real_escape_string($db, $_GET['movie_id']);

    unlink($file);

    $sql = "DELETE FROM movies
            WHERE movie_id = '$id'";

    $result = $db->query($sql);
    echo"Success!!";
    header('location: movies.php?movieDeleted=Success');
}//end if
?>

