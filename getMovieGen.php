<?php
	include "settings.php";
	$q = $_GET['q'];
	$query1 = "SELECT m.imdb_id,m.title from movies as m , movies_genre as mg where m.imdb_id=mg.imdb_id and mg.genre_id=?";
	$stmt1 = $conn->prepare($query1);
	$stmt1->bind_param("i",$q);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($imdb_id,$title);
	while ($stmt1->fetch()) {
		$title =  htmlspecialchars($title,ENT_QUOTES);
		echo "<a href='movies.php?imdb_id=$imdb_id' >$title</a><br />";
	}
?>