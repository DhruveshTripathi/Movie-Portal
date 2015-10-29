<?php 

session_start();
include 'settings.php';

if(isset($_SESSION['user'])){
	if($_SESSION['role'] == 1){
		header("Location: listMovie.php");
	}
	else if ($_SESSION['role'] == 2) {
		header("Location: search.php");
	}
}

if(isset($_POST['btn-login'])){
	$email = htmlspecialchars($_POST['email']);
 	$upass = htmlspecialchars($_POST['pass']);
 	$role = htmlspecialchars($_POST['roles']);

 	$sql = "SELECT * FROM user WHERE email_id='$email'";
 	$result = mysqli_query($conn,$sql);
 	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

 	if($row['password']==md5($upass) && $row['role_id']==$role){
  		$_SESSION['user'] = $row['user_id'];
  		$_SESSION['role'] = $row['role_id'];
  		if($_SESSION['role'] == 1){
			header("Location: listMovie.php");
		}
		else if ($_SESSION['role'] == 2) {
			header("Location: search.php");
		}
 	}
 	else{
 ?>

 	<script>alert("Email ID or Password is wrong. Try Again!");</script>

<?php
 	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Login</title>
	<link type="text/css" rel="stylesheet" href="style.css">
</head>
<body>
	<center>
		<h1>Movie Portal Website</h1> <br />
		<div id="login-form">
		<center>
			<form method="post">
				<table align="center" width="40%" border="0">
					<th>Login Form</th>
					<tr>
						<td>
							<center>
							<?php

								include 'settings.php';
								$query1 = "SELECT * from roles;"; 
								$stmt1 = $conn->prepare($query1);
								$stmt1->execute();
								$stmt1->store_result();
								$stmt1->bind_result($id,$role);
								echo '<select name="roles" class="input">';
								while($stmt1->fetch()){
									echo '<option value="'.$id.'">'.$role.'</option>';
								}
								echo '</select>';
							?>
							</center>
						</td>
					</tr>
					<tr>
						<td>
							<center><input type="email" name="email" placeholder="Enter Your Email Address" class="input" required /></center>
						</td>
					</tr>
					<tr>
						<td>
							<center><input type="password" name="pass" placeholder="Enter Your Password" class="input" required /></center>
						</td>
					</tr>
					<tr>
						<td>
							<center><button type="submit" name="btn-login" class="btn">Sign In</button>
							<button type="reset" name="btn-reset" class="btn">Reset</button></center></td></center>
						</td>
					</tr>
					<tr>
						<td>
							<center>Register Here? <a href="register.php">Sign Up!</a></center>
						</td>
					</tr>
				</table>
			</form>
		</center>
	</center>
</body>
</html>