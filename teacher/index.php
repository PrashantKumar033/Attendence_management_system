<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: ../index.php');
}
?>

<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>Attendance Management System</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="teacher.css">
  </head>
<body>

<header>
  <h1>Attendance Management System</h1>
  <div class="navbar">
    <a href="index.php">Home</a>
    <a href="students.php">Students</a>
    <a href="teachers.php">Faculties</a>
    <a href="attendance.php">Attendance</a>
    <a href="report.php">Report</a>
    <a href="../logout.php">Logout</a>
  </div>
</header>

<center>

<div class="row">
  <div class="content">
    <h3 style="color:black">One step solution for your class room :)</h3>
    <img src="../img/tcrl.png" height="200px" width="300px" />
  </div>
</div>
</center>

</body>
</html>
