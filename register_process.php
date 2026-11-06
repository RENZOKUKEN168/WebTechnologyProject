<?php
	$servername = "localhost";
	$username   = "root";
	$password   = "";
	$dbname     = "plantify_db";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$phone = $_POST['phone'];
	$username = $_POST['username'];
	$password = $_POST['password'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $postcode = $_POST['postcode'];


	$sql = "INSERT INTO register (firstname, lastname, phone, username, password, street_address, city, state, postcode) 
    VALUES ('$firstname', '$lastname', '$phone', '$username', '$passowrd', '$street_address', '$city', '$state', '$postcode')";

	mysqli_query($conn, $sql);
	mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="description" content="Rohirrim Booking Form" />
	<meta name="keywords"    content=" " />
	<title>Registration Coonfirmation Page</title>
</head>

<body>
	<h1>Plantify</h1>
	<h2>Plantify Registration Confirmation page</h2>

	
<?php
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
?>

<form id="Confirmform">
	
	<fieldset>
		<legend>Your Details</legend>
		 <p>Welcome <?php echo $firstname; echo ' '; echo $lastname; ?></p>
		 <p>Your account has been registered. Your details are as followed: </p>
		 <p>Phone number: <?php echo $_POST['phone']; ?></p>
		 <p>Meal preferences: <?php echo $_POST['food']; ?></p>
		 <p>Number of travellers: <?php echo $_POST['partySize']; ?></p>
	</fieldset>
</form>
	
</body>
</html>