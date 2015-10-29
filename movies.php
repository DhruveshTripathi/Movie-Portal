<?php
	include 'settings.php';

	$movie_id = $_GET['imdb_id'];
	$query = "SELECT * FROM movies WHERE imdb_id = ?";
	$stmt1 = $conn->prepare($query);
	$stmt1->bind_param("s",$movie_id);
	$stmt1->execute();
	$stmt1->store_result();
	$stmt1->bind_result($plot,
		$rated,
		$language,
		$title,
		$country,
		$writer,
		$year,
		$metascore,
		$imdb_id,
		$released,
		$imdb_rating,
		$awards,
		$poster,
		$actors,
		$runtime,
		$type,
		$response,
		$imdb_votes);
	while($stmt1->fetch()){
		$plot =  htmlspecialchars($plot,ENT_QUOTES);
		$rated =  htmlspecialchars($rated,ENT_QUOTES);
		$language =  htmlspecialchars($language,ENT_QUOTES);
		$title =  htmlspecialchars($title,ENT_QUOTES);
		$country =  htmlspecialchars($country,ENT_QUOTES);
		$writer =  htmlspecialchars($writer,ENT_QUOTES);
		$year =  htmlspecialchars($year,ENT_QUOTES);
		$metascore =  htmlspecialchars($metascore,ENT_QUOTES);
		$imdb_id =  htmlspecialchars($imdb_id,ENT_QUOTES);
		$released =  htmlspecialchars($released,ENT_QUOTES);
		$imdb_rating =  htmlspecialchars($imdb_rating,ENT_QUOTES);
		$awards =  htmlspecialchars($awards,ENT_QUOTES);
		$poster =  htmlspecialchars($poster,ENT_QUOTES);
		$actors =  htmlspecialchars($actors,ENT_QUOTES);
		$runtime =  htmlspecialchars($runtime,ENT_QUOTES);
		$type =  htmlspecialchars($type,ENT_QUOTES);
		$response =  htmlspecialchars($response,ENT_QUOTES);
		$imdb_votes =  htmlspecialchars($imdb_votes,ENT_QUOTES);
	}
	$query1 = "SELECT dir.director_name from directors as dir,movies_directors as md where dir.director_id=md.director_id AND md.imdb_id=?";
	$stmt2 = $conn->prepare($query1);
	$stmt2->bind_param("s",$movie_id);
	$stmt2->execute();
	$stmt2->store_result();
	$stmt2->bind_result($director_name);

	$query2 = "SELECT gen.genre from genre as gen,movies_genre as mg where gen.genre_id=mg.genre_id AND mg.imdb_id=?";
	$stmt3 = $conn->prepare($query2);
	$stmt3->bind_param("s",$movie_id);
	$stmt3->execute();
	$stmt3->store_result();
	$stmt3->bind_result($genre);	
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=windows-1252">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="movie-div" align="center">
			<table cellspacing="3" cellpadding="5">
				<tr>
					<td colspan="2">
						<center><img src="<?php echo "$poster"; ?>"></center>
					</td>
				</tr>
				<tr>
					<td><label>Title:</label></td>
					<td><?php echo "$title"; ?></td>
				</tr>
				<tr>
					<td><label>Plot:</label></td>
					<td><?php echo "$plot"; ?></td>
				</tr>
				<tr>
					<td><label>Genre:</label></td>
					<td><?php while($stmt3->fetch()){
								$genre =  htmlspecialchars($genre,ENT_QUOTES);
								echo "$genre, "; 
							}?></td>
				</tr>
				<tr>
					<td><label>Directors:</label></td>
					<td><?php while($stmt2->fetch()){
								$director_name =  htmlspecialchars($director_name,ENT_QUOTES);
								echo "$director_name, ";
							} ?></td>
				</tr>
				<tr>
					<td><label>Actors:</label></td>
					<td><?php echo "$actors"; ?></td>
				</tr>
				<tr>
					<td><label>Writer:</label></td>
					<td><?php echo "$writer"; ?></td>
				</tr>
				<tr>
					<td><label>Language:</label></td>
					<td><?php echo "$language"; ?></td>
				</tr>
				<tr>
					<td><label>Runtime:</label></td>
					<td><?php echo "$runtime"; ?></td>
				</tr>
				<tr>
					<td><label>Awards:</label></td>
					<td><?php echo "$awards"; ?></td>
				</tr>
				<tr>
					<td><label>Rated:</label></td>
					<td><?php echo "$rated"; ?></td>
				</tr>
				<tr>
					<td><label>Country:</label></td>
					<td><?php echo "$country"; ?></td>
				</tr>
				<tr>
					<td><label>Type:</label></td>
					<td><?php echo "$type"; ?></td>
				</tr>
				<tr>
					<td><label>Released:</label></td>
					<td><?php echo "$released"; ?></td>
				</tr>
				<tr>
					<td><label>Year:</label></td>
					<td><?php echo "$year"; ?></td>
				</tr>
				<tr>
					<td><label>Metascore:</label></td>
					<td><?php echo "$metascore"; ?></td>
				</tr>
				<tr>
					<td><label>IMDB ID:</label></td>
					<td><?php echo "$imdb_id"; ?></td>
				</tr>
				<tr>
					<td><label>IMDB Rating:</label></td>
					<td><?php echo "$imdb_rating"; ?></td>
				</tr>
				<tr>
					<td><label>IMDB Votes:</label></td>
					<td><?php echo "$imdb_votes"; ?></td>
				</tr>
			</table>
		</div>
	</body>
</html>