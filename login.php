<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plantify Login Page">
    <meta name="keywords" content="Plantify, login, biodiversity, plants">
    <meta name="author" content="Plantify Team">
    <title>Plantify - Login</title>

    <link rel="stylesheet" href="styles/style.css">
</head>

<body class="login-page">

    <?php include ("header.php"); ?>

    <main>

        <article>

            <section>

                <h1>Login</h1>

                <p>Login to access your Plantify account.</p>

                <form id="form" action="#" method="post">

                    <p>
                        <label for="login">Username:</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            maxlength="10"
                            pattern="[A-Za-z]+"
                            required>
                    </p>

                    <p>
                        <label for="password">Password:</label>
                        <input
                            type="text"
                            id="password"
                            name="password"
                            maxlength="25"
                            pattern="[A-Za-z]+"
                            required>
                    </p>

                    <p>
                        <input type="submit" value="Login">
                        <input type="reset" value="Clear">
                    </p>

                    <p>Don't have an account yet? <a href="register.php">Register here.</a></p>
                </form>

            </section>

        </article>

    </main>

    <?php include ("footer.php"); ?>

</body>

</html>
