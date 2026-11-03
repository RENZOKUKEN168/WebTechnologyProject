<?php
session_start();
$_SESSION = [];
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5;url=login.php">
    <title>Logged Out | Plantify</title>
    <link rel="stylesheet" href="styles/style.css?v=logout-1">
</head>
<body class="login-page logout-page">
    <?php include "header.php"; ?>
    <main class="logout-card">
        <h1>Logout Successfull</h1>
        <p>You have been logged out. You will return to the login page in 5 seconds.</p>
        <a class="logout-ok" href="login.php">OK</a>
    </main>
</body>
</html>
