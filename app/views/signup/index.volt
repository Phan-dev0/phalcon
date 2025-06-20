<!DOCTYPE html>
<html>

<head>
    <title>Working Form</title>
</head>

<body>
    <h2>Sign up using this form</h2>

    {{ form(["signup/register"])}}
        <p>
            <label for="name">Name</label>
            {{ inputText("name") }}
        </p>

        <p>
            <label for="email">E-Mail</label>
            {{ inputText("email") }}
        </p>

        <p>
            {{ inputSubmit("register", "Register") }}
        </p>
    {{ endForm() }}
</body>

</html>