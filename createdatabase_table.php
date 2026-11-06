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
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    "contribute" => "CREATE TABLE IF NOT EXISTS contribute (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contributor VARCHAR(25) NOT NULL,
    plantname VARCHAR(25) NOT NULL,
    photos TEXT NULL,
    comments TEXT NULL,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    committed_at DATETIME NULL
    )",

    "enquiry" => "CREATE TABLE IF NOT EXISTS enquiry (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    email VARCHAR(254) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    family VARCHAR(40) NULL,
    genus VARCHAR(40) NULL,
    species VARCHAR(80) NULL,
    comment TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    admin_reply TEXT NULL,
    replied_at DATETIME NULL
    )"
];

foreach ($tables as $name => $sql) {
    if (!mysqli_query($conn, $sql)) {
        die("Error creating $name table: " . mysqli_error($conn));
    }
}

$contributeColumns = [
    "photos" => "ALTER TABLE contribute ADD COLUMN photos TEXT NULL",
    "status" => "ALTER TABLE contribute ADD COLUMN status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending'",
    "committed_at" => "ALTER TABLE contribute ADD COLUMN committed_at DATETIME NULL"
];

foreach ($contributeColumns as $column => $sql) {
    $check = mysqli_query($conn, "SHOW COLUMNS FROM contribute LIKE '$column'");
    if ($check && mysqli_num_rows($check) === 0) {
        if (!mysqli_query($conn, $sql)) {
            die("Error updating contribute table: " . mysqli_error($conn));
        }
    }
}

$registerRole = mysqli_query($conn, "SHOW COLUMNS FROM register LIKE 'role'");
if ($registerRole && mysqli_num_rows($registerRole) === 0) {
    if (!mysqli_query($conn, "ALTER TABLE register ADD COLUMN role ENUM('user','admin') NOT NULL DEFAULT 'user'")) {
        die("Error updating register table: " . mysqli_error($conn));
    }
}

$enquiryColumns = [
    "is_read" => "ALTER TABLE enquiry ADD COLUMN is_read TINYINT(1) NOT NULL DEFAULT 0",
    "admin_reply" => "ALTER TABLE enquiry ADD COLUMN admin_reply TEXT NULL",
    "replied_at" => "ALTER TABLE enquiry ADD COLUMN replied_at DATETIME NULL"
];

foreach ($enquiryColumns as $column => $sql) {
    $check = mysqli_query($conn, "SHOW COLUMNS FROM enquiry LIKE '$column'");
    if ($check && mysqli_num_rows($check) === 0) {
        if (!mysqli_query($conn, $sql)) {
            die("Error updating enquiry table: " . mysqli_error($conn));
        }
    }
}

$enquiryTextColumns = [
    "family" => "ALTER TABLE enquiry MODIFY family VARCHAR(40) NULL",
    "genus" => "ALTER TABLE enquiry MODIFY genus VARCHAR(40) NULL",
    "species" => "ALTER TABLE enquiry MODIFY species VARCHAR(80) NULL"
];

foreach ($enquiryTextColumns as $column => $sql) {
    $check = mysqli_query($conn, "SHOW COLUMNS FROM enquiry LIKE '$column'");
    $definition = $check ? mysqli_fetch_assoc($check) : null;
    if ($definition && stripos((string)$definition["Type"], "varchar(") !== 0) {
        if (!mysqli_query($conn, $sql)) {
            die("Error updating enquiry table: " . mysqli_error($conn));
        }
    }
}

$legacyPhotoColumn = mysqli_query($conn, "SHOW COLUMNS FROM contribute LIKE 'photo'");
if ($legacyPhotoColumn && mysqli_num_rows($legacyPhotoColumn) > 0) {
    mysqli_query(
        $conn,
        "UPDATE contribute
         SET photos = CONCAT('[', JSON_QUOTE(photo), ']')
         WHERE photo IS NOT NULL AND photo <> '' AND (photos IS NULL OR photos = '')"
    );
}

if (!mysqli_query($conn, "INSERT IGNORE INTO admin (username, password) VALUES ('admin', 'admin')")) {
    die("Error creating default admin account: " . mysqli_error($conn));
}

mysqli_close($conn);
?>
