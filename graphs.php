 <!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=windows-1252">
	<title>Graphs</title>
	<link type="text/css" rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="css/morris.css">
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.min.js"></script>
	<script>
	var yearmov,genmov;
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
            	line_chart_result=jQuery.parseJSON(xmlhttp.responseText);
            	$("#yearGraph").empty();
                colors=['#16a085'];
		        labels= ['IMDB Rating'];
		        yearmov=Morris.Bar({
		            element: 'yearGraph',
		            data: line_chart_result['yearMovie'],
		            xkey: 'title',
		            ykeys: ['imdb_rating'],
		            barColors: colors,
		            labels: labels,
		          });
		        $("#genreGraph").empty();
                colors=['#008500'];
		        labels= ['genre Avg'];
		        yearmov=Morris.Bar({
		            element: 'genreGraph',
		            data: line_chart_result['genreAvg'],
		            xkey: 'genre',
		            ykeys: ['avg'],
		            barColors: colors,
		            labels: labels,
		          });
            }
        }
        xmlhttp.open("GET","getGraphData.php?q="+str,true);
        xmlhttp.send();
	}
	</script>
</head>
<body>
	<center>
	<div id="year-div">
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
	<div id="yearGraph">
	</div>
	<div id="genreGraph">
	</div>
	
</body>
</html>