<!DOCTYPE html>
<html>
<head>
    <title>Add Student Information</title>
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
    <h1>Add Student Information</h1>
    <form action="add_data.php" method="post">
        <label for="Student_ID">Student ID</label>
        <input type="text" id="Student_ID" name="Student_ID" required pattern="\d{9}" title="Student ID must be a 9-digit number">
        
        <label for="Student_Name">Student Name</label>
        <input type="text" id="Student_Name" name="Student_Name" required>

        <label for="Course_Code">Course Code</label>
        <input type="text" id="Course_Code" name="Course_Code" required pattern="[A-Za-z]{2}\d{3}" title="Course Code must consist of two letters followed by three numbers">

        <label for="Test1">Test 1 Grade</label>
        <input type="text" id="Test1" name="Test1">

        <label for="Test2">Test 2 Grade</label>
        <input type="text" id="Test2" name="Test2">

        <label for="Test3">Test 3 Grade</label>
        <input type="text" id="Test3" name="Test3">

        <label for="Final_Exam">Final Exam Grade</label>
        <input type="text" id="Final_Exam" name="Final_Exam">

        <input type="submit" value="Add Student Information">
    </form>
    <div>
        <button onclick="location.href = 'home.html';">Go Back</button>
        <button onclick="location.href = 'logout.php';">Logout</button>
    </div>
</body>
</html>
