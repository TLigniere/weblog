<?php
include "../../config.php";

//include(ROOT_PATH . '/includes/all_functions.php');

$posts = getAllPosts();
?>

		<div class="table-div" style="width: 90%;">

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Author</th>
						<th>Image</th>
						<th>Topic</th>
						<th>Created at</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$key=0; 
						while ($post = $posts->fetch_assoc()){ ?>
						<tr>
							<td><?php echo $key = $key + 1; ?></td>
							<td><?php echo htmlspecialchars($post['title']); ?></td>
							<td><?php echo htmlspecialchars($post['author']); ?></td>
							<td>
								<?php if (!empty($post['image'])): ?>
									<img src="../static/images/<?php echo $post['image']; ?>" width="60">
								<?php else: ?>
									<em>No image</em>
								<?php endif; ?>
							</td>
							<td><?php echo htmlspecialchars($post['topic']); ?></td>
							<td><?php echo date("d M Y", strtotime($post['created_at'])); ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>