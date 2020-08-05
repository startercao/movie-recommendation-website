<?php
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    die("Connection failed");
	}

	$sql="SELECT * from user_info WHERE username='$username'"; //Query the users table if there are matching rows equal to $username
	$result = $conn->query($sql);// query user info
	$table_users = "";
	$table_password = "";
	if($result->num_rows > 0) //
	{   
		$row = $result->fetch_assoc();
		
		$table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
		$table_password = $row['password']; // the first password row is passed on to $table_users, and so on until the query is finished

		
		if(($username == $table_users) ) // checks if there are any matching fields
		{   
		    if(($password == $table_password))
		    {
        	    $sql_d="DELETE FROM `user_info` WHERE username='$username'";
        	    $result_d = $conn->query($sql_d);
        	    header("location: delete-04-01-more.html");
		    }
		    else
		    {
		        Print '<script>alert("Incorrect Password!");</script>';
		        Print '<script>window.location.assign("delete-04-admin.html");</script>';
		    }
				
				
		}

	}
	else
	{
		Print '<script>alert("No record in our database!");</script>'; //Prompts the user
		Print '<script>window.location.assign("delete-04-admin.html");</script>'; 
	}
?>