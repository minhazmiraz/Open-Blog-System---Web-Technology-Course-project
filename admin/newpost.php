<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header('Location: login.php');
		exit();
	}


	include '..\include/db_connect.php';
	$result = $db->query("SELECT * FROM categories");
	if(isset($_POST['submit'])){
		$title  =  $_POST['title'];
		$body = $_POST['body'];
		$category = $_POST['category'];

		$title = $db->escape_string($title);
		$body = $db->escape_string($body);
		$category = $db->escape_string($category);
		$user_id = $_SESSION['user_id'];
		$body = htmlentities($body);

		if($title && $body && $category){
			$insert = $db->query("INSERT INTO posts(user_id, title, body, category_id, posted) VALUES('$user_id', '$title', '$body', '$category', NOW())");
			if ($insert) {
				//echo "Post is published";
				header('Location: index.php');
				exit("Post is published");
			} else {
				echo "Error";
			}
		} else {
			echo "Provide all information";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Create New Post</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
</head>
<body>
	<div class="phpcoding">
		<section class="headeroption">
			<h2>Blog system Using Php and Mysql</h2>
		</section>
		<section class="maincontent">
			<h1>Create A Post</h1>
			<form action="<?=htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
				<p>
					<label>Title:</label>
					<input type="text" name="title">
				</p>
				<p>
					<label>Body:</label>
					<textarea name="body"></textarea>
				</p>
				<p>	
					<label>Category</label>
					<select name="category">
					<?php 
							while ($row = $result->fetch_object()){
								echo "<option value='".$row->category_id."'>".$row->category."</option>";
				
							}
						?>
					</select>
				</p>
				<p>
					<input type="submit" name="submit" value="submit"> 
				</p>
			</form>
		</section>
		<section class="footeroption">
			<h2>&copy; Md. Minhazul Islam</h2>
		</section>
	</div>
</body>
</html>