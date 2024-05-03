CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS Name_Table (
    Student_Id VARCHAR(9) NOT NULL,
    Student_Name VARCHAR(50) NOT NULL,
    UNIQUE(Student_Id),
    PRIMARY KEY(Student_Id)
);

CREATE TABLE IF NOT EXISTS Course_Table (
    Student_Id VARCHAR(9) NOT NULL,
    Course_Code VARCHAR(10) NOT NULL,
    Test1 FLOAT DEFAULT 0,
    Test2 FLOAT DEFAULT 0,
    Test3 FLOAT DEFAULT 0,
    Final_Exam FLOAT DEFAULT 0,
    FOREIGN KEY(Student_Id) REFERENCES Name_Table(Student_Id)
);
UPDATE Course_Table SET Course_Code = TRIM(Course_Code);
