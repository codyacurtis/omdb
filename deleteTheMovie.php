<?php
 $nav_selected = "LIST";
  $left_buttons = "NO";
  $left_selected = "";
  include("./nav.php");
  include("./footer.php");  
  include_once 'db_configuration.php';


  if (isset($_GET['movie_id'])){

    $id = $_GET['movie_id'];
    
    $sql = "SELECT * FROM movies
            WHERE movie_id = '$id'";

    if (!$result = $db->query($sql)) {
        die ('There was an error running query[' . $connection->error . ']');
    }//end if
}//end if

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<form action="delete_movie.php" method="POST">
    <br>
    <h3 id="title">Delete Movie?</h3><br>
    <h2>'.$row["native_name"].'</h2> <br>
    
    <div class="form-group col-md-4">
      <label for="id">Id</label>
      <input type="text" class="form-control" name="id" value="'.$row["movie_id"].'"  maxlength="5" readonly>
    </div>
           
    <br>
    <div class="text-left">
        <button type="submit" name="submit" class="btn btn-danger btn-md align-items-center">Delete</button>
    </div>
    <br> <br>
    
    </form>';

    }//end while
}//end if
else {
    echo "0 results";
}//end else

?>

</div>