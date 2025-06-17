<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page with success message
header('Location: admin-login?logout=1');
exit;
?>
