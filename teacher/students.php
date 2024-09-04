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

</style>

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
    <center><h3 id="logo">Student List</h3></center>
    <br>
    <form method="post" action="">
      <label>Batch (ex. 2020)</label>
      <input type="text" name="sr_batch" placeholder="Enter year">
      <input type="submit" name="sr_btn" value="Go!" >
    </form>
    <br>
    <table class="table table-stripped">
      <thead>
        <tr>
          <th scope="col">Registration No.</th>
          <th scope="col">Name</th>
          <th scope="col">Department</th>
          <th scope="col">Batch</th>
          <th scope="col">Semester</th>
          <th scope="col">Email</th>
        </tr>
      </thead>

   <?php

if(isset($_POST['sr_btn'])){
  $srbatch = $_POST['sr_batch'];
  $i = 0;
  
  $stmt = $conn->prepare("SELECT * FROM students WHERE st_batch = ? ORDER BY st_id ASC");
  $stmt->bind_param("s", $srbatch); 
  
  $stmt->execute();
  
  $result = $stmt->get_result();
  
  while ($data = $result->fetch_assoc()) {
      $i++;
     
     ?>
  <tbody>
     <tr>
       <td><?php echo $data['st_id']; ?></td>
       <td><?php echo $data['st_name']; ?></td>
       <td><?php echo $data['st_dept']; ?></td>
       <td><?php echo $data['st_batch']; ?></td>
       <td><?php echo $data['st_sem']; ?></td>
       <td><?php echo $data['st_email']; ?></td>
     </tr>
  </tbody>

  <?php 
      } 
    }
  ?> 
  </table>
  </div>
</div>
</center>

</body>
</html>