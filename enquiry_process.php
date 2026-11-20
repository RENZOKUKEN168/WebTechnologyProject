<?php
session_start();
include "createdatabase_table.php";
require "connection.php";

// make mysqli throw exceptions so the try/catch below works on every PHP version
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// only accept data from enquiry.php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: enquiry.php");
    exit;
}

$firstname = trim($_POST["firstname"] ?? "");
$lastname  = trim($_POST["lastname"] ?? "");
$email     = trim($_POST["email"] ?? "");
$phone     = trim($_POST["phone"] ?? "");
$family    = trim($_POST["family"] ?? "");
$genus     = trim($_POST["genus"] ?? "");
$species   = trim($_POST["species"] ?? "");
$comment   = trim($_POST["comment"] ?? "");

// allowed values for the optional drop-downs (must match enquiry.php)
$allowedFamilies = ["Dipterocarpaceae", "Lauraceae", "Burseraceae", "Myristicaceae", "other"];
$allowedGenera   = ["Vatica", "Dipterocarpus", "Actinodaphne", "Endiandra",
                    "Canarium", "Dacryodes", "Horsfieldia", "Knema", "other"];
$allowedSpecies  = ["Vatica borneensis", "Vatica flavida",
                    "Dipterocarpus alatus", "Dipterocarpus grandiflorus",
                    "Actinodaphne mushaensis", "Actinodaphne wightiana",
                    "Endiandra sieberi", "Endiandra discolor",
                    "Canarium album", "Canarium australasicum",
                    "Dacryodes excelsa", "Dacryodes rostrata",
                    "Horsfieldia irya", "Horsfieldia superba",
                    "Knema attenuata", "Knema conferta", "other"];

// server side validation
$errors = [];

if (!preg_match("/^[A-Za-z ]{1,25}$/", $firstname)) {
    $errors[] = "First name must be 1 to 25 alphabetic characters.";
}
if (!preg_match("/^[A-Za-z ]{1,25}$/", $lastname)) {
    $errors[] = "Last name must be 1 to 25 alphabetic characters.";
}
if ($email === "" || mb_strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address (maximum 254 characters).";
}
if (!preg_match("/^\d{10,11}$/", $phone)) {
    $errors[] = "Phone number must be 10 or 11 digits, with no spaces or hyphens.";
}
if ($family !== "" && !in_array($family, $allowedFamilies, true)) {
    $errors[] = "Please choose a valid family.";
}
if ($genus !== "" && !in_array($genus, $allowedGenera, true)) {
    $errors[] = "Please choose a valid genus.";
}
if ($species !== "" && !in_array($species, $allowedSpecies, true)) {
    $errors[] = "Please choose a valid species.";
}
if (mb_strlen($comment) > 10000) {
    $errors[] = "Comment must be 10,000 characters or fewer.";
}

// saves data to table
$success = false;

if (empty($errors)) {
    try {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO enquiry
             (firstname, lastname, email, phone, family, genus, species, comment)
             VALUES (?, ?, ?, ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''), ?)");
        mysqli_stmt_bind_param($stmt, "ssssssss",
            $firstname, $lastname, $email, $phone, $family, $genus, $species, $comment);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $success = true;
    } catch (mysqli_sql_exception $e) {
        $errors[] = "Sorry, your enquiry could not be saved. Please try again later.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Enquiry confirmation page" />
	<meta name="keywords" content="enquiry, confirmation, plantify" />
	<title>Enquiry Confirmation Page</title>
	<link rel="stylesheet" href="styles/style.css">
</head>
<body class="enquiry-page">
	<?php include("header.php"); ?>

	<h1>Plantify</h1>

	<?php if ($success): ?>

		<h2>Plantify Enquiry Confirmation page</h2>

		<fieldset class="enquiry-form">
			<legend>Your Enquiry</legend>
			<p>Thank you <?php echo htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname); ?>.</p>
			<p>Your enquiry has been saved. Your details are as follows: </p>
			<p>Email: <?php echo htmlspecialchars($email); ?></p>
			<p>Phone number: <?php echo htmlspecialchars($phone); ?></p>
			<?php if ($family !== ""): ?><p>Family: <?php echo htmlspecialchars($family); ?></p><?php endif; ?>
			<?php if ($genus !== ""): ?><p>Genus: <?php echo htmlspecialchars($genus); ?></p><?php endif; ?>
			<?php if ($species !== ""): ?><p>Species: <?php echo htmlspecialchars($species); ?></p><?php endif; ?>
			<?php if ($comment !== ""): ?><p>Comment: <?php echo nl2br(htmlspecialchars($comment)); ?></p><?php endif; ?>
		</fieldset>

		<p><a href="enquiry.php">Send another enquiry</a></p>

	<?php else: ?>

		<h2>Enquiry Failed</h2>

		<fieldset class="enquiry-form">
			<legend>Please fix the following</legend>
			<ul>
				<?php foreach ($errors as $error): ?>
					<li><?php echo htmlspecialchars($error); ?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

		<p><a href="enquiry.php">Go back to the enquiry form</a></p>

	<?php endif; ?>

	<?php include("footer.php"); ?>
</body>
</html>