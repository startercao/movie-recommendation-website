<?php
session_start();
	$rating = $_POST['rating'];
	$username = $_SESSION['user'];
	$user_id = $_SESSION['userid'];
	$movieid = $_POST['movieid'];
	$watched_idx = 0;
	
/*	echo $user_id;
	echo $username;
    echo $_SESSION['userid'];
*/  
	if ($rating != NULL){
	    $watched_idx = 1;
	}

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    print "Cannot connect";
	    die("Connection failed");
	}

    if ($rating == NULL){
        $sql_to = "INSERT INTO user_movies VALUES('$username','$movieid','$watched_idx',NULL);";
    }
    else{
	    $sql = "INSERT INTO user_movies VALUES('$username','$movieid','$watched_idx','$rating');";
        $sql2 = "INSERT INTO rating_new(userId, movie_id, rating) VALUES('$user_id','$movieid','$rating');"; // insert into rating_new
    }
	
    $sql_ex = "SELECT * FROM user_movies WHERE Username = '$username' and Movie_Id = '$movieid';";
    $sql_ex2 = "SELECT * FROM rating_new WHERE userId = '$user_id' and movie_id = '$movieid';";

    $result = $conn->query($sql_ex);
    $result2 = $conn->query($sql_ex2);

    if($result->num_rows === 0 && $result2 ->num_rows === 0){
      if ($conn->multi_query($sql) && $conn->multi_query($sql2) ) { 
        Print '<script>alert("Thank you rating this movie!");</script>';
        Print '<script>window.location.assign("search.php");</script>';
					       
        } 
        else if ($conn->multi_query($sql_to) === TRUE){
             Print '<script>alert("This movie is successfully added to your to-watch list!");</script>';
             Print '<script>window.location.assign("search.php");</script>';
        }
        else{
            echo "Error of rating: " . $conn->error;
        }
    } else {
        Print '<script>alert("");</script>';
        Print '<script>window.location.assign("search.php");</script>';
    }

$conn->close();
?>