<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<body>
    <h1>Backend Dashboard</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) { ?>
                <tr>
                    <td><?= $post->getId() ?></td>
                    <td><?= $post->getUserId() ?></td>
                    <td><?= $post->getTitle() ?></td>
                    <td><?= $post->getContent() ?></td>
                    <td><?= $post->getCreatedAt() ?></td>
                    <td>
                        <a href="/admin/index/update/<?= $post->getId() ?>">
                            <button>Update</button>
                        </a>

                        <a href="/admin/index/delete/<?= $post->getId() ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                            <button>Delete</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
