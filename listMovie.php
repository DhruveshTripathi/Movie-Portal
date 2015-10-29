<?php

	include 'settings.php';
	$sql = "SELECT * FROM movies";
 	$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>
<head>
	<title>List Of Movies</title>
	<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
<div id="logout">
	<table align="right" border="1">
		<tr>
			<td><center><a href="logout.php?logout">Logout</a></center></td>
		</tr>
	</table>

<center>
<form name="list" method="post" action="">
	<div style="width:500px;">
	<center>
	<div align="centre" style="padding-bottom:5px;"><a href="addMovie.php">Add Movie</a></div>
	</center>
	<table border="0" cellpadding="10" cellspacing="1" width="500">
		<thead>
			<th>IMDB_ID</th>
			<th>Movie Name</th>
			<th>Delete</th>
		</thead>
<?php

		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

?>
		<tr>
			<td><?php echo $row["imdb_id"]; ?></td>
			<td><?php echo $row["title"]; ?></td>
			<td><a href="deleteMovie.php?imdb_id=<?php echo $row["imdb_id"]; ?>"  class="link">Delete</a></td></td>
		</tr>
<?php
		}
?>
	</table>
</form>
</center>
</body>
</html>