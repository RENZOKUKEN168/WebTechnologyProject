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
	<title>Enquiry Form</title>
</head>
<body class="enquiry-page"> 
	 <?php
        include("header.php");
        ?>
	<form id="form" method="post" class="enquiry-form">
		<h2>Got any enquiries?<br>Please drop them below.</h2>
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
