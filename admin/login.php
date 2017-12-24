<?php
	session_start();


	if (isset($_POST['submit'])) {  // Check if submit button is clicked
		$username = $_POST['username']; 
		$password = $_POST['password'];

		// include db connection
		include '..\include/db_connect.php';

		if (empty($username) || empty($password)) { // check if the username & password are provided
			echo "Provide all information";
		} else {

			$username = strip_tags($username);
			$username = $db->escape_string($username);
			$password = strip_tags($password);
			$password = $db->escape_string($password);
			$password = md5($password);
			$result = $db->query("SELECT user_id, username, password FROM user WHERE username = '$username' LIMIT 1");

			if($result->num_rows===1){				// Check if any row has returned 
				//$result = $result->fetch_object();
				# Another style
				while ($row = $result->fetch_object()) {
					$hash = $row->password;
					echo $password."<br>".$hash."<br>";
					if ($password===$hash) {
						$_SESSION['user_id'] =  $row->user_id;
						$_SESSION['username'] =  $row->username;
						 //if any row has returned, then set session variable
						header('Location: index.php');  // redirect to index.php and exit
						exit();
					} else {
						echo "Invalid Username or Password";
					}
				}
			} 	
		}
	}
	
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login/Register Form</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>

</head>
<body>
<div id="" class="phpcoding">
	<section class="headeroption">
		<h2>Blog system Using Php and Mysql</h2>
	</section>
	<section class="maincontent">
		<form action="login.php" method="post">
			<p>
			<label>Username</label>
			<input type="text" name="username">
			</p>

			<p>
			<label>Password</label>
			<input type="password" name="password">
			</p>
			<input type="submit" name="submit" value="Login">
		</form>

		<br><br>
		<h3>New User?</h3>
		<h4>Register here</h4>
		<form action="register.php" method="post">
			<p>
				<label>Username: </label>
				<input type="text" name="newUser">
			</p>
		
			<p>
				<label>Password: </label>
				<input type="password" name="newPassword">
			</p>
			<p>
				<label>Confirm Password: </label>
				<input type="password" name="conPassword">
			</p>
			<input type="submit" name="register" value="Register">

		</form>
		<?php if(isset($_SESSION['feed'])):?>
			<h5><?=$_SESSION['feed'];?></h5>
		<?php unset($_SESSION['feed']);?>

		<?php endif;?>
	</section>
	<section class="footeroption">
		<h2>&copy; Md. Minhazul Islam</h2>
	</section>
</div>
</body>
</html>