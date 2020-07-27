<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    function updateValue(element,column,id){
        var value = element.innerText
        $.ajax({
            url:'editableList.php',
            type: 'post',
            data:{
                value: value,
                column: column,
                id: id
            },
            success:function(php_result){
				console.log(php_result);
				
            }
            
        })
    }

    $(document).ready(function() {
        $.fn.dataTable.ext.errMode = 'none';

  var table = $('#ceremoniesTable').DataTable({
  });

  $('a.showHideColumn').on('click', function(e) {
    e.preventDefault();

    // Get the column API object
    var column = table.column($(this).attr('data-columnindex'));

    // Toggle the visibility
    column.visible(!column.visible());
  });
});
</script> 

<!-- Add show/hide column -->
<style> 
	.ShowHideColumn {
			cursor: pointer;
			color:blue;
	}

</style> 
<!-- Add show/hide column -->
<?php
  $nav_selected = "LIST";
  $left_buttons = "NO";
  $left_selected = "";
  
require 'functions.php';
require 'db_configuration.php';

$query = "SELECT movies.*, movie_data.language, movie_data.country, movie_data.genre, movie_data.plot, cast_list.cast, keywords_list.keyword_list, trivia_list.trivia_cat, movie_media.m_link_type, movie_media.m_link
FROM movies
LEFT JOIN movie_data
ON movies.movie_id = movie_data.movie_id

LEFT JOIN (SELECT people_list.*,
         GROUP_CONCAT(
            CONCAT_WS(' - ', role, screen_name)
            SEPARATOR '; ') AS cast
        FROM (SELECT movie_people.movie_id, people.screen_name, movie_people.role, people.image_name
            FROM movie_people
            LEFT JOIN people
            ON movie_people.people_id = people.people_id) AS people_list) AS cast_list
ON movies.movie_id = cast_list.movie_id

LEFT JOIN (SELECT movie_keywords.*,
    GROUP_CONCAT(keyword SEPARATOR ', ') AS keyword_list
    FROM movie_keywords GROUP BY movie_id) AS keywords_list
ON movies.movie_id = keywords_list.movie_id

LEFT JOIN (SELECT movie_trivia.*,
    GROUP_CONCAT(trivia SEPARATOR ', ') AS trivia_cat
    FROM movie_trivia GROUP BY movie_id) AS trivia_list
ON movies.movie_id = trivia_list.movie_id

LEFT JOIN movie_media
ON movies.movie_id = movie_media.movie_id
WHERE movie_media.m_link_type = 'poster'";
            
//list
$GLOBALS['data'] = mysqli_query($db, $query);
// $GLOBALS['movie_id'] = mysqli_query($db, $query);
// $GLOBALS['native_name'] = mysqli_query($db, $query);
// $GLOBALS['english_name'] = mysqli_query($db, $query);
// $GLOBALS['year_made'] = mysqli_query($db, $query);
// $GLOBALS['genre'] = mysqli_query($db, $query);
// $GLOBALS['plot'] = mysqli_query($db, $query);
// $GLOBALS['cast'] = mysqli_query($db, $query);
// $GLOBALS['image_name'] = mysqli_query($db, $query);
// $GLOBALS['keyword_list'] = mysqli_query($db, $query);
// $GLOBALS['trivia_cat'] = mysqli_query($db, $query);
// $GLOBALS['m_link_type'] = mysqli_query($db, $query);
// $GLOBALS['m_link'] = mysqli_query($db, $query);
  include("./nav.php");
  
?>

<?php include("./footer.php"); ?>

<?php $page_title = 'omdb list'; ?>
<?php 
    $page="list.php";
    //verifyLogin($page);
?>

<link rel="stylesheet" href="css/mainStyleSheet.css" type="text/css">

<style>
    #title {
        text-align: center;
        color: darkgoldenrod;
    }
    thead input {
        width: 100%;
    }
    .thumbnailSize{
        height: 100px;
        width: 100px;
        transition:transform 0.25s ease;
    }
    .thumbnailSize:hover {
        -webkit-transform:scale(3.5);
        transform:scale(3.5);
    }
</style>

