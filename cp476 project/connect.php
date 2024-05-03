<?php
//This file is using to connect to the database
$servername = "localhost:3306";  //enter you self info from your database
$username = "your username";
$password = "your password";

try {
  $conn = new PDO("mysql:host=$servername;dbname=CP476", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

