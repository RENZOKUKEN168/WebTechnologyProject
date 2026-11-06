<?php
	session_start();
	require "connection.php";
	include "createdatabase_table.php";
	$servername = "localhost";
	$username   = "root";
	$password   = "";
	$dbname     = "plantify_db";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$firstname      = trim($_POST["firstname"] ?? "");
	$lastname       = trim($_POST["lastname"] ?? "");
	$phone          = trim($_POST["phone"] ?? "");
	$username       = trim($_POST["username"] ?? "");
	$password_hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $street_address = trim($_POST["street_address"] ?? "");
	$city           = trim($_POST["city"] ?? "");
	$state          = trim($_POST["state"] ?? "");
	$postcode       = trim($_POST["postcode"] ?? "");

	// server side validation
	$errors = [];
 
	if (!preg_match("/^[A-Za-z ]{1,25}$/", $firstname)) {
		$errors[] = "First name must be 1 to 25 alphabetic characters.";
	}
	if (!preg_match("/^[A-Za-z ]{1,25}$/", $lastname)) {
		$errors[] = "Last name must be 1 to 25 alphabetic characters.";
	}
	if (!preg_match("/^\d{1,10}$/", $phone)) {
		$errors[] = "Phone number must contain digits only, maximum 10 digits.";
	}
	if ($username === "" || mb_strlen($username) > 50) {
		$errors[] = "Username/email is required and must be 50 characters or fewer.";
	}
	if (strlen($password) < 8 || strlen($password_hash) > 20) {
		$errors[] = "Password must be between 8 and 20 characters.";
	}
	if ($street_address === "" || mb_strlen($street_address) > 40) {
		$errors[] = "Street address is required and must be 40 characters or fewer.";
	}
	if ($city === "" || mb_strlen($city) > 20) {
		$errors[] = "City/Town is required and must be 20 characters or fewer.";
	}
	if (!preg_match("/^\d{5}$/", $postcode)) {
		$errors[] = "Postcode must be exactly 5 digits.";
	}

	// checks if the username is already taken
	if (empty($errors)) {
    $check = mysqli_prepare($conn, "SELECT id FROM register WHERE username = ?");
    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);
    if (mysqli_stmt_num_rows($check) > 0) {
        $errors[] = "That username/email is already registered. Please use another.";
    }
    mysqli_stmt_close($check);
	}

	// saving to database
	$success = false;
 
	if (empty($errors)) {
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
	
		try {
			$stmt = mysqli_prepare($conn,
				"INSERT INTO register
				(firstname, lastname, phone, username, password, street_address, city, state, postcode)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			mysqli_stmt_bind_param($stmt, "sssssssss",
				$firstname, $lastname, $phone, $username, $password_hash,
				$street_address, $city, $state, $postcode);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			$success = true;
		} catch (mysqli_sql_exception $e) {
			$errors[] = "Sorry, your registration could not be saved. Please try again later.";
		}
	}
 
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Registration confirmation page" />
	<meta name="keywords"    content="register, confirmation, plantify" />
	<title>Registration Coonfirmation Page</title>
</head>	
<body>
<?php include ("header.php"); ?>	
	<h1>Plantify</h1>
	<?php if ($success): ?>
	<h2>Plantify Registration Confirmation page</h2>

	<fieldset>
		<legend>Your Details</legend>
		 <p>Welcome <?php echo htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname); ?></p>
		 <p>Your account has been registered. Your details are as followed: </p>
		 <p>Username: <?php echo htmlspecialchars($username); ?></p>
		 <p>Phone number: <?php htmlspecialchars($phone); ?></p>
	</fieldset>
	<p><a href="login.php">Sign in</a></p>

	<?php else: ?>

	<h2>Registration Failed</h2>
	<fieldset>
			<legend>Please fix the following</legend>
			<ul>
				<?php foreach ($errors as $error): ?>
					<li><?php echo htmlspecialchars($error); ?></li>
				<?php endforeach; ?>
			</ul>
	</fieldset>
 
	<p><a href="register.php">Go back to the registration form</a></p>
 
	<?php endif; ?>
	<?php include("footer.php"); ?>
</body>
</html>
