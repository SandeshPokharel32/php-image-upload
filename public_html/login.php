<?php
require_once './auth.php';


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'mysql';
    $user = 'root';
    $pass = 'rootpassword';
    $conn = new mysqli($host, $user, $pass, 'dbtest');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Retrieve user from the database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    // Check if user exists and verify password
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Start a session and store user information
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php');
            exit();
        }
    }
    
    // Invalid username or password
    echo "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="Stylesheet" href="./assets/style.css"></link>
<body>
    <?php include 'nav.php'; ?>
    <h2>Login</h2>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>