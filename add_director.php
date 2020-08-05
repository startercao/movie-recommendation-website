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

	$sql = "INSERT INTO directors VALUES('$id','$first_name','$last_name' );";
    $sql_ex = "SELECT * FROM directors WHERE id = '$id'";
    $result = $conn->query($sql_ex);
    if($result->num_rows === 0){
        if ($conn->multi_query($sql) === TRUE) {
            echo "Record updated successfully";
		    Print '<script>window.location.assign("add-03-01-more.html");</script>'; // redirects to login.php
			    
        } 
        else{
            echo "Error updating record: " . $conn->error;
        }        
    } else{
        Print '<script>alert("Already have this id in our database! Please change an id");</script>';
        Print '<script>window.location.assign("add-03-directors.html");</script>';        
    }
    

    
$conn->close();
?>	