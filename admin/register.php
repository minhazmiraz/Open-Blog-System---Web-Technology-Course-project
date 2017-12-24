<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		header('Location: index.php');
		exit();
	}
	require '..\include/db_connect.php';
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_POST['register'])) {
			$newUser = $_POST['newUser'];
			$newPass = $_POST['newPassword'];
			$conPass = $_POST['conPassword'];
			
			if(!empty($newUser) && !empty($newPass) && !empty($conPass)){
				if ($newPass==$conPass) {
					$pass = md5($newPass);
						$feed = $db->query("INSERT INTO user(username, password) VALUES('$newUser', '$pass')");
						
					if($feed){
						$_SESSION['feed'] = "Successfully Registered. Now you can login with new username and password";
						header('Location: login.php');
						exit();
					} else {
						$_SESSION['feed'] = "Registration Unsuccessful";
						header('Location: login.php');
						exit();
					}
				} else {
					$_SESSION['feed'] = "Passwords didn\'t match";
					header('Location: login.php');
					exit();
				}
			} else {
				$_SESSION['feed'] = "Missing Information";
				header('Location: login.php');
				exit();
			}
		}
	}

?>