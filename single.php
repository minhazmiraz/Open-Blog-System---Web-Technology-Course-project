<?php
	
	include 'include/db_connect.php';
	if(!isset($_GET['id'])){
		header('Location: index.php');
	} else {
		$id = $_GET['id'];
	}

	
	if (!is_numeric($id)) {
		header('Location: index.php');
	}

	$result = $db->query("SELECT title, body FROM posts WHERE post_id = '$id' LIMIT 1");

	if (!($result->num_rows)) {
		header('Location: index.php');
	}

	$single = $result->fetch_object();

	if (isset($_POST['submit'])) {
		$email = $_POST['email'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];

		if ($name && $email && $comment && $id) {
			$id = $db->escape_string($id);
			$name = $db->escape_string($name);
			$email = $db->escape_string($email);
			$comment = $db->escape_string($comment);

			//$insert = $db->query("INSERT INTO comments(post_id, email_add, name, comment) VALUES('$id', '$email', '$name', '$comment')");

			$addCom = $db->query("INSERT INTO comments(post_id, email_add, name, comment) VALUES ('$id','$email','$name','$comment')");

			if ($addCom) {
				echo "Comment Added";
			} else {
				echo "Database Error";
			}
			

		} else {
			echo "Fill out all the fields";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$single->title;?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<style type="text/css">
		#container{
			width: 800px;
			padding: 5px;
			margin: auto;
		}
		label{
			display: block;
		}
		input{
			display: block;
			margin: 5px;
			margin-left: 0;
		}
	</style>
</head>
<body>
	<div id="" class="phpcoding">
		<section class="headeroption">
			<h2>Blog system Using Php and Mysql</h2>
		</section>
		<section class="maincontent">
			<div id="post">
				<h2><?=$single->title;?></h2>
				<blockquote><?=$single->body;?></blockquote>
			</div>


			<br><br>
			<h3>Comment Section: </h3>
			<div id="comments">
				<form action="<?=$_SERVER['PHP_SELF']."?id=".$id;?>" method = "post">
					<label>Name: </label>
					<input type="text" name="name">
					<label>Email: </label>
					<input type="text" name="email">
					<label>Comment: </label>
					<textarea name="comment"></textarea>
					<input type="submit" name="submit" value="Comment">

				</form>
			</div>

			<div id="showComment">
				<?php
					$getComments = $db->query("SELECT * FROM comments WHERE post_id='$id' ORDER BY comment_id DESC");
					while ( $row = $getComments->fetch_object()):?>
						<h5><?=$row->name;?> : </h5>
						<blockquote><?=$row->comment;?></blockquote>
				<?php endwhile;?>
			</div>
		</section>
		<section class="footeroption">
			<h2>&copy; Md. Minhazul Islam</h2>
		</section>
	</div>
</body>
</html>