<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post
</title>
    <link rel="stylesheet" href="/css/backend/in.css">
</head>
<body>

    <!-- Main content goes here -->
    
	<div class="form-container">
		<a href="<?= $this->url->get(['for' => 'adminpost-index']) ?>" class="back-link">Back</a>
		<h2>Create New Post</h2>
		<form method="post" action="<?= $this->url->get(['for' => 'adminpost-create-post']) ?>" class="post-form">
			<input type='hidden' name='<?php echo $this->security->getTokenKey() ?>' value='<?php echo $this->security->getToken() ?>'/>

			<label>User:</label><br>
			<?= $form->render('user_id') ?>
			<br>
			<?php if (isset($errors)) { ?>
				<?php foreach ($errors as $error) { ?>
					<?php if ($error->getField() == 'user_id') { ?>
						<span class="error"><?= $error->getMessage() ?></span><br>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<br>

			<label>Title:</label><br>
			<?= $form->render('title') ?>
			<?php if (isset($errors)) { ?>
				<?php foreach ($errors as $error) { ?>
					<?php if ($error->getField() == 'title') { ?>
						<span class="error"><?= $error->getMessage() ?></span><br>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<br>

			<label>Content:</label><br>
			<?= $form->render('content') ?>
			<?php if (isset($errors)) { ?>
				<?php foreach ($errors as $error) { ?>
					<?php if ($error->getField() == 'content') { ?>
						<span class="error"><?= $error->getMessage() ?></span><br>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<br>

			<button type="submit" class="btn-submit">Create</button>
		</form>
	</div>


</body>
<script src="/js/backend/index.js"></script>
</html>

