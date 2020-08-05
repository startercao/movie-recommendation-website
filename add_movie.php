<?php
	session_start();
	$id = $_POST['id'];
	$name = $_POST['name'];
	$year = $_POST['year'];
	$directors = $_POST['directors'];
	$genre = $_POST['genre'];
	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    print "Can not connect";
	    die("Connection failed");
	}

	$sql = "INSERT INTO movies VALUES('$id','$name','$year',1);";
	$sql .="INSERT INTO movies_genres (movie_id, genre) VALUES('$id','$genre');";
	$sql .="INSERT INTO movies_directors (director_id, movie_id) VALUES('$directors','$id')";
    
    $sql_ex = "SELECT * FROM movies WHERE id = '$id'";
    $result = $conn->query($sql_ex);
    
    if($result->num_rows === 0){
        if ($conn->multi_query($sql) === TRUE) {
        echo "Record updated successfully";
 		Print '<script>window.location.assign("add-01-01-more.html");</script>'; // redirects to login.php
					       
        } 
        else{
            echo "Error updating record: " . $conn->error;
        }
    } else {
        Print '<script>alert("Already have this id in our database! Please change an id");</script>';
        Print '<script>window.location.assign("add-01-movies.html");</script>';
    }



$conn->close();
?>	