<?php
    // if (session_status() === PHP_SESSION_NONE) {
    //     session_start();
    // }
    
    $userId = $_SESSION['user_id'];
    $host = 'mysql';
    $user = 'root';
    $pass = 'rootpassword';
    $conn = new mysqli($host, $user, $pass, 'dbtest');
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Retrieve user from the database
    $query = "SELECT * FROM users WHERE id = ".intval($userId)."";
    $result = mysqli_query($conn, $query);
    // Check if user exists and verify password
    if (mysqli_num_rows($result) === 1) {
        $info = mysqli_fetch_assoc($result);
    }

    function logout() {
        // Unset all session variables
        $_SESSION = array();
    
        // Destroy the session
        session_destroy();
    
        // Redirect the user to the login page or any desired page
        header("Location: login.php");
        exit();
    }

?>
<nav class="navbar">
    <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="save.php">Upload</a></li>
    </ul>
    <div>
        Welcome <strong><?php echo $info['username'] ?></strong>
    </div>
    <div>
        <a href="logout.php">logout</a>
    </div>
</nav>