<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/post_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/admin/head_section.php'); ?>

<?php
	$topics = getTopics();	
?>

<title>Admin | Create Post</title>
</head>
<body>
	<?php include(ROOT_PATH . '/includes/admin/header.php') ?>
	<div class="container content">
		<?php include(ROOT_PATH . '/includes/admin/menu.php') ?>

		<div class="action create-post-div">
			<h1 class="page-title">Create/Edit Post</h1>

			<form method="post" enctype="multipart/form-data" action="create_post.php">
				<?php include(ROOT_PATH . '/includes/public/errors.php') ?>

				<?php if ($isEditingPost === true): ?>
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
				<?php endif ?>

				<input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title" required>

				<label>Featured image</label>
				<input type="file" name="featured_image">

				<textarea name="body" id="body"><?php echo $body; ?></textarea>

				<select name="topic_id" required>
					<option value="" disabled <?php echo empty($topic_id) ? 'selected' : ''; ?>>Choose topic</option>
					<?php foreach ($topics as $topic): ?>
						<option value="<?php echo $topic['id']; ?>" <?php if ($topic_id == $topic['id']) echo 'selected'; ?>>
							<?php echo $topic['name']; ?>
						</option>
					<?php endforeach ?>
				</select>

				<?php if ($isEditingPost === true): ?> 
					<button type="submit" class="btn" name="update_post" value=<?php $_GET["edit-admin"]?> >UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_post">Save Post</button>
				<?php endif ?>
			</form>
		</div>
	</div>
</body>
</html>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script> CKEDITOR.replace('body'); </script>
