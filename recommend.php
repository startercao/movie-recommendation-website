<?php
	session_start();
	
	if(!isset($_SESSION['user'])){
        echo 'Please log in first!';
        header("location: index.html");
    }
    
// query recommending database	
	$conn= mysqli_connect("localhost:3306", "cinemaparadiso_qc13","cinemaparadiso_qc13","cinemaparadiso_IMDB"); //Connect to server
	if (!$conn) {
	    die("Connection failed");
	    echo 'fail to connect to database';
	}

	$sql="SELECT * FROM rating_new";     	
	$result = $conn->query($sql);
	
	
// reading data to user_movie
	$trainset[][]=array();
	$movie_user[][]=array();
	while($row = $result->fetch_assoc())
	{
	    $results[] = array('userId'=>$row['userId'],'movie_id'=>$row['movie_id'],'rating'=>(float)$row['rating']);
	   // $trainset[] = array($row['userId']=>array($row['movie_id']=>$row['rating']));
	   
	   $trainset[$row['userId']][$row['movie_id']] = (float)$row['rating'];
	   $movie_user[$row['movie_id']][$row['userId']]=(float)$row['rating'];
	}

// compute similarity matrix
    $user=array_column($results,'userId');

    
 	$user_id  = $_SESSION['userid']; // which user you want to recommend
    //$user_id = 618;
 	
    foreach ($movie_user as $movie => $rated){
        if (in_array($user_id,array_keys($rated)) && count(array_keys($rated)) > 1){
            for($i=0;$i<count(array_keys($rated));$i++){
                if($i != $user_id){
                    $sim_matrix[array_keys($rated)[$i]] = 0;
                }
            }
        }
        
    }
    // var_dump($sim_matrix);
    foreach ($movie_user as $movie => $rated){
        if (in_array($user_id,array_keys($rated)) && count(array_keys($rated)) > 1){
            for($i=0;$i<count(array_keys($rated));$i++){
                if($i != $user_id){
                    $reward = 5-abs($trainset[array_keys($rated)[$i]][$movie]-$trainset[$user_id][$movie]);
                    $reward = $reward / (sqrt(count($trainset[array_keys($rated)[$i]])) * sqrt(count($trainset[$user_id])));
                    $sim_matrix[array_keys($rated)[$i]] += $reward;
                }
            }
        }
    }
    
    // var_dump($sim_matrix);
// recommend movies: find k similar users and generate n recommendations
    // $user_id  = '3'; // which user you want to recommend
    $K = 20; // similar users
    $N = 5; // recommended movies
    $watched_movies =  array_keys($trainset[$user_id]);

    $user_sim = $sim_matrix;
    arsort($user_sim);
    $user_sim_top = array(); // top K similar users
    $count = 0;
    foreach ($user_sim as $key => $value){
        if ($count < $K && $value>0) {
            $user_sim_top[$key] = $value;
            $count += 1;            
        }
    }
    
    $rec_movie = array();
    foreach ($user_sim_top as $user => $rank){
        foreach ($trainset[$user] as $movie => $rating){
            if (!in_array($movie, $watched_movies)){    //if the movies of similar users not in watched_movies
                if($rating>=3){
                    
                    if(!array_key_exists($movie, $rec_movie)){
                    $rec_movie[$movie] = 1;
                    } else{
                    $rec_movie[$movie] += 1;
                    } 
                    
                }
                
            }
        }
    }
    // var_dump($rec_movie);

    $movie_ids = array();
    arsort($rec_movie);
    
	$count = 0;
foreach ($rec_movie as $movie => $num){
        if ($count < $N) {
            $movie_ids[$count] = $movie;
            $count += 1;            
        }
    }    
    $movie_ids = implode( ", ", $movie_ids);
	
?>