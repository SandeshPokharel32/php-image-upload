<?php
session_start();
if ($_SESSION['user_id']) {
    header("Location: index.php");
    exit();  
}
// Establish database connection
$host = 'mysql';
$user = 'root';
$pass = 'rootpassword';
$conn = new mysqli($host, $user, $pass, 'dbtest');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user into the database
    $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    mysqli_query($conn, $query);
    
    // Redirect to login page
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="Stylesheet" href="./assets/style.css"></link>
</head>
<body>
    <?php include 'nav.php'; ?>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>