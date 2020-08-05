<?php
session_start();
//require_once 'checklogin_user.php';
//require_once 'auto_check.php';
//echo "The current username " . $_SESSION['user'] . ".<br>";
if(!isset($_SESSION['user'])){
   header("location: index.html");
}
$mysql_host = 'localhost';
$mysql_user = 'cinemaparadiso_qc13';
$mysql_pass = 'cinemaparadiso_qc13';
$mysql_db = 'cinemaparadiso_IMDB';

$conn = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db) or die("could not connect");

$username = $_SESSION['user'];


//$movie_ids = shell_exec('php recommend.php');
include "recommend.php";

$query1 = "SELECT DISTINCT name, year, genre, group_concat(distinct concat(' ',first_name,' ',last_name)) AS director from movies INNER JOIN movies_directors ON movies.id=movies_directors.movie_id INNER JOIN movies_genres ON movies.id=movies_genres.movie_id INNER JOIN directors ON movies_directors.director_id=directors.id where movies.id in (SELECT Movie_ID as id FROM user_movies WHERE Username = '$username' AND Watched = 0) GROUP BY name, year";
$query2 = "SELECT DISTINCT name, year, group_concat(distinct concat(' ',first_name,' ',last_name)) AS director, Ratings from movies INNER JOIN movies_directors ON movies.id=movies_directors.movie_id INNER JOIN directors ON movies_directors.director_id=directors.id INNER JOIN user_movies ON user_movies.Movie_ID = movies.id WHERE Username = '$username' AND Watched = 1 GROUP BY name, year";
$query3 = "SELECT name, year, genre, group_concat(distinct concat(' ',directors.first_name,' ',directors.last_name)) AS director, group_concat(distinct concat(' ',actors.first_name,' ',actors.last_name)) AS actor from movies INNER JOIN roles ON movies.id=roles.movie_id INNER JOIN actors ON roles.actor_id=actors.id INNER JOIN movies_directors ON movies.id=movies_directors.movie_id INNER JOIN movies_genres ON movies.id=movies_genres.movie_id INNER JOIN directors ON movies_directors.director_id=directors.id where movies.id in ($movie_ids) GROUP BY name, year";

$result_a = $conn->query($query1);
$result_b = $conn->query($query2);
$row_cnt = $result_b->num_rows;

function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="css/image.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/pagination.js"></script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 100%}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #50462F;
	  width: 30vh;
      height: 100%;
	  position: fixed;
	  z-index: 1;
      color: white;
    }
	.col-sm-9 {
	margin-left: 33vh; /* Same as the width of the sidebar */
	padding: 0px 10px;
	}
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
    a{
        color: red;
    }
	td{
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
	}
  </style>
</head>
<body>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Hello <?php 
        echo $username ?>! <span class="glyphicon glyphicon-log-out"></span> <button class= "btn btn-danger" onclick="myFunction()"> Log Out</button></a></li>
        <script>
            function myFunction() {
                location.replace("logout.php")
        }
        </script>
      </ul>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <ul class="nav nav-pills nav-stacked">
        <li class="active" style="padding-top: 25px;"><a href="search.php" style="background-color: #2f2f2f; color: white;">Search a Movie</a></li>
		<li class="active" style="padding-top: 25px;"><img src="images/poster.jpg" style="width:auto; height:auto;"></li>
		<h3 style="padding-top: 1px;"> </h2>
		<h3 style="padding-top: 1px;">In this page, we will list the movies you have watched and recommend some new movies you may like!</h2>
        <!--<li class="active" style="padding-top: 25px;"><a href="logout.php" style="background-color: #2f2f2f; color: white;">Logout</a></li>--> 
      </ul><br>

    </div>
    <div class="col-sm-9">
      <hr>
	  <h1>My Watchlist</h1>
      <table id="dtBasicExample" class="table table-striped">
        <thead>
          <tr>
        <th>Movie Name</th>
	    <th>Year</th>
		<th>Genre</th>
	    <th>Director</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($result_a)) { ?>
          <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
			<td><?php custom_echo($row[3], 60); ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
	  <h1>My Watched Movies</h1>
      <table id="dtBasicExample2" class="table table-striped">
        <thead>
          <tr>
            <th>Movie Name</th>
			<th>Year</th>
			<th>Director</th>
			<th>My Rating</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_array($result_b)) { ?>
          <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php custom_echo($row[2], 60); ?></td>
			<td><?php echo $row[3]; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
		<h1>Movie Recommendation</h1>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Movie Name</th>
			<th>Year</th>
			<th>Genre</th>
			<th>Director</th>
			<th>Actors</th>
          </tr>	  
        </thead>
        <tbody>
		<?php
		if ($row_cnt >= 4) {
		   $result_c = $conn->query($query3);
		  
		   } else{
		   echo "<h2>Sorry, you must watch more movies to unlock recommendation.</h2>";
		   } 
		?>	
          <?php while ($row = mysqli_fetch_array($result_c)) { ?>
          <tr>
            <td><?php echo $row[0]; ?></td>
            <td><?php echo $row[1]; ?></td>
            <td><?php echo $row[2]; ?></td>
			<td><?php echo $row[3]; ?></td>
			<td><?php custom_echo($row[4], 80); ?></td>

          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>