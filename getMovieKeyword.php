<?php
	include "settings.php";
	$title = $_GET['title'];
	$plot = $_GET['plot'];
	$director = $_GET['director'];
	$query1 = "SELECT DISTINCT m.imdb_id,m.title from movies as m, movies_directors as md where m.imdb_id=md.imdb_id ";
	if(isset($_GET['title']) && $_GET['title'] != ""){
		$query1.="AND m.title like '%$title%' ";
	}
	if (isset($_GET['plot']) && $_GET['plot'] != "") {
		$query1.="AND m.plot like '%$plot%' ";
	}
	if (isset($_GET['director']) && $_GET['director'] != "") {
		$query1.="AND md.director_id in (SELECT director_id from directors where director_name like '%$director%')";
	}
	$stmt1 = $conn->prepare($query1);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($imdb_id,$title);
	while ($stmt1->fetch()) {
		$title =  htmlspecialchars($title,ENT_QUOTES);
		echo "<a href='movies.php?imdb_id=$imdb_id' >$title</a><br />";
	}

?>