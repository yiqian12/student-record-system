<?php
// this file is used for checking the student information by using their ID and course code
session_start();

// display error message if sent back
if(isset($_SESSION['status'])) {
    $message = $_SESSION['status'];
    echo "<script>alert('$message');</script>";

    // reset session variable
    unset($_SESSION['status']);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- name of tab -->
        <title>Select</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #74EBD5 0%, #9FACE6 100%);
                margin: 0;
                padding: 20px;
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                box-sizing: border-box;
            }

            h1 {
                text-align: center;
                color: #0056b3;
            }

            form {
                width: 50%;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                margin: auto;
            }

            input[type=text], input[type=submit], button {
                font-size: 16px;
                padding: 10px;
                margin: 15px;
                width: calc(100% - 30px);
                box-sizing: border-box;
                border-radius: 5px;
                border: 1px solid #ccc;
            }

            input[type=text] {
                background-color: #f8f8f8;
            }

            input[type=submit], button {
                cursor: pointer;
                background-color: #007bff;
                color: white;
                border: none;
            }

            input[type=submit]:hover, button:hover {
                background-color: #0056b3;
            }

            label {
                font-size: 20px;
                margin: 15px;
                text-align: left;
                display: block;
            }
        </style>
    </head>

    <body>
        <h1>Select Information</h1>

        <!-- Buttons for "back" and "log-out" -->
        <div>
            <button onclick="location.href = 'home.html';">Go Back</button>
            <button onclick="location.href = 'logout.php';">Logout</button>
        </div>
        
        <!-- user enters student id, course id to view that student's info -->
        <form action="data.php" method="post">
            <label for="Student_ID">Student ID</label>
            <input type="text" id="Student_ID" name="Student_ID">
            <br>

            <label for="Course_Code">Course Code</label>
            <input type="text" id="Course_Code" name="Course_Code">
            <br>

            <input type="submit" value="Submit Request">
        </form>
    </body>
</html>
