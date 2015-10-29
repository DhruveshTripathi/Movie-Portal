<?php
	include "settings.php";
	$q = $_GET['q'];
	$query1 = "SELECT imdb_id,year,title,imdb_rating from movies where year=$q";
	$result = mysqli_query($conn,$query1);
	$yearMovie=array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        //print_r($row);
	        $yearMovie[]=$row;
	    }
	}

	$query1 = "select b.genre_id,b.genre,AVG(a.imdb_rating) as avg FROM genre b, movies a, movies_genre c WHERE a.imdb_id=c.imdb_id AND b.genre_id=c.genre_id AND a.year=$q group by b.genre_id";
	$result = mysqli_query($conn,$query1);
	$genreAvg=array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        //print_r($row);
	        $genreAvg[]=$row;
	    }
	}

	$data['yearMovie']=$yearMovie;
	$data['genreAvg']=$genreAvg;
	echo json_encode($data);


	// $stmt1 = $conn->prepare($query1);
	// $stmt1->bind_param("i",$q);
	// $stmt1->execute();
	// $stmt1->store_result();
	// $stmt1->bind_result($imdb_id,$year,$title);
	// while ($stmt1->fetch()) {
	// 	$title =  htmlspecialchars($title,ENT_QUOTES);
	// 	echo "<a href='movies.php?imdb_id=$imdb_id'>$title</a><br />";
	// }
?>