<?php 

session_start();
if(isset($_SESSION['user']) != ""){
	header("Location: search.php");
}
include 'settings.php';
if(isset($_POST['btn-signup'])){
	$uname = htmlspecialchars($_POST['uname']);
	$email = htmlspecialchars($_POST['email']);
	$upass = md5(htmlspecialchars($_POST['pass']));

	$query = mysqli_query($conn,"INSERT INTO user(user_name,email_id,password,role_id) VALUES('$uname','$email','$upass',2)");

	if($query){
?>
	<script>alert("You're Successfully Registered.");</script>
<?php
	}  
else{
?>	
	<script>alert("We're Sorry! Error While Registering You");</script>	
<?php  
	}
}
?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
 	<meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
 	<title>Register</title>
 	<link type="text/css" rel="stylesheet" href="style.css">
 </head>
 <body>
 	<center>
 		<h1>Movie Portal Website</h1> <br />
 		<div id="reg-form">
 			<center>
 			<form method="post">
 				<table align="center" width="40%" border="0">
 					<th>Registration Form</th>
 					<tr>
 						<td><center><input type="text" name="uname" placeholder="Username" class="input" required /></center></td>
 					</tr>
 					<tr>
 						<td><center><input type="email" name="email" placeholder="Email Address" class="input" required /></center></td>
 					</tr>
 					<tr>
 						<td><center><input type="password" name="pass" placeholder="Set Password" class="input" required /></center></td>
 					</tr>
 					<tr>
 						<td><center><button type="submit" name="btn-signup" class="btn">Sign me up!</button>
 						<button type="reset" name="btn-reset" class="btn">Reset</button></center></td>
 					</tr>
 					<tr>
 						<td><center>Already Registered? <a href="index.php">Sign in!</a></center></td>
 					</tr>
 				</table>
 			</form>
 			</center>
 		</div>
 	</center>
 </body>
 </html>