<?php
	session_start();
	$id = $_POST['id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    print "Can not connect";
	    die("Connection failed");
	}

	$sql = "UPDATE directors SET first_name = '$first_name', last_name = '$last_name' WHERE id = '$id';";

    $sql_ex = "SELECT * FROM directors WHERE id = '$id'";
    $result = $conn->query($sql_ex);
    if($result->num_rows === 0){
            Print '<script>alert("Can not find this id in our database! Please change the id");</script>';
            Print '<script>window.location.assign("update-03-directors.html");</script>';        
    }else{
        if ($conn->multi_query($sql) === TRUE) {
            echo "Record updated successfully";
		    Print '<script>window.location.assign("update-03-01-more.html");</script>'; // redirects to login.php
					       
        } 
        else{
            echo "Error updating record: " . $conn->error;
        }        
    }

    
$conn->close();
?>	