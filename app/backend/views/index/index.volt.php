<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post List
</title>
    <link rel="stylesheet" href="/css/backend/index.css">
</head>
<body>

    <!-- Main content goes here -->
    
	<h1>Backend Dashboard</h1>
	<a href="<?= $this->url->get(['for' => 'post-create']) ?>" class="btn btn-primary">Create New Post</a>

	<table class="post-table">
		<thead>
			<tr>
				<th>ID</th>
				<th>User's Name</th>
				<th>Title</th>
				<th>Created At</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($posts as $post) { ?>
				<tr>
					<td><?= $post->getId() ?></td>
					<td><?= $post->getUser()->getUsername() ?></td>
					<td><?= $post->getTitle() ?></td>
					<td><?= $post->getCreatedAt() ?></td>
					<td>
						<a href="<?= $this->url->get(['for' => 'post-update', 'id' => $post->getId()]) ?>" class="btn btn-update">Update</a>
						<a href="<?= $this->url->get(['for' => 'post-delete', 'id' => $post->getId()]) ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this post?');">
							Delete
						</a>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php foreach ($this->flashSession->getMessages() as $type => $messages) { ?>
		<?php foreach ($messages as $message) { ?>
			<div class="flash-message <?= $type ?>">
				<?= $message ?>
			</div>
		<?php } ?>
	<?php } ?>


</body>
<script src="/js/backend/index.js"></script>
</html>

