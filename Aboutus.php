<?php
	session_start();
	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Demonstrates some basic HTML form elements" />
	<meta name="keywords" content="HTML, Form, tags" />
	<meta name="author" content="Chin Jii Ann"  />
	<link rel="stylesheet" href="styles/style.css">
	<title>About Us</title>
</head>
<body class="aboutus-page">
    <?php
        include("header.php");
        ?>
    <section class="user-profile">
    <h1>User Profile</h1>
    <div class="user-list">

        <div class="user">
            <a href="user1.php">
                <img src="images/user/unknown.png" alt="User 1">
            </a>
            <h2>User 1</h2>
        </div>

        <div class="user">
            <a href="user2.php">
                <img src="images/user/unknown.png" alt="User 2">
            </a>
            <h2>User 2</h2>
        </div>

        <div class="user">
            <a href="user3.php">
                <img src="images/user/unknown.png" alt="User 3">
            </a>
            <h2>User 3</h2>
        </div>

        <div class="user">
            <a href="user4.php">
                <img src="images/user/unknown.png" alt="User 4">
            </a>
            <h2>User 4</h2>
        </div>
    </div>
</section>
    <?php
        include("footer.php");
        ?>
</body>
</html>
