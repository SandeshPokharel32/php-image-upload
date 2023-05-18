<?php
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass, 'dbtest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the files table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS files (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(50) NOT NULL,
            size INT(11) NOT NULL,
            data LONGBLOB NOT NULL
        )";

// Execute the SQL query
if ($conn->query($sql) === true) {
    echo "Table created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>