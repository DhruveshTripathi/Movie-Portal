<?php
	include "settings.php";
	$q = $_GET['q'];
	$query1 = "SELECT imdb_id,year,title from movies where year=?";
	$stmt1 = $conn->prepare($query1);
	$stmt1->bind_param("i",$q);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($imdb_id,$year,$title);
	while ($stmt1->fetch()) {
		$title =  htmlspecialchars($title,ENT_QUOTES);
		echo "<a href='movies.php?imdb_id=$imdb_id'>$title</a><br />";
	}
?>