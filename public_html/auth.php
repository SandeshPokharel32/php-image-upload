<?php
function authenticateUser($username, $password) {
    if ($username === 'admin' && $password === 'password') {
        return true;
    } else {
        return false;
    }
}

function loginUser($username) {
    setcookie('loggedIn', 'true', time() + (86400 * 30), '/'); // Set the cookie for 30 days
    setcookie('username', $username, time() + (86400 * 30), '/'); // Set the username cookie
}

function logoutUser() {
    setcookie('loggedIn', '', time() - 3600, '/'); // Delete the loggedIn cookie
    setcookie('username', '', time() - 3600, '/'); // Delete the username cookie
}

function isUserLoggedIn() {
    return isset($_COOKIE['loggedIn']) && $_COOKIE['loggedIn'] === 'true';
}

function getCurrentUsername() {
    return isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
}

?>