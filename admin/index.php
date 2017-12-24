<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		header('Location: login.php');
		exit();
	}
	include '..\include/db_connect.php';

	//count total posts
	$post_count = $db->query("SELECT * FROM posts");
	//count total comments
	$comment_count = $db->query("SELECT * FROM comments");

	if (isset($_POST['submit'])) {
		$newCategory = $_POST['newCategory'];

		if (!empty($newCategory)) {
			$newcat = $db->query("INSERT INTO categories(category)VALUES('$newCategory')");
			if ($newcat) {
				echo "New Category Added";
			} else {
				echo "Error";
			}

		} else {
			echo "Type new category name";
		}
		
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>The New Blog</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	<style type="text/css">
		#container{
			padding: 10px;
			width: 800px;
			margin: auto;
			background: white;
		}
		#menu{
			height: 40px;
			line-height: 40px;
		}
		#menu ul{
			margin: 0;
			padding: 0;
		}
		#menu ul li{
			display: inline;
			list-style: none;
			margin-right: 10px;
			font-size: 18px;
		}
		#mainContent{
			clear: both;
			margin-top: 5px;
			font-size: 25px;
		}
		#header{
			height: 80px;
			line-height: 80px;
		}
		#container #header h1{
			font-size: 45px;
			margin:0;
		}
	</style>

</head>

<body>
	<div id="" class="phpcoding">
		<section class="headeroption">
			<h2>Blog system Using Php and Mysql</h2>
		</section>
		<center><p>
			<a href="">Home</a> . 
			<a href="newpost.php">Create New Post</a> . 
			<a href="logout.php">Logout</a> . 
			<a href="..\index.php">Blog Home Page</a>
		</p></center>
		<section class="maincontent">
			<div id="mainContent">
				<table>
					<tr>
						<td>Total Blog Post</td>
						<td><?=$post_count->num_rows;?></td>
					</tr>
					<tr>
						<td>Total Comments</td>
						<td><?=$comment_count->num_rows;?></td>
					</tr>

				</table>

				<div id="categoryForm">
					<form action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
						<label>Add New Category</label>
						<input type="text" name="newCategory">
						<input type="submit" name="submit" value="submit">
					</form>
				</div>
			</div>
		</section>
		<section class="footeroption">
			<h2>&copy; Md. Minhazul Islam</h2>
		</section>
	</div>

</body>
</html>