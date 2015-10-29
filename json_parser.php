<?php
	include 'settings.php';
	$file = "./db.json";

	$json = file_get_contents($file, FILE_USE_INCLUDE_PATH);
	
	$content = json_decode($json); //Converts json data into $arrayName = array('' => , );
	$dir_id=array(); 
	$genre_id=array();
	for($i = 0; $i < count($content); $i++){
		unset($dir_id); //Un-initialize array
		unset($genre_id);
		$dir_id=array();
		$genre_id=array();
		$movie = $content[$i];
		$dir_array = explode(",", $movie->director); 
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
		$genre_array = explode(",", $movie->genre);
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
		$query3 = "INSERT INTO movies values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt3 = $conn->prepare($query3);
		$stmt3->bind_param("sssssssissdsssssii",$movie->plot,$movie->rated,$movie->language,$movie->title,$movie->country,$movie->writer,$movie->year,$movie->metascore,$movie->imdb_id,$movie->released,$movie->imdb_rating,$movie->awards,$movie->poster,$movie->actors,$movie->runtime,$movie->type,$movie->response,$movie->imdb_votes);
		$stmt3->execute();	
		foreach ($dir_id as $value) {
			$query3 = "INSERT INTO movies_directors values(?,?)";
			$stmt3 = $conn->prepare($query3);
			$stmt3->bind_param("si",$movie->imdb_id,$value);
			$stmt3->execute();
		}
		foreach ($genre_id as $value) {
			$query3 = "INSERT INTO movies_genre values(?,?)";
			$stmt3 = $conn->prepare($query3);
			$stmt3->bind_param("si",$movie->imdb_id,$value);
			$stmt3->execute();
		}
	}