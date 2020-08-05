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
		while($row = $result->fetch_assoc()) //display all rows from query
		{
			$table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
			$table_password = $row['password']; // the first password row is passed on to $table_users, and so on until the query is finished
			$table_admin= $row['admin'];
            $_SESSION['userid'] = $row['id'];
		}
		if(($username == $table_users) && ($password == $table_password)) // checks if there are any matching fields
		{
				if($password == $table_password)
				{
					$_SESSION['user'] = $username; //set the username in a session. This serves as a global variable
					if($table_admin == 0)
					{
			            Print '<script>alert("Incorrect Username or Password!");</script>'; //Prompts the user
			            Print '<script>window.location.assign("index.html");</script>'; // redirects to login.php
					}
					else
					{
					    header("location: admin-00.html"); // redirects the admin to the authenticated home page
					}
					
				}
				
		}
		else
		{
			Print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
			Print '<script>window.location.assign("index.html");</script>'; // redirects to login.php
		}

	}
	else
	{
		Print '<script>alert("Incorrect Username!");</script>'; //Prompts the user
		Print '<script>window.location.assign("index.html");</script>'; // redirects to login.php
	}
?>