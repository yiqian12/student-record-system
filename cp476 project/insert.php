<?php
//This file is for upload the file data to your database and created the table if not exist in your database
    // Connect to database
   include("connect.php");

   try {
    $schemaSql = file_get_contents('/opt/homebrew/var/mysql/start.sql'); //Enter the file path from you computer 
    foreach (explode(';', $schemaSql) as $sql) {  //This part is use for add the Table to you own database
        if (trim($sql)) {
            $conn->exec($sql);
        }
    }
    echo "Database schema initialized successfully.\n";
} catch (PDOException $e) {
    echo "Error initializing database schema: " . $e->getMessage() . "\n";
    exit;
}
    function get_lines($fh) {  //Read data from a file and yield each line as an array of items, split by commas
        while (!feof($fh)) {
            yield explode(',', fgets($fh));
        }
    }

    // Read data files
    $course_file = fopen('/opt/homebrew/var/cp476/CourseFile.txt', 'r');
    $name_file = fopen('/opt/homebrew/var/cp476/NameFile.txt', 'r');

    // Delete existing tables
    try {
        $sql = file_get_contents('/opt/homebrew/var/mysql/delete.sql');
        echo $sql .'\n';
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . '\r\n'. $e->getMessage();
    }

    // Create db schema
    try {
        $sql = file_get_contents('/opt/homebrew/var/mysql/start.sql');
        echo $sql .'\n';
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo $sql . '\r\n'. $e->getMessage();
    }

    // Insert data
    $sql = $conn->prepare('INSERT INTO Name_Table (Student_ID, Student_Name) VALUES (?, ?)');
    foreach (get_lines($name_file) as $row) {
        if (count($row) > 1) {
            $sql->bindValue(1, $row[0]);
            $sql->bindValue(2, trim($row[1]));
            $sql->execute();
        }
        
    }

    $sql = $conn->prepare('INSERT INTO Course_Table (Student_ID, Course_Code, Test1, Test2, Test3, Final_Exam) VALUES (?, ?, ?, ?, ?, ?)');
    foreach(get_lines($course_file) as $row) {
        if (count($row) > 1) {
            $sql->bindValue(1, $row[0]);
            $sql->bindValue(2, $row[1]);
            $sql->bindValue(3, $row[2]);
            $sql->bindValue(4, $row[3]);
            $sql->bindValue(5, $row[4]);
            $sql->bindValue(6, $row[5]);
            $sql->execute();
        }
    }

    fclose($course_file);
    fclose($name_file);

    $conn = null;
?>
