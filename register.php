<?php
    session_start();
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="description" content="registration form">
<title>Registration form</title>

<link rel="stylesheet" href="styles/style.css">


</head>
<body class="register-page">
    <?php
        include("header.php")
        ?>

<form id="form" method="post" action="register_process.php" class="register-form">
    <h2>Create an Account</h2>
    <fieldset>
        
        <legend>Personal information: </legend>
        <p>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" maxlength="25" pattern="[A-Za-z\s]+" title="Alphabetical characters only" required>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" maxlength="25" pattern="[A-Za-z\s]+" title="Alphabetical characters only" required>
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" maxlength="10" placeholder="e.g. 0123456789" pattern="\d{1,10}" title="Maximum of 10 digits" required>
        </p>
        <p>
            <label for="username"><strong>Username/email:</strong></label>
            <input type="text" id="username" name="username" maxlength="50" required>
            <label for="password"><strong>Password:</strong></label>
            <input type="password" id="password" name="password" minlength="8" maxlength="20" required>
        </p>
        <p>
            <label for="stadd">Street Address:</label>
            <input type="text" id="stadd" name="street address" maxlength="40" required>
        </p>
        <p>
            <label for="city">City/Town:</label>
            <input type="text" id="city" name="city" maxlength="20" required>

        </p>
		<p>
				<label for="state">State:</label>
				<select id="state" name="state" required>
					<option value="">-- Select State / Federal Territory --</option>
					<option value="Johor">Johor</option>
					<option value="Kedah">Kedah</option>
					<option value="Kelantan">Kelantan</option>
                    <option value="Melaka">Melaka</option>
					<option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
					<option value="Perlis">Perlis</option>
                    <option value="Sabah">Sabah</option>
					<option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
					<option value="Labuan">Labuan</option>
                    <option value="Putrajaya">Putrajaya</option>
                </select>
            </p>
			<p>
                <label for="postcode">Postcode:</label>
                <input type="text" id="postcode" name="postcode" pattern="\d{5}" maxlength="5" title="Must be exactly 5 digits" required>
            </p>
        </fieldset>

        <input type="submit" value="Submit">
	    <input type="reset" value="Reset">

		<div>
			<p>Already have an account? <a href="login.php">Sign in</a>.</p>
		</div>

  
</form>
    <?php
        include("footer.php");
        ?>
</body>

</html>
