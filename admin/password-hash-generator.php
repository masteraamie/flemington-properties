<?php
// Use this script to generate secure password hashes
// Run this once to generate hashed passwords for your admin users

$passwords = [
    'admin' => 'flemington2025', // Change these
    'editor' => 'editor2025'
];

echo "<h3>Password Hashes for Admin Users:</h3>";
echo "<p>Copy these hashes and use them in your authentication system:</p>";

foreach ($passwords as $username => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "<strong>$username:</strong> $hash<br><br>";
}

echo "<hr>";
echo "<h4>Example usage in admin-login.php:</h4>";
echo "<pre>";
echo "// Replace the simple authentication with:
\$admin_users = [
    'admin' => '\$2y\$10\$example_hash_here',
    'editor' => '\$2y\$10\$another_hash_here'
];

if (isset(\$admin_users[\$username]) && password_verify(\$password, \$admin_users[\$username])) {
    // Login successful
}";
echo "</pre>";
?>
