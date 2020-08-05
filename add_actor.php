<?php
	session_start();
	$id = $_POST['id'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$gender = $_POST['gender'];

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    print "Can not connect";
	    die("Connection failed");
	}

	$sql = "INSERT INTO actors VALUES ('$id','$first_name','$last_name','$gender')";

    $sql_ex = "SELECT * FROM actors WHERE id = '$id'";
    $result = $conn->query($sql_ex);
    if($result->num_rows === 0){
        if ($conn->multi_query($sql) === TRUE) {
            echo "Record added successfully";
		    Print '<script>window.location.assign("add-02-01-more.html");</script>'; // redirects to login.php
        } 
        else{
            echo "Error updating record: " . $conn->error;
        }        
        
    }else{
        Print '<script>alert("Already have this id in our database! Please change an id");</script>';
        Print '<script>window.location.assign("add-02-actors.html");</script>';        
    }    
    

    
$conn->close();
?>	