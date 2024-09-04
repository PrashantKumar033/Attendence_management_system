<?php
ob_start();
session_start();

if ($_SESSION['name'] != 'oasis') {
    header('location: login.php');
    exit();
}

include('connect.php');

$att_msg = '';
$error_msg = '';

if (isset($_POST['att'])) {
    $course = $_POST['whichcourse'];
    $stmt = $conn->prepare("INSERT INTO attendance(stat_id, course, st_status, stat_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $stat_id, $course, $st_status, $dp);

    foreach ($_POST['st_status'] as $i => $st_status) {
        $stat_id = $_POST['stat_id'][$i];
        $dp = date('Y-m-d');
        
        if ($stmt->execute()) {
            $att_msg = "Attendance Recorded.";
        } else {
            $error_msg = "Error recording attendance.";
        }
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">

  <link rel="stylesheet" href="teacher.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<style type="text/css">
  .status{
    font-size: 10px;
  }

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
    <center><h3 id="logo">Attendance of <?php echo date('Y-m-d'); ?></h3></center>
    <br>

    <center><p><?php if(isset($att_msg)) echo $att_msg; if(isset($error_msg)) echo $error_msg; ?></p></center> 
    
    <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">

      <div class="form-group">
        <label>Enter Batch</label>
        <input type="text" name="st_batch" id="input2" placeholder="Ex. 2020">
      <div class="form-group">
        <label >Select Subject</label>
          <select name="whichcourse" id="input1">
            <option  value="data_mining">Data Mining</option>
            <option  value="software">Software Engineering</option>
            <option  value="dbms">Database Management System</option>
            <option  value="data_analytics">Data Analytics</option>
            <option  value="os">Operating System</option>
            <option  value="daa">Data Analysis and Algorithm</option>
          </select>
      </div>
        <input type="submit" class="btn btn-primary col-md-2 col-md-offset-5" value="Show!" name="batch" />
      </div>
            
    <table class="table table-stripped">
      <thead>
        <tr>
          <th scope="col">Reg. No.</th>
          <th scope="col">Name</th>
          <th scope="col">Department</th>
          <th scope="col">Batch</th>
          <th scope="col">Semester</th>
          <th scope="col">Email</th>
          <th scope="col">Status</th>
        </tr>
      </thead>
   <?php

    if(isset($_POST['batch'])){
      $i=0;
      $radio = 0;
      $batch = $_POST['st_batch'];
      $all_query = $conn->prepare("SELECT * FROM students WHERE st_batch = ? ORDER BY st_id ASC");

      $all_query->bind_param("s", $batch); 
      $all_query->execute();
      $result = $all_query->get_result();
      while ($data = $result->fetch_assoc()) {
        $i++;
     ?>
  <body>
     <tr>
       <td><?php echo $data['st_id']; ?> <input type="hidden" name="stat_id[]" value="<?php echo $data['st_id']; ?>"> </td>
       <td><?php echo $data['st_name']; ?></td>
       <td><?php echo $data['st_dept']; ?></td>
       <td><?php echo $data['st_batch']; ?></td>
       <td><?php echo $data['st_sem']; ?></td>
       <td><?php echo $data['st_email']; ?></td>
       <td>
         <label>Present</label>
         <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Present" >
         <label>Absent </label>
         <input type="radio" name="st_status[<?php echo $radio; ?>]" value="Absent" checked>
       </td>
     </tr>
  </body>

     <?php

        $radio++;
      } 
}
      ?>
    </table>

    <center><br>
    <input type="submit" class="btn btn-primary col-md-2 col-md-offset-10" value="Save!" name="att" />
  </center>

</form>
</div>
</div>
</center>

</body>
</html>