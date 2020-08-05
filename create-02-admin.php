<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create-admin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/ab.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Create a new Admin?
				</span>
                <form class="login100-form validate-form p-b-33 p-t-5" action='create-02-admin.php' method='post'>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="User name">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>
                    
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password_r" placeholder="Confirm Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit"><a style="color:#FFFFFF;">
							Submit 
						</button>
					</div>
					</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
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

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_r = $_POST['password_r'];
    $bool = true;
    if($password_r != $password )
    {
		Print '<script>alert("Password should be the same");</script>'; //Prompts the user
		Print '<script>window.location.assign("create-02-admin.php");</script>'; // redirects to login.php
	}

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$sql="Select * from user_info";
	$result = $conn->query($sql);// query user info
	if ($result->num_rows > 0){
	    while($row = $result->fetch_assoc()){
	        $table_users = $row['username']; // the first username row is passed on to $table_users, and so on until the query is finished
		    if($username == $table_users) // checks if there are any matching fields
	    	{
			    $bool = false; // sets bool to false
			    Print '<script>alert("Username has been taken!");</script>'; //Prompts the user
			    Print '<script>window.location.assign("create-02-admin.php");</script>'; // redirects to register.php
		    }
	    }
	} 
	

	if($bool) // checks if bool is true
	{
		$conn->query("INSERT INTO user_info (username, password, admin) VALUES ('$username','$password',1)"); //Inserts the value to table users
		Print '<script>alert("Successfully Registered!");</script>'; // Prompts the user
		Print '<script>window.location.assign("create-01-more.html");</script>'; // redirects to register.php
	}

}
?>