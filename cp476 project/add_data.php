<?php
// this file is use for add the student info when user input the info
session_start();

require 'connect.php';

$studentID = $_POST['Student_ID'] ?? '';
$studentName = $_POST['Student_Name'] ?? '';
$courseCode = strtoupper(trim($_POST['Course_Code'] ?? ''));
$test1 = $_POST['Test1'] ?? NULL;
$test2 = $_POST['Test2'] ?? NULL;
$test3 = $_POST['Test3'] ?? NULL;
$finalExam = $_POST['Final_Exam'] ?? NULL;

// Validate input fields
if (empty($studentID) || !preg_match("/^\d{9}$/", $studentID)) {
    $_SESSION['status'] = "Invalid Student ID";
    header('Location: add.php');
    exit;
} elseif (empty($studentName)) {
    $_SESSION['status'] = "Student Name cannot be empty";
    header('Location: add.php');
    exit;
} elseif (empty($courseCode) || !preg_match("/^[A-Za-z]{2}\d{3}$/", $courseCode)) {
    $_SESSION['status'] = "Invalid Course Code";
    header('Location: add.php');
    exit;
}

try {
    // Insert Student Info
    $sql = "INSERT INTO Name_Table (Student_ID, Student_Name) VALUES (:Student_ID, :Student_Name)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':Student_ID' => $studentID, ':Student_Name' => $studentName]);

    // Insert Course and Grades
    $sql = "INSERT INTO Course_Table (Student_ID, Course_Code, Test1, Test2, Test3, Final_Exam) VALUES (:Student_ID, :Course_Code, :Test1, :Test2, :Test3, :Final_Exam)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':Student_ID' => $studentID,
        ':Course_Code' => $courseCode,
        ':Test1' => $test1,
        ':Test2' => $test2,
        ':Test3' => $test3,
        ':Final_Exam' => $finalExam
    ]);

    $_SESSION['status'] = "Student Information Added Successfully";
    header('Location: add.php');
} catch (PDOException $e) {
    $_SESSION['status'] = "Database error: " . $e->getMessage();
    header('Location: add.php');
    exit;
}
