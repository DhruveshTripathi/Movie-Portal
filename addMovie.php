<?php

	include 'settings.php';

	if(isset($_POST['add-movie'])){
		$plot = htmlspecialchars($_POST['plot']);
		$rated = htmlspecialchars($_POST['rated']);
		$language = htmlspecialchars($_POST['language']);
		$title = htmlspecialchars($_POST['title']);
		$country = htmlspecialchars($_POST['country']);
		$writer = htmlspecialchars($_POST['writer']);
		$year = htmlspecialchars($_POST['year']);
		$metascore = htmlspecialchars($_POST['metascore']);
		$imdb_id = htmlspecialchars($_POST['id']);
		$released = htmlspecialchars($_POST['released']);
		$imdb_rating = htmlspecialchars($_POST['ratings']);
		$awards = htmlspecialchars($_POST['awards']);
		$poster = htmlspecialchars($_POST['poster']);
		$actors = htmlspecialchars($_POST['actors']);
		$runtime = htmlspecialchars($_POST['runtime']);
		$type = htmlspecialchars($_POST['type']);
		$response = htmlspecialchars($_POST['response']);
		$imdb_votes = htmlspecialchars($_POST['votes']);

		$genre = htmlspecialchars($_POST['genre']);
		$director_name = htmlspecialchars($_POST['director']);

		$dir_id=array();
		$genre_id=array();

		$dir_array = explode(",", $director_name); 
		for($j=0;$j<count($dir_array);$j++){
			$query1 = "SELECT director_id from directors where director_name = ?";
			$stmt1 = $conn->prepare($query1); //used to execute the same (or similar) SQL statements repeatedly
			$stmt1->bind_param("s",trim($dir_array[$j])); //Binds variables to a prepared statement as parameters
			$stmt1->execute(); // Executes a prepared Query
			$stmt1->store_result(); //Transfers a result set from a prepared statement
			$stmt1->bind_result($director_id); //Binds variables to a prepared statement for result storage
			if($stmt1->num_rows > 0){ 
				$row1 = $stmt1->fetch();
				$dir_id[] = $director_id;
			}
			else{
				$stmt1 = $conn->prepare("insert into directors values(NULL,?)");
				$stmt1->bind_param("s",trim($dir_array[$j]));
				$stmt1->execute();
				$dir_id[] = $conn->insert_id;
			}
			$stmt1->free_result();	
		}

		$genre_array = explode(",", $genre);
		for($k=0;$k<count($genre_array);$k++){
			$query2 = "SELECT genre_id from genre where genre = ?";
			$stmt2 = $conn->prepare($query2);
			$stmt2->bind_param("s",trim($genre_array[$k]));
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result($gen_id);
			if($stmt2->num_rows > 0){ 
				$row2 = $stmt2->fetch();
				$genre_id[] = $gen_id;
			}
			else{
				$stmt2 = $conn->prepare("insert into genre values(NULL,?)");
				$stmt2->bind_param("s",trim($genre_array[$k]));
				$stmt2->execute();
				$genre_id[] = $conn->insert_id;
			}
			$stmt2->free_result(); //Frees stored result memory for the given statement handle
		}

		$query = mysqli_query($conn,"INSERT into movies(plot,rated,language,title,country,writer,year,metascore,imdb_id,released,imdb_rating,awards,poster,actors,runtime,type,response,imdb_votes) values('$plot','$rated','$language','$title','$country','$writer','$year','$metascore','$imdb_id','$released','$imdb_rating','$awards','$poster','$actors','$runtime','$type','$response','$imdb_votes')");

		if($query){
		foreach ($dir_id as $value) {
			$query3 = "INSERT INTO movies_directors values(?,?)";
			$stmt3 = $conn->prepare($query3);
			$stmt3->bind_param("si",$imdb_id,$value);
			$stmt3->execute();
		}
		foreach ($genre_id as $value) {
			$query3 = "INSERT INTO movies_genre values(?,?)";
			$stmt3 = $conn->prepare($query3);
			$stmt3->bind_param("si",$imdb_id,$value);
			$stmt3->execute();
		}
?>
		<script>alert("Inserted");</script>
<?php
		}
		else{
?>
		<script>alert("Not Inserted");</script>	
<?php
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Add Movies</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
	<center>
		<h1>Movie Portal Website</h1> <br />
		<div id="add-movie">
		<center>
			<form method="post">
				<table align="center" width="40%" border="0">
					<th>Add Movie</th>
					<tr>
						<td><center><input type="text" name="id" placeholder="IMDB ID" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="title" placeholder="Title" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="plot" placeholder="Plot" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="rated" placeholder="Rated" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="language" placeholder="Language" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="country" placeholder="Country" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="writer" placeholder="Writer" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="year" placeholder="Year" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="metascore" placeholder="Metascore" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="released" placeholder="Released" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="ratings" placeholder="Ratings" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="awards" placeholder="Awards" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="poster" placeholder="Poster" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="actors" placeholder="Actors" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="runtime" placeholder="Runtime" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="type" placeholder="Type" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="response" placeholder="Response" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="votes" placeholder="Votes" class="input" required /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="genre" placeholder="Genre" class="input" /></center></td>
					</tr>
					<tr>
						<td><center><input type="text" name="director" placeholder="Director Name" class="input"	 /></center></td>
					</tr>
					<tr>
						<td><center><button type="submit" name="add-movie" class="btn">Add Movie</button></center></td>
					</tr>
				</table>
			</form>
		</center>
	</center>
</body>
</html>