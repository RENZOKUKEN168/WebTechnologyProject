<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantify_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS plantify_db";

if (mysqli_query($conn, $sql)) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($conn);
}


$tables = [

"register" => "CREATE TABLE IF NOT EXISTS register (
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
)",

"contribute" => "CREATE TABLE IF NOT EXISTS contribute (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contributor VARCHAR(25) NOT NULL,
    plantname VARCHAR(25) NOT NULL,
    photo TEXT NULL,
    comments TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)",

"enquiry" => "CREATE TABLE IF NOT EXISTS enquiry (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(254) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    family VARCHAR(50) NULL,
    genus VARCHAR(50) NULL,
    species VARCHAR(50) NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)"
];

foreach ($tables as $name => $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "Table '$name' is ready.<br>";
    } else {
        echo "Error creating '$name': " . mysqli_error($conn) . "<br>";
    }
}

mysqli_close($conn);
?>
