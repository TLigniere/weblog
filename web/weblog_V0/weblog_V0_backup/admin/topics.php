<?php include('../includes/admin/head_section.php'); ?>
<?php include('../config.php'); ?>
<?php include(ROOT_PATH . '/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/includes/all_functions.php'); ?>

<title>Admin | Manage topics</title>
</head> 

<body>
<?php 
$topics = getTopics();
?>
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/includes/admin/header.php'); ?>

	<div class="container content">
		
		<!-- Left menu -->
		<?php include(ROOT_PATH . '/includes/admin/menu.php'); ?>

		<!-- Main content -->
		<div class="table-div" style="width: 90%;">
            <table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Topic Name</th>
						<th>Slug</th>
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
                    <?php } //TODO : ADD FUNCTION TO EDIT/DELETE TOPICS ?>

        </div>
    </div>

</body>
</html>
