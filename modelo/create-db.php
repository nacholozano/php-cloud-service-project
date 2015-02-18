<?php

include_once "../conf-db.php";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}

$sql = "CREATE DATABASE " . $dbname . " DEFAULT CHARACTER SET latin1 DEFAULT COLLATE latin1_spanish_ci";

if ($conn->query($sql) === TRUE) {
    echo "Database '" . $dbname . "' created successfully<br>";
} else {
    echo "Error creating database '" . $dbname . "': " . $conn->error . "<br>";
}

$sql = "USE ".$dbname;
if ($conn->query($sql) === TRUE) {
    echo "Using database '" . $dbname . "'<br>";
} else {
    echo "Error using database '" . $dbname . "': " . $conn->error . "<br>";
}

$sql = "CREATE TABLE Users (
user VARCHAR(150) PRIMARY KEY,
password VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'Users' created successfully<br>";
} else {
    echo "Error creating table 'Users': " . $conn->error . "<br>";
}

$conn->close();

?>
