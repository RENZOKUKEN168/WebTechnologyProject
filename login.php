<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
include "createdatabase_table.php";
@include "connection.php";

$needConn = true;
if (isset($conn) &&$conn instanceof mysqli) {
    try {
        if (mysqli_thread_id($conn)) {$needConn = false;
        }
    } catch (Throwable $e) {$needConn = true;
    }
}
if ($needConn) {$conn = mysqli_connect("localhost", "root", "", "plantify_db");
}

$error = "";
$username = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim((string)($_POST["login"] ?? ""));
    $password = (string)($_POST["password"] ?? "");

    if ($username !== "" && $password !== "" && $conn) {
        // Admin credentials are stored in the separate admin table.
        $adminStmt = mysqli_prepare($conn, "SELECT username, password FROM admin WHERE LOWER(username) = LOWER(?) LIMIT 1");
        if ($adminStmt) {
            mysqli_stmt_bind_param($adminStmt, "s", $username);
            mysqli_stmt_execute($adminStmt);$adminResult = mysqli_stmt_get_result($adminStmt);$adminAccount = $adminResult ? mysqli_fetch_assoc($adminResult) : null;
            mysqli_stmt_close($adminStmt);

            if ($adminAccount && (
                password_verify($password, (string)$adminAccount["password"]) ||
                strcasecmp((string)$adminAccount["password"], $password) === 0
            )) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = $adminAccount["username"];
                $_SESSION["username"] = $adminAccount["username"];
                $_SESSION["role"] = "admin";
                $_SESSION["auth_source"] = "admin_table";
                mysqli_close($conn);
                header("Location: admin.php");
                exit;
            }
        }

        // Regular member credentials are stored in the user table.
        $userStmt = mysqli_prepare($conn, "SELECT id, name, username, password, profile_picture FROM `user` WHERE username = ? LIMIT 1");
        if ($userStmt) {
            mysqli_stmt_bind_param($userStmt, "s", $username);
            mysqli_stmt_execute($userStmt);$userResult = mysqli_stmt_get_result($userStmt);$userAccount = $userResult ? mysqli_fetch_assoc($userResult) : null;
            mysqli_stmt_close($userStmt);

            if ($userAccount && (
                password_verify($password, (string)$userAccount["password"]) ||
                hash_equals((string)$userAccount["password"], $password)
            )) {
                session_regenerate_id(true);
                $_SESSION["user_id"] = (int)$userAccount["id"];
                $_SESSION["username"] = $userAccount["username"];
                $_SESSION["name"] = $userAccount["name"];
                $_SESSION["profile_picture"] = $userAccount["profile_picture"];
                $_SESSION["role"] = "user";
                $_SESSION["auth_source"] = "user_table";
                mysqli_close($conn);
                header("Location: index.php");
                exit;
            }
        }
    }

    $error = "The username or password is incorrect.";
}

if (isset($conn) &&$conn instanceof mysqli) {
    try {
        mysqli_close($conn);
    } catch (Throwable $e) {
    }
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
                    <p class="admin-error" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
                <?php endif; ?>

                <form id="form" action="login.php" method="post">

                    <p>
                        <label for="login">Username:</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            maxlength="50"
                            value="<?= htmlspecialchars($username, ENT_QUOTES, "UTF-8") ?>"
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