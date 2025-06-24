<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Post</title>
    <link rel="stylesheet" href="/css/backend/index.css">
</head>
<body>

    <!-- Main content goes here -->
    
    <div class="form-container">
        <a href="<?= $this->url->get(['for' => 'posts']) ?>" class="back-link">Back</a>
        <h2>Update Post</h2>
        <form method="post" action="<?= $this->url->get(['for' => 'post-update', 'id' => $post->getId()]) ?>" class="post-form">
            <label>User:</label><br>
            <select name="user_id">
                <option value="">-- Select User --</option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?= $user->getId() ?>" 
                        <?php if ($post->getUserId() == $user->getId()) { ?>selected<?php } ?>>
                        <?= $user->getId() ?> - <?= $user->getUsername() ?>
                    </option>
                <?php } ?>
            </select><br>
            <?php if (isset($errors)) { ?>
                <?php foreach ($errors as $error) { ?>
                    <?php if ($error->getField() == 'user_id') { ?>
                        <span class="error"><?= $error->getMessage() ?></span><br>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <br>

            <label>Title:</label><br>
            <input type="text" name="title" value="<?= $post->getTitle() ?>"><br>
            <?php if (isset($errors)) { ?>
                <?php foreach ($errors as $error) { ?>
                    <?php if ($error->getField() == 'title') { ?>
                        <span class="error"><?= $error->getMessage() ?></span><br>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <br>

            <label>Content:</label><br>
            <textarea name="content"><?= $post->getContent() ?></textarea><br>
            <?php if (isset($errors)) { ?>
                <?php foreach ($errors as $error) { ?>
                    <?php if ($error->getField() == 'content') { ?>
                        <span class="error"><?= $error->getMessage() ?></span><br>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <br>

            <button type="submit" class="btn-submit">Update</button>
        </form>
    </div>


</body>
<script src="/js/backend/index.js"></script>
</html>

