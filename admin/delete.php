<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
	}
	require '../include/db_connect.php';
	if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
		header('Location: ../index.php');
		exit();
	}
	$user = $_SESSION['user_id'];
	$post = $_GET['id'];
	$query = $db->query("DELETE FROM posts WHERE post_id = '$post' AND user_id = '$user'");
	if ($query) {
		$_SESSION['deletemsg'] = "Post was deleted";
	} else {
		$_SESSION['deletemsg'] = "Something Went Wrong";
	}

	header('Location: ../index.php');
?>
