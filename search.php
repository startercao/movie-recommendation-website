<?php
session_start();
if(!isset($_SESSION['user'])){
   header("location: index.html");
}

ob_start();

$mysql_host = 'localhost:3306';
$mysql_user = 'cinemaparadiso_qc13';
$mysql_pass = 'cinemaparadiso_qc13';
$mysql_db = 'cinemaparadiso_IMDB';

$dbconnect = mysqli_connect($mysql_host, $mysql_user, $mysql_pass, $mysql_db) or die("Connection failed");
 
    $sql = "SELECT * FROM movies ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($dbconnect, $sql)or die("wtf");
    $row = mysqli_fetch_array($result);
    $_SESSION['rowT'] = $row[0];
    $_SESSION['rowR'] = $row[1];
    $_SESSION['rowP'] = $row[2];
    $_SESSION['rowS'] = $row[3];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Search</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link rel="stylesheet" href="css/search.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" href="css/button.css">
	<link rel="stylesheet" href="css/time-list.css">

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/p2.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Welcome to Cinema Paradiso
				</span>

                <form action='search_result.php' method='post'>
			<div class="searchbar">
				<div class="searchbox">
				<input type="text" class="searchbox__input" name="search" placeholder="Search..." >
					<svg class="searchbox__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.966 56.966">
					<path style="fill:#db075c" d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17s-17-7.626-17-17S14.61,6,23.984,6z" />
					</svg>
				</div>
			</div>
    		
    				<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type='submit' name='submitbutton' value='movies'><a style="color:#FFFFFF;">
							Movies
						</button>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="login100-form-btn" type='submit' name='submitbutton' value='actors'><a style="color:#FFFFFF;">
							Actors
						</button>
					</div>
					
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type='submit' name='submitbutton' value='directors'><a name='directors' style="color:#FFFFFF;">
							Directors
						</button>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="login100-form-btn" type='submit' name='submitbutton' value='genres'><a name='genres' style="color:#FFFFFF;">
							Genres
						</button>
					</div>  
					
									
					
                </form>
				    <div class="container-login100-form-btn m-t-32">
						
						<button class="login100-form-btn" ><a href="mode_select.php" style="color:#FFFFFF;">
							Back to my personal page
						</button>
					</div>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>