<?php
ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: login.php');
}
?>
<?php include('connect.php');?>

<!DOCTYPE html>
  <html lang="en">
  <head>
  <title>Attendance Management System</title>
  <meta charset="UTF-8">

    <link rel="stylesheet" href="teacher.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" > 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
    <center><h3 id="logo">Teacher List</h3></center>
    <table class="table table=stripped">
        <thead>  
          <tr>
            <th scope="col">Teacher ID</th>
            <th scope="col">Name</th>
            <th scope="col">Department</th>
            <th scope="col">Email</th>
            <th scope="col">Course</th>
          </tr>
        </thead>
      <?php
    $i = 0;
    $tcr_query = mysqli_query($conn, "SELECT * FROM teachers ORDER BY tc_id ASC");

    while($tcr_data = mysqli_fetch_assoc($tcr_query)){
    $i++;
    ?>
      <tbody>
          <tr>
            <td><?php echo $tcr_data['tc_id']; ?></td>
            <td><?php echo $tcr_data['tc_name']; ?></td>
            <td><?php echo $tcr_data['tc_dept']; ?></td>
            <td><?php echo $tcr_data['tc_email']; ?></td>
            <td><?php echo $tcr_data['tc_course']; ?></td>
          </tr>
      </tbody>
    <?php } ?>      
    </table>
  </div>
</div>
</center>

</body>
</html>