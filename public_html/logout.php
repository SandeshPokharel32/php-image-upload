<?php
// Start the session
session_start();

// Function to logout the user
function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page or any desired page
    header("Location: login.php");
    exit();
}

// Call the logout function
logout();
