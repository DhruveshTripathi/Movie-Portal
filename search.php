<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title>Search</title>
	<link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
	<script type="text/javascript">
	function showKeyword(){
	document.getElementById("search-result").innerHTML = "";
	document.getElementById('key-div').style.display = 'block';
	document.getElementById('gen-div').style.display = 'none';
	document.getElementById('year-div').style.display = 'none';
	}
	function showGenre(){
	document.getElementById("search-result").innerHTML = "";
	document.getElementById('key-div').style.display = 'none';
	document.getElementById('gen-div').style.display = 'block';
	document.getElementById('year-div').style.display = 'none';
	}
	function showYear(){
	document.getElementById("search-result").innerHTML = "";
	document.getElementById('key-div').style.display = 'none';
	document.getElementById('gen-div').style.display = 'none';
	document.getElementById('year-div').style.display = 'block';
	}
	function showMoviesGen(str){
		if(str==""){
			document.getElementById("search-result").innerHTML="";
			return;
		}
		var xmlhttp;
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		else{
			xmlhttp = new ActiveXObject();
		}
		xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("search-result").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getMovieGen.php?q="+str,true);
        xmlhttp.send();
	}
	function showMoviesYear(str){
		//alert("hi");
		if(str==""){
			document.getElementById("search-result").innerHTML="";
			return;
		}
		var xmlhttp;
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		else{
			xmlhttp = new ActiveXObject();
		}
		xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            	//alert(xmlhttp.responseText);
                document.getElementById("search-result").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","getMovieYear.php?q="+str,true);
        xmlhttp.send();
	}
	function showMoviesKeyword(){
		var title = document.getElementById("title").value;
		var plot = document.getElementById("plot").value;
		var director = document.getElementById("director").value;
		var xmlhttp;
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}
		else{
			xmlhttp = new ActiveXObject();
		}
		xmlhttp.onreadystatechange = function(){
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("search-result").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","getMovieKeyword.php?title="+title+"&plot="+plot+"&director="+director,true);
		xmlhttp.send();
	}
	</script>
	<div id="logout">
	<table align="right" border="1">
		<tr>
			<td><center><a href="graphs.php">Show Graphs</a></center></td>
			<td><center><a href="logout.php?logout">Logout</a></center></td>
		</tr>
	</table>
	</div><br />
	<center>
	<strong>Search Movie By : </strong><br /><br /> 
	</center>
	<center>
	<input type="button" name="answer" onclick="showKeyword('key-div')" value="Keywords" class="btn"></input> or 
	<input type="button" name="answer" onclick="showGenre('gen-div')" value="Genre" class="btn"></input> or
	<input type="button" name="answer" onclick="showYear('year-div')" value="Year" class="btn"></input>
	</center>
	<center>
	<div id="key-div" style="display:none">
		<label for="title">Title : </label>
		<input type="text" name = "title" id="title" class="input"> 

		<label for="title">Plot : </label>
		<input type="text" name = "plot" id="plot" class="input"> 

		<label for="title">Director : </label>
		<input type="text" name = "director" id="director" class="input">
		<input type="button" name = "search1" value="Search" onclick="showMoviesKeyword()" class="btn">
	</div>
	</center>
	<center>
	<div id="gen-div" style="display:none">
	<label for="genre">Select Genre : </label>
	<?php
		include "settings.php";
		$query1 = "SELECT * from genre;"; 
		$stmt1 = $conn->prepare($query1);
		$stmt1->execute();
		$stmt1->store_result();
		$stmt1->bind_result($id,$year);
		echo '<select name="genre" onchange="showMoviesGen(this.value)" class="input" value="genre_id">';
		while($stmt1->fetch()){
			echo '<option value="'.$id.'">'.$year.'</option>';
		}
		echo'</select>';  
	?>
	</div>
	</center>
	<center>
	<div id="year-div" style="display:none">
	<label for="year">Select Year : </label>
	<?php
		include "settings.php";
		$query2 = "SELECT DISTINCT imdb_id,year from movies;"; 
		$stmt2 = $conn->prepare($query2);
		$stmt2->execute();
		$stmt2->store_result();
		$stmt2->bind_result($id,$year);
		echo '<select name="year" onchange="showMoviesYear(this.value)" class="input" value="year">';
		while($stmt2->fetch()){
			echo '<option value="'.$year.'">'.$year.'</option>';
		}
		echo'</select>';  
	?>
	</div>
	</center>
	<center>
	<div id="search-result" class="list-group"></div>
	</center>
</body>
</html>