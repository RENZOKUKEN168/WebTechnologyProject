<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantify_db";

$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname")) {
    die("Error creating database: " . mysqli_error($conn));
}
mysqli_select_db($conn, $dbname);

$tables = [
    "admin" => "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
    )",

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
    family ENUM('Dipterocarpaceae','Lauraceae','Burseraceae','Myristicaceae','other') NULL,
    genus ENUM('Vatica','Dipterocarpus','Actinodaphne','Endiandra','Canarium',
               'Dacryodes','Horsfieldia','Knema','other') NULL,
    species ENUM('Vatica borneensis','Vatica flavida',
                 'Dipterocarpus alatus','Dipterocarpus grandiflorus',
                 'Actinodaphne mushaensis','Actinodaphne wightiana',
                 'Endiandra sieberi','Endiandra discolor',
                 'Canarium album','Canarium australasicum',
                 'Dacryodes excelsa','Dacryodes rostrata',
                 'Horsfieldia irya','Horsfieldia superba',
                 'Knema attenuata','Knema conferta','other') NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($tables as $name => $sql) {
    if (!mysqli_query($conn, $sql)) {
        die("Error creating $name table: " . mysqli_error($conn));
    }
}

if (!mysqli_query($conn, "INSERT IGNORE INTO admin (username, password) VALUES ('admin', 'admin')")) {
    die("Error creating default admin account: " . mysqli_error($conn));
}

mysqli_close($conn);
?>
