<?php
// this file is used for detele the student info from database
session_start();

// Include the database connection script
require 'connect.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Data validation
    if (empty($_POST['Student_ID'])) {
        $message = "Student ID cannot be empty";
    } elseif (!is_numeric($_POST['Student_ID']) || strlen((string)$_POST['Student_ID']) != 9) {
        $message = "Student ID must be a 9-digit number";
    } else {
        // If validations pass, attempt to delete the student information
        try {
            $conn->beginTransaction();
        //delete from course table and name table
            $sql = "DELETE FROM Course_Table WHERE Student_ID = :Student_ID";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':Student_ID', $_POST['Student_ID'], PDO::PARAM_STR);
            $stmt->execute();

            $sql = "DELETE FROM Name_Table WHERE Student_ID = :Student_ID";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':Student_ID', $_POST['Student_ID'], PDO::PARAM_STR);
            $stmt->execute();

            $conn->commit(); // Commit the transaction

            $message = "Student information successfully deleted.";

        } catch (PDOException $e) {
            $conn->rollBack(); // Roll back the transaction on error
            $message = "Error: " . $e->getMessage();
        }
    }

    // Store message in session and redirect
    $_SESSION['status'] = $message;
    header('Location: delete.php');
    exit;
}

?>

