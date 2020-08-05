<?php
	session_start();
	$id = $_POST['id'];
	$name = $_POST['name'];
	$directors = $_POST['directors'];
	
	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    print "Can not connect";
	    die("Connection failed");
	}

	$sql = "DELETE FROM movies WHERE id = '$id' OR name = '$name';";
	$sql .="DELETE FROM movies_directors WHERE movie_id = '$id';";
	$sql .="DELETE FROM movies_genres WHERE movie_id = '$id'";

    $sql_ex = "SELECT * FROM movies WHERE id = '$id'";
    $result = $conn->query($sql_ex);
    if($result->num_rows === 0){
        Print '<script>alert("Can not find this id in our database! Please change the id");</script>';
        Print '<script>window.location.assign("delete-01-movies.html");</script>';        
    }else{
        if ($conn->multi_query($sql) === TRUE) {
            echo "Record updated successfully";
		    Print '<script>window.location.assign("delete-01-01-more.html");</script>'; // redirects to login.php
					       
        } 
        else{
            echo "Error deleting record: " . $conn->error;
        }
            
    }
    

    
$conn->close();
?>	