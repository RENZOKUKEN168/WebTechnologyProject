<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantify_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS contribute (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contributor VARCHAR(25) NOT NULL,
    plantname VARCHAR(25) NOT NULL,
    photo TEXT NULL,
    comments TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table register created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>