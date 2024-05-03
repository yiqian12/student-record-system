<?php
// this file is use for update the student mark when user input the update mark
session_start(); 

require 'connect.php'; 

// Initialize error handling and data validation
$error = '';
$studentID = $_POST['Student_ID'] ?? '';
$courseCode = strtoupper(trim($_POST['Course_Code'] ?? ''));
$testType = $_POST['test_type'] ?? '';
$updatedGrade = $_POST['updated_grade'] ?? '';

// Validate input fields
if (empty($studentID)) {
    $error = "Student ID cannot be empty";
} elseif (!preg_match("/^\d{9}$/", $studentID)) {
    $error = "Student ID must be a 9-digit number";
} elseif (empty($courseCode)) {
    $error = "Course ID cannot be empty";
} elseif (!preg_match("/^[A-Za-z]{2}\d{3}$/", $courseCode)) {
    $error = "Course ID must consist of two letters followed by three numbers";
} elseif (empty($testType)) {
    $error = "Must select a test to update the grade for";
} elseif (!isset($updatedGrade) || !is_numeric($updatedGrade)) {
    $error = "Updated grade must be a number";
} elseif ((float)$updatedGrade < 0 || (float)$updatedGrade > 100) {
    $error = "Updated grade must be between 0 and 100";
}

if (!empty($error)) {
    $_SESSION['status'] = $error;
    header('Location: update.php');
    exit;
}

// If validations pass, attempt to update the grade
try {
    $conn->beginTransaction();

// make the test value match the database
    $testField = '';
    switch ($testType) {
        case 'Test1': $testField = 'Test1'; break;
        case 'Test2': $testField = 'Test2'; break;
        case 'Test3': $testField = 'Test3'; break;
        case 'Final_Exam': $testField = 'Final_Exam'; break;
        default: throw new Exception("Invalid test type selected.");
    }

    $sql = "UPDATE Course_Table SET $testField = :updated_grade 
            WHERE Student_ID = :Student_ID AND TRIM(Course_Code) = :Course_Code";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':updated_grade' => $updatedGrade,
        ':Student_ID' => $studentID,
        ':Course_Code' => $courseCode
    ]);

    if ($stmt->rowCount() === 0) {
        throw new Exception("No matching record found to update. Make sure the Student ID and Course Code are correct.");
    }

    $conn->commit(); // Commit the transaction if the update was successful

    // updated results for display
    $sql = "SELECT n.Student_ID, n.Student_Name, c.Course_Code, c.Test1, c.Test2, c.Test3, c.Final_Exam
            FROM Name_Table n JOIN Course_Table c ON n.Student_ID = c.Student_ID
            WHERE c.Student_ID = :Student_ID AND TRIM(c.Course_Code) = :Course_Code";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':Student_ID' => $studentID, ':Course_Code' => $courseCode]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        throw new Exception("Failed to fetch the updated record.");
    }

} catch (PDOException $e) {
    $conn->rollBack(); // Roll back if error
    $error = "Database error: " . $e->getMessage();
} catch (Exception $e) {
    $error = $e->getMessage();
}

if (!empty($error)) {
    $_SESSION['status'] = $error;
    header('Location: update.php');
    exit;
}

// Display the result if no error
?>
<!DOCTYPE html>
<html>
<head>
    <title>Updated Information</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74EBD5 0%, #9FACE6 100%);
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            box-sizing: border-box;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px auto;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            color: #0056b3;
            margin-bottom: 20px; 
        }

        .button-container {
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Updated Information</h1>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Student ID</th>
            <th>Course Code</th>
            <th>Test 1</th>
            <th>Test 2</th>
            <th>Test 3</th>
            <th>Final Exam</th>
        </tr>
        <tr>
            <td><?= htmlspecialchars($result['Student_Name']) ?></td>
            <td><?= htmlspecialchars($result['Student_ID']) ?></td>
            <td><?= htmlspecialchars($result['Course_Code']) ?></td>
            <td><?= htmlspecialchars($result['Test1']) ?></td>
            <td><?= htmlspecialchars($result['Test2']) ?></td>
            <td><?= htmlspecialchars($result['Test3']) ?></td>
            <td><?= htmlspecialchars($result['Final_Exam']) ?></td>
        </tr>
    </table>
    <div class="button-container">
        <!-- Back button (navigate to the previous page) -->
        <button onclick="history.back()" class="button">Back</button>
        <!-- Logout button (navigate to the logout script) -->
        <button onclick="window.location.href='logout.php';" class="button">Logout</button>
    </div>
</body>
</html>