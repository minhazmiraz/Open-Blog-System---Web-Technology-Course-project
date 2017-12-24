<?php
	session_start();
	include 'include/db_connect.php';

	$total_post = $db->query("SELECT * FROM posts");
	
	$per_page = 2;
	
	//total pages
	$pages = ceil($total_post->num_rows/$per_page);

	if(isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p']>0 && $_GET['p']<=$pages){
		$page = $_GET['p'];
	} else {
		$page = 1;
	}

	if($page<=0){
		$start = 0;
	} else {
		$start = $page*$per_page-$per_page;
	}

	$prev = $page-1;
	$next = $page+1;

	$query = $db->query("SELECT posts.post_id, posts.user_id, posts.title, posts.body, posts.posted, categories.category FROM posts INNER JOIN categories ON posts.category_id=categories.category_id ORDER BY post_id DESC LIMIT $start, $per_page");

	if (isset($_SESSION['deletemsg'])) {
		echo $_SESSION['deletemsg'];
		unset($_SESSION['deletemsg']);
	} 

?>

<!DOCTYPE html>
<html> 
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
	<div class="phpcoding">
		<section class="headeroption">
			<h2>Blog system Using Php and Mysql</h2>
		</section>
		<section class="maincontent">
			<center>
				<?php if(!isset($_SESSION['user_id'])): ?>
						<p><a href="admin/login.php">Sign In</a> . <a href="admin/login.php">Sign Up</a></p>
				<?php else: ?>
					<p><a href="admin/index.php">WelCome <?= $_SESSION['username']?></a>   .   
					<a href="admin/newpost.php">Create a new Blog</a></p>				
				<?php endif ?>
			</center>

			<?php
				if($query->num_rows===0)
					echo "<h1>No Blog Posted Yet</h1>"
			?>

			<?php while ($row = $query->fetch_object()): 
				$firstSpace = strpos($row->body, ' ');
			?>
				<article>
					<h2><?=$row->title;?></h2>
					<?php
						//echo print_r($row);
						if($_SESSION['user_id']==$row->user_id)
							echo '<a href="admin/delete.php?id=<?=$row->post_id;?>">Delete This Post</a>'
					?>
					<p>Posted On: <?=$row->posted;?></p>
					
					<p>
						<?=substr($row->body, 0, 30);?>
						<a href="single.php?id=<?=$row->post_id;?>"> ....</a>
											
					</p>
					<b><p>Category: <?=$row->category?></p></b>
				</article>
			<?php endwhile; ?>


			<?php if($query->num_rows>0): ?>
				<label>Pages: </label>
				<?php if ($prev>0):?>
					<a href="index.php?p=<?=$prev;?>">Previous</a>
				<?php endif;?>

				<?php for($i=1; $i<=$pages; $i++):?>
					<a href="index.php?p=<?=$i;?>"> <?=$i;?> </a>
				<?php endfor;?>

				<?php if ($next<=$pages):?>
					<a href="index.php?p=<?=$next;?>"> Next</a>
				<?php endif;?>
			<?php endif;?>
		</section>
		<section class="footeroption">
			<h2>&copy; Md. Minhazul Islam</h2>
		</section>
	</div>
</body>
</html>