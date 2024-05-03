<?php
// this file use for check the database and user's input to given the result
session_start();

require 'connect.php';

// Initialize a variable to hold messages or errors
$message = "";

// Data validation
if (empty($_POST['Student_ID'])) {
    $message = "Student ID cannot be empty";
} elseif (!is_numeric($_POST['Student_ID']) || strlen((string)$_POST['Student_ID']) != 9) {
    $message = "Student ID must be a 9-digit number";
} elseif (empty($_POST['Course_Code'])) {
    $message = "Course ID cannot be empty";
} elseif (!preg_match("/^[A-Za-z]{2}\d{3}$/", $_POST['Course_Code'])) {
    $message = "Course ID must consist of two letters followed by three numbers";
}

if (!empty($message)) {
    $_SESSION['status'] = $message;
    header('Location: select.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Info</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74EBD5 0%, #9FACE6 100%);
            color: #333;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            color: #0056b3;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 25px 0;
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
    <h1>Selected Information</h1>
    <?php
    try {
        $stmt = $conn->prepare("SELECT n.Student_ID, n.Student_Name, c.Course_Code, c.Test1, c.Test2, c.Test3, c.Final_Exam FROM Name_Table n INNER JOIN Course_Table c ON n.Student_ID = c.Student_ID WHERE n.Student_ID = :Student_ID AND TRIM(c.Course_Code) = :Course_Code");
        $stmt->bindValue(':Student_ID', $_POST['Student_ID'], PDO::PARAM_INT);
        $stmt->bindValue(':Course_Code', strtoupper(trim($_POST['Course_Code'])), PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            echo "<table>
                    <tr>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Course Code</th>
                        <th>Test 1</th>
                        <th>Test 2</th>
                        <th>Test 3</th>
                        <th>Final Exam</th>
                    </tr>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>".htmlspecialchars($row['Student_Name'])."</td>
                        <td>".htmlspecialchars($row['Student_ID'])."</td>
                        <td>".htmlspecialchars($row['Course_Code'])."</td>
                        <td>".htmlspecialchars($row['Test1'])."</td>
                        <td>".htmlspecialchars($row['Test2'])."</td>
                        <td>".htmlspecialchars($row['Test3'])."</td>
                        <td>".htmlspecialchars($row['Final_Exam'])."</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found for Student ID ".htmlspecialchars($_POST['Student_ID'])." and Course Code ".htmlspecialchars($_POST['Course_Code']).".</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
<div class="button-container">
        <!-- Back button (navigate to the previous page) -->
        <button onclick="history.back()">Back</button>
        <!-- Logout button (navigate to the logout script) -->
        <button onclick="window.location.href='logout.php';">Logout</button>
    </div>
</body>
</html>
