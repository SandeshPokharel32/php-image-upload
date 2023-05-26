<?php
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass, 'dbtest');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop the tables if they exist
if ($conn->query("DROP TABLE IF EXISTS files, users") === true) {
    echo "Tables dropped successfully.";
} else {
    echo "Error dropping tables: " . $conn->error;
}

// SQL query to create the users table
$userSchema = "CREATE TABLE users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                background LONGBLOB,
                hobbies VARCHAR(255),
                profile LONGBLOB,
                description VARCHAR(255)
            )";

// Execute the SQL query to create the users table
if ($conn->query($userSchema) === true) {
    echo "Users Table created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

// SQL query to create the files table
$sql = "CREATE TABLE IF NOT EXISTS files (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            type VARCHAR(50) NOT NULL,
            size INT(11) NOT NULL,
            data LONGBLOB NOT NULL,
            users_id INT(11) UNSIGNED NOT NULL,
            FOREIGN KEY (users_id) REFERENCES users(id)
        )";

// Execute the SQL query to create the files table
if ($conn->query($sql) === true) {
    echo "Files Table created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();