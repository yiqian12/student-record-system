<?php
// This file is for check the user's password and id does match the user info from database
// Using the hash code (password) for sucurity 
session_start();

// Check if the required POST data is available
if (!isset($_POST['db_user']) || !isset($_POST['db_pass'])) {
    header('Location: login.html?error=Username and password are required.');
    exit();
}

// Database connection 
$host = "localhost:3306";
$database = "CP476"; //your database name
$db_user = "your name"; 
$db_pass = "your password"; 

try {
    // Establish database connection
    $conn = new PDO("mysql:host=$host;dbname=$database", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the user's hashed password from the database
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
    $stmt->execute([$_POST['db_user']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the submitted password against the stored hash
    if ($user && password_verify($_POST['db_pass'], $user['password_hash'])) {
        // successful
        header('Location: home.html');
        exit;
    } else {
        // failed
        header('Location: login.html?error=Invalid username or password.');
        exit();
    }
} catch (PDOException $e) {
    // Connection or execution error
    header('Location: login.html?error=Connection failed: Unable to connect to the database.');
    exit();
}
?>
