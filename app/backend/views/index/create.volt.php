<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="/css/backend/index.css">
</head>
<body>

    <!-- Main content goes here -->
    
    <div class="form-container">
        <a href="<?= $this->url->get(['for' => 'posts']) ?>" class="back-link">Back</a>
        <h2>Create New Post</h2>
        <form method="post" action="<?= $this->url->get(['for' => 'post-create']) ?>" class="post-form">
            <label>User:</label><br>
            <select name="user_id">
                <option value="">-- Select User --</option>
                <?php foreach ($users as $user) { ?>
                    <option value="<?= $user->getId() ?>"><?= $user->getId() ?> - <?= $user->getUsername() ?></option>
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
            <input type="text" name="title"><br>
            <?php if (isset($errors)) { ?>
                <?php foreach ($errors as $error) { ?>
                    <?php if ($error->getField() == 'title') { ?>
                        <span class="error"><?= $error->getMessage() ?></span><br>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
            <br>

            <label>Content:</label><br>
            <textarea name="content"></textarea><br>
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

