<?php
/**
 * Logout
 * Destroy session and redirect to home
 */

session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Destroy the session
session_destroy();

// Clear remember me cookie if exists
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time()-42000, '/');
}

// Redirect to home with logout message
header("Location: /sgi/?msg=logged_out");
exit;
