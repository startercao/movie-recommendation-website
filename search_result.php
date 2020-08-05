<?php
session_start();
//require_once 'checklogin_user.php';
//require_once 'auto_check.php';
//echo "The current username " . $_SESSION['user'] . ".<br>";

if(!isset($_SESSION['user'])){
    echo 'Please log in first!';
   header("location: index.html");
}
?>

<html>
<head>
    <title>Search Results</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
	body {
	  font-family: Arial, Helvetica, sans-serif;
	  font-size: 20px;
	}

	#myBtn {
	  display: none;
	  position: fixed;
	  bottom: 20px;
	  left: 30px;
	  z-index: 99;
	  font-size: 18px;
	  border: none;
	  outline: none;
	  background-color: red;
	  color: white;
	  cursor: pointer;
	  padding: 15px;
	  border-radius: 4px;
	}

	#myBtn:hover {
	  background-color: #555;
	}
	</style>
    <style type="text/css">
        body {
          height: 100%;
	      font-family: Ubuntu-Regular, sans-serif;
        }
        .container {
          width: 100%;  
          min-height: 100vh;
          display: -webkit-box;
          display: -webkit-flex;
          display: -moz-box;
          display: -ms-flexbox;
          display: flex;
          flex-wrap: wrap;
          justify-content: center;
          align-items: center;
          padding: 15px;
        
          background-repeat: no-repeat;
          background-position: center;
          background-size: cover;
          position: relative;
          z-index: 1;  
         
        }
        table {
          text-align:center; 
          margin-left:auto; 
          margin-right:auto; 
          width: 1200px;
          border-collapse: collapse;
          overflow: hidden;
          box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        th,
        
        td {
          padding: 15px;
          background-color: rgba(255, 255, 255, 0.2);
          color: #fff;
          position:center;
        }
        th {
          text-align: center;
        }
        thead th {
          background-color: #55608f;
        }
        tbody tr:hover {
          background-color: rgba(255, 255, 255, 0.3);
        }
        tbody td {
          position: relative;
        }
        tbody td:hover:before {
          content: "";
          position: absolute;
          left: 0;
          right: 0;
          top: -9999px;
          bottom: -9999px;
          background-color: rgba(0, 0, 0, 0.5);
          z-index: -1;
        }
    </style>
</head>

<body>
<button onclick="backFunction()" id="myBtn" title="Go Back">Back</button>

<script>
//Get the button
var mybutton = document.getElementById("myBtn");
mybutton.style.display = "block";

// When the user clicks on the button, scroll to the top of the document
function backFunction() {
  location.href = "search.php";
}
</script>

<div class="container" style="background-image: url('images/pi.jpg');background-attachment: fixed">
<?php
	$search = strtolower($_POST['search']);
    $button=$_POST[submitbutton];

	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    die("Connection failed");
	    echo 'fail to connect to database';
	}
    if($button == 'actors')
    {
        $sql_a="SELECT * FROM (actors LEFT JOIN roles ON actors.id=roles.actor_id) LEFT JOIN movies ON movies.id=roles.movie_id WHERE lower(actors.first_name) like '%$search%' or lower(actors.last_name) like '%$search%' order by first_name, last_name"; 
        $result_a = $conn->query($sql_a);// query user info
        
        if($result_a->num_rows > 0) //
	    { 
    	   echo "<table>";
    	   echo "<thead>";
    	   echo "<tr><th>First Name</th><th>Last Name</th><th>Gender</th><th>Movie Name</th><th>Year</th><th>Role Name</th><th>Action</th></tr>\n";
    	   echo "</thead>";
           echo "<tbody>";
    		while($row = $result_a->fetch_assoc()) //display all rows from query
    		{   
    		    
    			echo "<tr><td>". $row["first_name"]."</td><td>".$row["last_name"]."</td><td>". $row["gender"]."</td><td>". $row["name"]."</td><td>".$row["year"]."</td><td>".$row["role"] ."</td>";
    			 
    			 echo "<form method='post' action='rating_submit.php'>";
    			 echo "<td><input class=\"input100\" type=\"text\" name=\"rating\" placeholder=\"Rate this movie\"><button class=\"login100-form-btn\" type=\"submit\" >Watched and Rate</button><button class=\"login100-form-btn\" type=\"submit\">To watch</button></td></tr>";
                 echo "<input type =\"hidden\" name=\"movieid\" value=".$row["id"].">";
                 echo "</form>";
       
    		}
    		echo "</tbody>";
    		echo "</table>"; 
	    }
	    else{
       
    		Print '<script>alert("No record in our database!");</script>'; //Prompts the user
    		Print '<script>window.location.assign("search.php");</script>'; // redirects to search.html
	       
    	}

    }
    elseif($button == 'directors')
    {
        $sql_d="SELECT * FROM (directors LEFT JOIN movies_directors ON directors.id=movies_directors.director_id) LEFT JOIN movies ON movies.id=movies_directors.movie_id WHERE lower(directors.first_name) like '%$search%' or lower(directors.last_name) like '%$search%' order by first_name, last_name"; 
	    $result_d = $conn->query($sql_d);
	    
	    if($result_d->num_rows > 0) //
    	{  echo "<table>";
    	   echo "<thead>";
    	   echo "<tr><th>First Name</th><th>Last Name</th><th>Movie Name</th><th>Year</th><th>Action</th></tr>\n";
    	   echo "</thead>";
           echo "<tbody>";
    		while($row = $result_d->fetch_assoc()) //display all rows from query
    		{
    			echo "<tr><td>".$row["first_name"]."</td><td>".$row["last_name"]."</td><td>".$row["name"]."</td><td>".$row["year"]."</td>";
    			echo "<form method='post' action='rating_submit.php'>";
    			 
    			 echo "<td><input class=\"input100\" type=\"text\" name=\"rating\" placeholder=\"Rate this movie\"><button class=\"login100-form-btn\" type=\"submit\" >Watched and Rate</button><button class=\"login100-form-btn\" type=\"submit\">To watch</button></td></tr>";
                 echo "<input type =\"hidden\" name=\"movieid\" value=".$row["id"].">";
                 echo "</form>";
       
    		}	
    		echo "</tbody>";
    		echo "</table>"; 
    	}
    	else{
       
    		Print '<script>alert("No record in our database!");</script>'; //Prompts the user
    		Print '<script>window.location.assign("search.php");</script>'; // redirects to search.html
	       
    	}
    }
	elseif($button =='movies')
	{
	    $sql_m="SELECT movies.id, name, year,group_concat(DISTINCT genre) as genre, group_concat(distinct concat(' ',first_name,' ',last_name)) AS name_p FROM (movies LEFT JOIN movies_genres ON movies.id=movies_genres.movie_id) LEFT JOIN (directors RIGHT JOIN movies_directors ON directors.id=movies_directors.director_id) ON movies.id=movies_directors.movie_id WHERE lower(movies.name) like '%$search%' GROUP BY name, year order by year"; 
    	$result_m = $conn->query($sql_m);
    	
    	if($result_m->num_rows > 0) //
    	{   echo "<table>";
    	   echo "<thead>";
    	   echo "<tr><th>Movie Name</th><th>Year</th><th>Genre</th><th>Director Name</th><th>Action</th></tr>\n";
    	   echo "</thead>";
           echo "<tbody>";
    		while($row = $result_m->fetch_assoc()) //display all rows from query
    		{
    			echo "<tr><td>".$row["name"]."</td><td>".$row["year"]."</td><td>".$row["genre"]."</td><td>".$row["name_p"]."</td>";
    			
    			echo "<form method='post' action='rating_submit.php'>";
    			echo "<td><input class=\"input100\" type=\"text\" name=\"rating\" placeholder=\"Rate this movie\"><button class=\"login100-form-btn\" type=\"submit\" >Watched and Rate</button><button class=\"login100-form-btn\" type=\"submit\">To watch</button></td></tr>";
                 echo "<input type =\"hidden\" name=\"movieid\" value=".$row["id"].">";
                 echo "</form>";
    			
    		}
    		echo "</tbody>";
    		echo "</table>"; 
    	}
    	else{
       
    		Print '<script>alert("No record in our database!");</script>'; //Prompts the user
    		Print '<script>window.location.assign("search.php");</script>'; // redirects to search.html
	       
    	}
	}
	elseif($button='genre')
	{
	    $sql_g="SELECT movies.id, name, year, genre,group_concat(distinct concat(' ',first_name,' ',last_name)) AS name_p FROM (movies RIGHT JOIN movies_genres ON movies.id=movies_genres.movie_id) LEFT JOIN (directors RIGHT JOIN movies_directors ON directors.id=movies_directors.director_id) ON movies.id=movies_directors.movie_id WHERE lower(genre) like '%$search%' GROUP BY name, year, genre order by year"; 
    	$result_g = $conn->query($sql_g);// query user info
    	
    	if($result_g->num_rows > 0) //
    	{  echo "<table>";
    	   echo "<thead>";
    	   echo "<tr><th>Genre</th><th>Movie Name</th><th>Year</th><th>Director Name</th><th>Action</th></tr>\n";
    	   echo "</thead>";
           echo "<tbody>";
    		while($row = $result_g->fetch_assoc()) //display all rows from query
    		{
    			echo "<tr><td>".$row["genre"]."</td><td>".$row["name"]."</td><td>".$row["year"]."</td><td>".$row["name_p"]."</td>";
    			echo "<form method='post' action='rating_submit.php'>";
    			echo "<td><input class=\"input100\" type=\"text\" name=\"rating\" placeholder=\"Rate this movie\"><button class=\"login100-form-btn\" type=\"submit\" >Watched and Rate</button><button class=\"login100-form-btn\" type=\"submit\">To watch</button></td></tr>";
                 echo "<input type =\"hidden\" name=\"movieid\" value=".$row["id"].">";
                echo "</form>";
    		}	
    		echo "</tbody>";
    		echo "</table>"; 
    	}
    	else{
       
    		Print '<script>alert("No record in our database!");</script>'; //Prompts the user
    		Print '<script>window.location.assign("search.php");</script>'; // redirects to search.html
	       
    	}

	}

	
?>
        
        </div>

    </body>
</html>	