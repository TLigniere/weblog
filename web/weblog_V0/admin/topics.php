<?php include('../includes/admin/head_section.php'); ?>
<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/all_functions.php'); ?>

<title>Admin | Manage topics</title>
</head> 

<body>
<?php 
$topics = getTopics();
$isEditingTopics = $_GET["edit-topic"] ?? "";
if ($isEditingTopics) {
	$result = getTopic($isEditingTopics);
	$topic_id = $isEditingTopics ?? "";
	$name = $result["name"] ?? "";
}

?>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/includes/admin/header.php'); ?>

	<div class="container content">
		
		<!-- Left menu -->
		<?php include(ROOT_PATH . '/includes/admin/menu.php'); ?>

		<!-- Create/Edit topic -->
		<div class="action">
			<h1 class="page-title">Create/Edit Topic</h1>

			<form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>">

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/public/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingTopics == true) : ?>
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<?php endif ?>

				<input type="text" name="name" value="<?php echo ($name ?? ""); ?>" placeholder="Name">

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingTopics == true) : ?>
					<button type="submit" class="btn" name="update_topic" value=<?php echo $_GET["edit-topic"];?> >UPDATE</button>
				<?php else : ?>
					<button type="submit" class="btn" name="create_topic">Save Topic</button>
				<?php endif ?>

			</form>
		</div>

		<!-- Main content -->
		<div class="table-div" style="width: 90%;">
            <table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Topic Name</th>
						<th>Slug</th>
						<th>Edit</th>
						<th>Delete</th>
					</tr>
				</thead>
                <tbody>
                    <?php while($row = $topics->fetch_assoc()){?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["id"])?></td>
                            <td><?php echo htmlspecialchars($row["name"])?></td>
                            <td><?php echo htmlspecialchars($row["slug"])?></td>
                            
							<td>
								<a class="fa fa-pencil btn edit" href="topics.php?edit-topic=<?php echo $row['id'] ?>">
								</a>
							</td>
							<td>
								<a class="fa fa-trash btn delete" href="topics.php?delete-topic=<?php echo $row['id'] ?>">
								</a>
							</td>
                        </tr>
                    <?php } ?>

        </div>
    </div>

</body>
</html>
