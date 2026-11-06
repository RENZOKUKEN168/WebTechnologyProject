<?php
session_start();
include "createdatabase_table.php";
require "connection.php";
mysqli_report(MYSQLI_REPORT_OFF);

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username !== "" && $password !== "") {
        // Admin credentials are stored in the separate admin table.
        $adminStmt = mysqli_prepare($conn, "SELECT username, password FROM admin WHERE username = ? LIMIT 1");
        if ($adminStmt) {
            mysqli_stmt_bind_param($adminStmt, "s", $username);
            mysqli_stmt_execute($adminStmt);
            $adminAccount = mysqli_fetch_assoc(mysqli_stmt_get_result($adminStmt));

            if ($adminAccount && (password_verify($password, (string)$adminAccount["password"]) || hash_equals((string)$adminAccount["password"], $password))) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $adminAccount["username"];
                $_SESSION["username"] = $adminAccount["username"];
                $_SESSION["role"] = "admin";
                $_SESSION["auth_source"] = "admin_table";
                header("Location: admin.php");
                exit;
            }
        }

        // Regular member credentials remain in the register table.
        $memberStmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM register WHERE username = ? LIMIT 1");
        if ($memberStmt) {
            mysqli_stmt_bind_param($memberStmt, "s", $username);
            mysqli_stmt_execute($memberStmt);
            $memberAccount = mysqli_fetch_assoc(mysqli_stmt_get_result($memberStmt));

            if ($memberAccount && password_verify($password, $memberAccount["password"])) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = (int)$memberAccount["id"];
                $_SESSION["username"] = $memberAccount["username"];
                $_SESSION["role"] = ($memberAccount["role"] ?? "user") === "admin" ? "admin" : "user";
                $_SESSION["auth_source"] = "register";
                header("Location: " . ($_SESSION["role"] === "admin" ? "admin.php" : "index.php"));
                exit;
            }
        }
    }

    $error = "The username or password is incorrect.";
}
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

    <link rel="stylesheet" href="styles/style.css?v=login-fields-4">
</head>

<body class="login-page">

    <?php include ("header.php"); ?>

    <main>

        <article>

            <section>

                <h1>Login</h1>

                <p>Login to access your Plantify account.</p>

                <?php if (isset($_GET["registered"])): ?>
                    <p class="admin-message">Account created. You can now sign in.</p>
                <?php endif; ?>
                <?php if ($error !== ""): ?>
                    <p class="admin-error"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>

                <form id="form" action="login.php" method="post">

                    <p>
                        <label for="login">Username:</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            maxlength="50"
                            required>
                    </p>

                    <p>
                        <label for="password">Password:</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            maxlength="255"
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
