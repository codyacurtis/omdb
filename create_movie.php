

<?php $page_title = 'Movies > Create Movie'; ?>
<?php 

 // set the current page to one of the main buttons
  $nav_selected = "HOME";

  // make the left menu buttons visible; options: YES, NO
  $left_buttons = "NO";

  // set the left menu button selected; options will change based on the main selection
  $left_selected = "";

    include("./nav.php");
    require 'bin/functions.php';
    require 'db_configuration.php';
   // include('header.php'); 
	
    $page="movies.php";   

?>
<?php 
    $mysqli = NEW MySQLi('localhost','root','','omdb');
    //$resultset = $mysqli->query("SELECT DISTINCT topic FROM topics ORDER BY topic ASC");   
?>
<link rel="stylesheet" href="css/mainStyleSheet.css" type="text/css">

<link href="css/form.css" rel="stylesheet">
<style>#title {text-align: center; color: darkgoldenrod;}</style>
<div class="container">
    <!--Check the CeremonyCreated and if Failed, display the error message-->
    <?php
    if(isset($_GET['create_movie'])){
        if($_GET["create_movie"] == "fileRealFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not real, Please Try Again!</h3>';
        }
    }
    if(isset($_GET['create_movie'])){
        if($_GET["create_movie"] == "answerFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your answer was not one of the choices, Please Try Again!</h3>';
        }
    }
    if(isset($_GET['create_movie'])){
        if($_GET["create_movie"] == "fileTypeFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - Your image is not a valid image type (jpg,jpeg,png,gif), Please Try Again!</h3>';
        }
    }
    if(isset($_GET['create_movie'])){
        if($_GET["create_movie"] == "fileExistFailed"){
            echo '<br><h3 align="center" class="bg-danger">FAILURE - There is already a puzzle using that image, Please Try Again!</h3>';
        }
    }
  
    ?>
    <form action="createTheMovie.php" method="GET" enctype="multipart/form-data">
        <br>
        <h3 id="title">Create A Movie</h3> <br>
        
        <table>
            <!-- native name -->
            <tr>
                <td style="width:100px">native_name:</td>
                <td><input type="text"  name="native_name" maxlength="50" size="50" required title="Please enter the native name"></td>
            </tr>
            <!--  english name -->
            <tr>
                <td style="width:100px">english_name:</td>
                <td><input type="text"  name="english_name" maxlength="50" size="50" required title="Please enter the english name"></td>
            </tr>
            <!-- year made -->
            <tr>
                <td style="width:100px">year_made:</td>
                <td><input type="text"  name="year_made" maxlength="50" size="50" required title="Please enter the year made."></td>
            </tr>
            <!-- language -->
			<tr>
                <td style="width:100px">language:</td>
                <td><input type="text"  name="language" maxlength="50" size="50" required title="Please enter the language."></td>
            </tr>
            <!-- Country -->
			<tr>
                <td style="width:100px">Country:</td>
                <td><input type="text"  name="Country" maxlength="50" size="50" required title="Please enter the Country."></td>
            </tr>
			<!-- genre -->
			<tr>
                <td style="width:100px">genre:</td>
                <td><input type="text"  name="genre" maxlength="50" size="50" required title="Please enter the genre."></td>
            </tr>
			<!-- plot -->
			<tr>
                <td style="width:100px">plot:</td>
                <td><input type="text"  name="plot" maxlength="500" size="50" required title="Please enter the plot."></td>
            </tr>
            <!-- Keyword -->
			<tr>
                <td style="width:100px">Keyword:</td>
                <td><input type="text"  name="Keyword" maxlength="50" size="50" required title="Please enter the keyword."></td>
            </tr>
			<!-- m_link -->
			<tr>
                <td style="width:100px">m_link:</td>
                <td><input type="text"  name="m_link" maxlength="50" size="50" required title="m_link."></td>
            </tr>
            <!-- m_link_type -->
			<tr>
                <td style="width:100px">m_link_type:</td>
                <td><input type="text"  name="m_link_type" maxlength="50" size="50" required title="Please enter the m_link_type."></td>
            </tr>

            
            <!-- Status -->
            <!-- <tr>
            <td style="width:100px">Status:</td>
                <td>
                <input list="status" name="myStatus" maxlength="50" size="50" paddin: 100px />
                <datalist id="status">
                <option value="Proposed">
                <option value="Approved">
                <option value="Reviewed">
                </datalist>
                </td>
            </tr> -->
			
        </table>

        <br><br>
        <div align="center" class="text-left">
            <button type="submit" name="submit" class="btn btn-primary btn-md align-items-center">Create movie</button>
        </div>
        <br> <br>

    </form>
</div>

