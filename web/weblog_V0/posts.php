<?php
include "config.php";

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$result = $conn.query ("SELECT user_id, title, body, created_at, updated_at FROM posts");

if ($result) {
    while ($row = $result->fetch_assoc()){
        echo ""
    }
} ?>

		<div class="table-div" style="width: 90%;">
			<h1 class="page-title">Manage Posts</h1>

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Author</th>
						<th>Image</th>
						<th>Topic</th>
						<th>Created at</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($post = $posts->fetch_assoc()){ ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
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
							<td>
								<a class="fa fa-trash btn delete" href="posts.php?delete-post=<?php echo $post['id']; ?>"></a>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>