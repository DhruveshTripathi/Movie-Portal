<?php

include 'settings.php';
$query1 = $conn->query("DELETE FROM movies_directors WHERE imdb_id='" . $_GET["imdb_id"] . "'");
$query2 = $conn->query("DELETE FROM movies_genre WHERE imdb_id='" . $_GET["imdb_id"] . "'");
$query3 = $conn->query("DELETE FROM movies WHERE imdb_id='" . $_GET["imdb_id"] . "'");
header("Location:listMovie.php");

?>