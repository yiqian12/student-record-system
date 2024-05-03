<?php
// This file is for user can register from the html, then after sent to the database the user's password will be hash code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming $_POST['new_username'] and $_POST['new_password'] provided by a register html

    $new_username = $_POST['new_username']; // User's chosen username  //alphabet only 
    $new_password = $_POST['new_password']; // User's chosen password  //alphabet only 
    // Hash the new password for security
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
//if you dont want the username or pass be alphabet, change the sql file. (sql->start.sql) 
    try {
        $host = "localhost:3306";
        $database = "CP476";
        $db_user = "root"; // Replace with your database username
        $db_pass = "62538485kyq"; // Replace with your database password

        $conn = new PDO("mysql:host=$host;dbname=$database", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the new user into the database with the hashed password
        $sql = "INSERT INTO users (username, password_hash) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute([$new_username, $password_hash])) {
            // After successful registration, redirect to login.html
            header("Location: login.html");
            exit();
        } else {
            echo "Failed to register the user.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // If accessed without POST (test only, no need)
    echo '<form method="POST">
            <label for="new_username">Username:</label>
            <input type="text" id="new_username" name="new_username" required>
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <input type="submit" value="Register">
          </form>';
}
?>
