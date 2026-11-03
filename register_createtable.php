<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantify_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    city VARCHAR(20) NOT NULL,
    state ENUM('Johor','Kedah','Kelantan','Melaka','Negeri Sembilan','Pahang',
               'Penang','Perak','Perlis','Sabah','Sarawak','Selangor',
               'Terengganu','Kuala Lumpur','Labuan','Putrajaya') NOT NULL,
    postcode CHAR(5) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table register created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>