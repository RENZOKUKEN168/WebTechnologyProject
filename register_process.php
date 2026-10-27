<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt = mysqli_prepare($conn,
    "INSERT INTO register (firstname, lastname, phone, username, password, street_address, city, state, postcode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sssssssss",
    $_POST["firstname"], $_POST["lastname"], $_POST["phone"],
    $_POST["username"], $password_hash,
    $_POST["street_address"], $_POST["city"], $_POST["state"], $_POST["postcode"]);

if (mysqli_stmt_execute($stmt)) {
    echo "Registration successful! <a href='login.php'>Sign in</a>";
} else {
    echo "Error: could not register (the username may already be taken).";
}
?>