<!-- Page Content -->
<br><br>
<div class="container-fluid">
<?php
        if(isset($_GET['createDishes'])){
            if($_GET["createDishes"] == "Success"){
                echo '<br><h3>Success! Your dish has been added!</h3>';
            }
        }

        if(isset($_GET['dishUpdated'])){
            if($_GET["dishUpdated"] == "Success"){
                echo '<br><h3>Success! Your dish has been modified!</h3>';
            }
        }

        if(isset($_GET['movieDeleted'])){
            if($_GET["movieDeleted"] == "Success"){
                echo '<br><h3>Success! Your Movie has been deleted!</h3>';
            }
        }

    ?>
   
   
    <h2 id="title">Movies List</h2><br>    
    <div id="customerTableView">
	
        <button><a class="btn btn-sm" href="createDish.php">Create a Movie</a></button>
        <table class="display" id="ceremoniesTable" style="width:100%">
	
            <div class="table responsive">
                <thead>
                <tr>
                    <th>Movie ID</th>
                    <th>Native Name</th>
                    <th>English Name</th>
                    <th>Year</th>
                    <th>Cast</th>
                    <th>Key Words</th>                
                    <th>Poster</th>
                    <th>Modify</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
				
					<!-- Add show/hide column -->	
	<div style="padding:5px; padding-left:0px">
		<b>Show/Hide Columns:  </b>
		<a class="showHideColumn" data-columnindex="0">Movie ID</a> -
		<a class="showHideColumn" data-columnindex="1">Native Name</a> -
		<a class="showHideColumn" data-columnindex="2">English Name</a> -
		<a class="showHideColumn" data-columnindex="3">Year</a> -
		<a class="showHideColumn" data-columnindex="4">Cast</a> -
		<a class="showHideColumn" data-columnindex="5">Key Words</a> -
		<a class="showHideColumn" data-columnindex="6">Poster</a>
	</div>
	<!-- Add show/hide column -->	
    
                <?php
                while($row = $data->fetch_assoc()) {
                    $Movie_ID = $row["movie_id"];
                    $Native_Name = $row["native_name"];
                    $English_Name = $row["english_name"];
                    $Year = $row["year_made"];
                    $Cast = $row["cast"];
                    $Key_Words = $row["keyword_list"];
                    $Poster = $row["m_link"];
                
                    if(isset($_SESSION['role'])) { //logged in, allow in cell editing
                        ?>
                        <tr>
                    <td><?php echo $Movie_ID; ?></td>   
                    <td><div contenteditable="true" onBlur="updateValue(this,'native_name','<?php echo $Movie_ID; ?>')"><?php echo $Native_Name; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'english_name','<?php echo $Movie_ID; ?>')"><?php echo $English_Name; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'year','<?php echo $Movie_ID; ?>')"><?php echo $Year; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'cast','<?php echo $Movie_ID; ?>')"><?php echo $Cast; ?></div></span> </td>
                    <td><div contenteditable="true" onBlur="updateValue(this,'keyword_list','<?php echo $Movie_ID; ?>')"><?php echo $Key_Words; ?></div></span> </td>
                    <?php echo '<td><img src="images/'.$row["m_link"].'" style="width:100px;height:120px;">' ?>
                    <?php echo '<td><a class="btn btn-warning btn-sm" href="modifyDish.php?id='.$row["movie_id"].'">Modify</a></td>' ?>
                    <?php echo '<td><a class="btn btn-danger btn-sm" href="deleteTheMovie.php?id='.$row["movie_id"].'">Delete</a></td>' ?>
                </tr>

                        <?php
                    }else{//not logged in, not allowed to do in cell editing
                        ?>
                        <tr>
                    <td><?php echo $Movie_ID; ?></td>
                    <td><div><?php echo $Native_Name; ?></div></span> </td>
                    <td><div><?php echo $English_Name; ?></div></span> </td>
                    <td><div><?php echo $Year; ?></div></span> </td>
                    <td><div><?php echo $Cast; ?></div></span> </td>
                    <td><div><?php echo $Key_Words; ?></div></span> </td>
                    <?php echo '<td><img src="images/'.$row["m_link"].'" style="width:100px;height:120px;">' ?>
                    <?php echo '<td><a class="btn btn-warning btn-sm" href="modifyDish.php?id='.$row["movie_id"].'">Modify</a></td>' ?>
                    <?php echo '<td><a class="btn btn-danger btn-sm" href="deleteDish.php?id='.$row["movie_id"].'">Delete</a></td>' ?>
                </tr>

                        <?php
                    }
                }//end while
                ?>

                </tbody>
            </div>
        </table>
    </div>
</div>

<!-- /.container -->
<!-- Footer -->
<footer class="page-footer text-center">
   
</footer>

<!--JQuery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 

<!--Data Table-->
<script type="text/javascript" charset="utf8"
        src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready( function () {
        
        $('#ceremoniesTable').DataTable( {
            dom: 'lfrtBip',
            buttons: [
                'copy', 'excel', 'csv', 'pdf'
                
            ] }
        );
        

        $('#ceremoniesTable thead tr').clone(true).appendTo( '#ceremoniesTable thead' );
        $('#ceremoniesTable thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    
            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
    
        var table = $('#ceremoniesTable').DataTable( {
            orderCellsTop: true,
            fixedHeader: true,
            retrieve: true
        } );
        
        
    } );

    
	//add visible coloumn


</script>
</body>
</html>
