<?php
    session_start();
    require "connection.php";
    mysqli_report(MYSQLI_REPORT_OFF);
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS enquiry (id INT AUTO_INCREMENT PRIMARY KEY, firstname VARCHAR(25) NOT NULL, lastname VARCHAR(25) NOT NULL, email VARCHAR(254) NOT NULL, phone VARCHAR(11) NOT NULL, family VARCHAR(40) NULL, genus VARCHAR(40) NULL, species VARCHAR(80) NULL, comment TEXT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, is_read TINYINT(1) NOT NULL DEFAULT 0, admin_reply TEXT NULL, replied_at DATETIME NULL)");
    $enquiryMessage = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $first = trim((string)($_POST["firstname"] ?? "")); $last = trim((string)($_POST["lastname"] ?? ""));
        $email = trim((string)($_POST["email"] ?? "")); $phone = trim((string)($_POST["phone"] ?? ""));
        $family = trim((string)($_POST["family"] ?? "")); $genus = trim((string)($_POST["genus"] ?? ""));
        $species = trim((string)($_POST["species"] ?? "")); $comment = trim((string)($_POST["comment"] ?? ""));
        if ($first === "" || $last === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/^[0-9]{10,11}$/", $phone)) {
            $enquiryMessage = "Please check your name, email and phone number.";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO enquiry (firstname, lastname, email, phone, family, genus, species, comment) VALUES (?, ?, ?, ?, NULLIF(?,''), NULLIF(?,''), NULLIF(?,''), ?)");
            mysqli_stmt_bind_param($stmt, "ssssssss", $first, $last, $email, $phone, $family, $genus, $species, $comment);
            $enquiryMessage = mysqli_stmt_execute($stmt) ? "Your enquiry was sent. Thank you." : "Your enquiry could not be saved. Please try again.";
        }
    }
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
	<title>Enquiry Form</title>
</head>
<body class="enquiry-page"> 
	 <?php
        include("header.php");
        ?>
	<form id="form" method="post" class="enquiry-form">
		<h2>Got any enquiries?<br>Please drop them below.</h2>
        <?php if ($enquiryMessage !== ""): ?><p class="admin-message" role="status"><?= htmlspecialchars($enquiryMessage, ENT_QUOTES, "UTF-8") ?></p><?php endif; ?>
		<fieldset>
			<legend>Username</legend>
			<p>
				<label for="firstname">First Name*</label>
				<input type="text" id="firstname" name="firstname" maxlength="25" pattern="[A-Za-z ]+" title="Use alphabetic characters only." placeholder="Enter your first name" required>
				<label for="lastname">Last Name*</label>
				<input type="text" id="lastname" name="lastname" maxlength="25" pattern="[A-Za-z ]+" title="Use alphabetic characters only." placeholder="Enter your last name" required>
			</p>
			<p>
				<label for="email">Email Address*</label>
				<input type="email" id="email" name="email" placeholder="example@gmail.com" required>
			</p>
			<p>
				<label for="phone">Phone Number*</label>
				<input type="tel" id="phone" name="phone" maxlength="11" pattern="[0-9]{10,11}" title="Enter 10 or 11 digits, no spaces or hyphens." placeholder="e.g. 0123456789" required>
			</p>
		</fieldset>
		<fieldset>
			<legend>Enquiry</legend>
			<p>
				<label for="family">Family</label>
				<select id="family" name="family">
					<option value="">Please select</option>
					<option value="Dipterocarpaceae">Dipterocarpaceae</option>
					<option value="Lauraceae">Lauraceae</option>
					<option value="Burseraceae">Burseraceae</option>
					<option value="Myristicaceae">Myristicaceae</option>
					<option value="other">Other</option>
				</select>
				<label for="genus">Genera</label>
				<select id="genus" name="genus">
					<option value="">Please select</option>
					<option value="Vatica">Vatica</option>
					<option value="Dipterocarpus">Dipterocarpus</option>
					<option value="Actinodaphne">Actinodaphne</option>
					<option value="Endiandra">Endiandra</option>
					<option value="Canarium">Canarium</option>
					<option value="Dacryodes">Dacryodes</option>
					<option value="Horsfieldia">Horsfieldia</option>
					<option value="Knema">Knema</option>
					<option value="other">Other</option>
				</select>
				<label for="species">Species</label>
				<select id="species" name="species">
					<option value="">Please select</option>
					<option value="Vatica borneensis">Vatica borneensis</option>
					<option value="Vatica flavida">Vatica flavida</option>
					<option value="Dipterocarpus alatus">Dipterocarpus alatus</option>
					<option value="Dipterocarpus grandiflorus">Dipterocarpus grandiflorus</option>
					<option value="Actinodaphne mushaensis">Actinodaphne mushaensis</option>
					<option value="Actinodaphne wightiana">Actinodaphne wightiana</option>
					<option value="Endiandra sieberi">Endiandra sieberi</option>
					<option value="Endiandra discolor">Endiandra discolor</option>
					<option value="Canarium album">Canarium album</option>
					<option value="Canarium australasicum">Canarium australasicum</option>
					<option value="Dacryodes excelsa">Dacryodes excelsa</option>
					<option value="Dacryodes rostrata">Dacryodes rostrata</option>
					<option value="Horsfieldia irya">Horsfieldia irya</option>
					<option value="Horsfieldia superba">Horsfieldia superba</option>
					<option value="Knema attenuata">Knema attenuata</option>
					<option value="Knema conferta">Knema conferta</option>
					<option value="other">Other</option>
				</select>
			</p>
		</fieldset>
		<label for="comment">Comment</label><br>
		<textarea id="comment" name="comment" placeholder="Write your enquiry here..." rows="6" cols="60"></textarea>
		<input type="submit" value="Submit">
		<input type="reset" value="Reset">
	</form>
	<?php
        include("footer.php");
        ?>
</body>
</html>
