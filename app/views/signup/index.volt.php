<!DOCTYPE html>
<html>

<head>
    <title>Working Form</title>
</head>

<body>
    <h2>Sign up using this form</h2>

    <?= $this->tag->form(["signup/register"]) ?>
        <p>
            <label for="name">Name</label>
            <?= $this->tag->inputText("name") ?>
        </p>

        <p>
            <label for="email">E-Mail</label>
            <?= $this->tag->inputText("email") ?>
        </p>

        <p>
            <?= $this->tag->inputSubmit("register", "Register") ?>
        </p>
    <?= \Phalcon\Tag::endform() ?>
</body>

</html>