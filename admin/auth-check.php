<?php
// Include this file at the top of protected admin pages
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin-login.php');
    exit;
}

// Check session timeout (optional - 2 hours)
$session_timeout = 2 * 60 * 60; // 2 hours in seconds
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $session_timeout) {
    session_destroy();
    header('Location: admin-login.php?timeout=1');
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>
