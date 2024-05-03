<?php
// this file is a page to let user input the student id and course name to update the tudent marks for test
    session_start();

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
        <title>Update Grade</title>
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

            h1 {
                color: #0056b3;
            }

            .radio_buttons {
             margin: 15px;
             display: flex; 
             justify-content: space-around; 
              flex-wrap: wrap; 
         }

             .radio_buttons label {
              margin-right: 10px; 
         }

             .radio_buttons input[type=radio] {
              margin-right: 5px; 
         }
            form {
                width: 50%;
                margin: auto;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            input[type=text], input[type=submit], button {
                font-size: 16px;
                padding: 10px;
                margin: 10px 0;
                width: calc(100% - 20px);
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
                display: block;
                margin: 15px 0;
                color: #000;
            }
        </style>
    </head>
    <body>
        <h1>Update Information</h1>

        <div class="navi_buttons">
            <button onclick="location.href = 'home.html';">Go Back</button>
            <button onclick="location.href = 'logout.php';">Logout</button>
        </div>

        <form action="update_data.php" method="post">
            <label for="Student_ID">Student ID</label>
            <input type="text" id="Student_ID" name="Student_ID">

            <label for="Course_Code">Course Code</label>
            <input type="text" id="Course_Code" name="Course_Code">

            <label>Select Test To Update</label>
            <div class="radio_buttons">
                <input type="radio" id="Test1" name="test_type" value="Test1">
                <label for="Test1">Test 1</label>
                <input type="radio" id="Test2" name="test_type" value="Test2">
                <label for="Test2">Test 2</label>
                <input type="radio" id="Test3" name="test_type" value="Test3">
                <label for="Test3">Test 3</label>
                <input type="radio" id="Final_Exam" name="test_type" value="Final_Exam">
                <label for="Final_Exam">Final Exam</label>
            </div>

            <label for="updated_grade">Updated Grade</label>
            <input type="text" id="updated_grade" name="updated_grade">

            <input type="submit" value="Submit Request">
        </form>
    </body>
</html>
