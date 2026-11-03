<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "plantify_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE TABLE IF NOT EXISTS enquiry (
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
)";

if (mysqli_query($conn, $sql)) {
    echo "Table register created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);
?>