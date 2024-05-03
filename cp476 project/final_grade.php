<?php
    session_start();

    // connect to database (include)
    include("connect.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Final Grades</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #74EBD5 0%, #9FACE6 100%);
                margin: 0;
                padding: 20px;
                box-sizing: border-box;
            }

            h1 {
                text-align:center;
                margin-left: 15px;
            }

            div {
                width: 100%;
                text-align: center;
                display: inline-block;
            }

            button {
                margin-bottom: 25px;
                padding: 10px 24px;
                text-align: center;
                font-size:16px;
                border: none;
                border-radius: 5px;
                background-color: #007bff;
                color: white;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            button:hover {
                background-color: #0056b3;
            }

            table {
                border: 1px solid black;
                border-collapse: collapse;
                width: 80%;
                padding: "10";
                table-layout: fixed;
                margin-left: auto;
                margin-right: auto;
            }

            th {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
                font-size: 20px;
                padding: 10px;
                background-color: #e7e7e7;
            }

            td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
                font-size:18px;
                padding: 10px;
            }
        </style>
    </head>

    <body>
        <h1>Final Grades</h1>

        <div>
            <button onclick="location.href = 'home.html';">Go Back</button>
            <button onclick="location.href = 'logout.php';">Logout</button>
        </div>

        <!-- table to display results -->
        <table>
            <!-- header -->
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Course Code</th>
                <th>Final Grade</th> 
            </tr>

            <?php
                // calculation format
                try {
                    // create query
                    $query = "SELECT n.Student_ID, n.Student_Name, c.Course_Code, (c.Test1*0.2 + c.Test2*0.2 + c.Test3*0.2 + c.Final_Exam*0.4) as Final_Grade 
                        FROM Name_Table n, Course_Table c 
                        WHERE n.Student_ID = c.Student_ID";
                    $stat = $conn->prepare($query);
                    // execute query in database
                    $stat->execute();
                    // get results of query
                    $result = $stat -> fetchAll(PDO::FETCH_ASSOC);
                    
                    // iterate through query results
                    foreach($result as $grade) {
            ?>

            <!-- display result -->
            <tr>
                <td><?php echo $grade['Student_ID']; ?> </td>
                <td><?php echo $grade['Student_Name']; ?> </td>
                <td><?php echo $grade['Course_Code']; ?> </td>
                <!-- only display one decimal -->
                <td><?php echo number_format($grade['Final_Grade'],1); ?> </td>
            </tr>

            <?php
                    }
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
         </body>
</html>