<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: login.php'); exit();
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
  <h3><center>If record is not showing that's mean record is not available.</center></h3>
  <div class="content">
  <center><h3 id="logo">Individual Report</h3><br><center>
    <form method="post" action="">
    <label>Select Subject</label>
    <select name="whichcourse">
      <option  value="data_mining">Data Mininig</option>
      <option  value="software">Software Engineering</option>
      <option  value="dbms">Database Management System</option>
      <option  value="data_analytics">Data Analytics</option>
      <option  value="os">Operating System</option>
      <option  value="daa">Data Analysis and Algorithm</option>
    </select>

      <p>  </p>
      <label>Student Reg. No.</label>
      <input type="text" name="sr_id">
      <input type="submit" name="sr_btn" value="Go!" >

    </form>

    <center><h3 id="logo">Mass Report</h3><br></center>

    <form method="post" action="">

    <label>Select Subject</label>
    <select name="whichcourse">
      <option  value="data_mining">Data Mininig</option>
      <option  value="software">Software Engineering</option>
      <option  value="dbms">Database Management System</option>
      <option  value="data_analytics">Data Analytics</option>
      <option  value="os">Operating System</option>
      <option  value="daa">Data Analysis and Algorithm</option>
    </select>
    <p>  </p>
      <label>Date ( yyyy-mm-dd )</label>
      <input type="text" name="date">
      <input type="submit" name="sr_date" value="Go!" >
    </form>

    <br>

    <br>

    <?php

if(isset($_POST['sr_btn'])){
    $sr_id = $conn->real_escape_string($_POST['sr_id']);
    $course = $conn->real_escape_string($_POST['whichcourse']);

    $query1 = "SELECT stat_id, COUNT(*) as countP FROM attendance WHERE stat_id=? AND course=? AND st_status='Present'";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("ss", $sr_id, $course);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $single = $result1->fetch_assoc();

    $query2 = "SELECT COUNT(*) as countT FROM attendance WHERE stat_id=? AND course=?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("ss", $sr_id, $course);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $singleT = $result2->fetch_assoc();

    $count_tot = $singleT['countT'];
} 

if(isset($_POST['sr_date'])) {
  // Escaping form inputs for security
  $sdate = $conn->real_escape_string($_POST['date']);
  $course = $conn->real_escape_string($_POST['whichcourse']);

  $stmtDate = $conn->prepare("SELECT * FROM attendance WHERE stat_date=? AND course=?");
  $stmtDate->bind_param("ss", $sdate, $course);
  $stmtDate->execute();
  $resultDate = $stmtDate->get_result();

  // Check if there are any records
  {?>
      <table class="table table-stripped">
      <thead>
        <tr>
          <th scope="col">Student ID</th>
          <th scope="col">Course</th>
          <th scope="col">Status</th>
          <th scope="col">Date</th>
        </tr>
     </thead>
        <?php while($data = $resultDate->fetch_assoc()){ ?>
          <tbody>
           <tr>
             <td><?php echo $data['stat_id']; ?></td>
             <td><?php echo $data['course']; ?></td>
             <td><?php echo $data['st_status']; ?></td>
             <td><?php echo $data['stat_date']; ?></td>
           </tr>
        </tbody>
        <?php } ?>

        </tbody>
    </table>
<?php }}?>

     
    </table>


    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
    <table class="table table-striped">

    <?php
       
//checking the form for ID
if(isset($_POST['sr_btn'])){

  //initializing ID 
  $sr_id = $_POST['sr_id'];
  $course = $_POST['whichcourse'];

  $i=0;
  $count_pre = 0;
  
  // Query for counting presents
  $all_query = $conn->query("SELECT stat_id, COUNT(*) as countP FROM attendance WHERE stat_id='$sr_id' AND course = '$course' AND st_status='Present'");

  // Query for total classes
  $singleT = $conn->query("SELECT COUNT(*) as countT FROM attendance WHERE stat_id='$sr_id' AND course = '$course'");
  
  $count_tot = 0;
  if ($row = $singleT->fetch_assoc()) {
      $count_tot = $row['countT'];
  }

  if ($data = $all_query->fetch_assoc()) {
      $i++;
      ?>
      

   <tbody>
    <tr>
        <td>Registration No.: </td>
        <td><?php echo $data['stat_id']; ?></td>
    </tr>

    <tr>
      <td>Total Class (Days): </td>
      <td><?php echo $count_tot; ?> </td>
    </tr>

    <tr>
      <td>Present (Days): </td>
      <td><?php echo $data['countP']; ?> </td>
    </tr>

    <tr>
      <td>Absent (Days): </td>
      <td><?php echo $count_tot -  $data['countP']; ?> </td>
    </tr>

  </tbody>

   <?php

     }  
  }
     ?>
    </table>
  </form>

  </div>

</div>

</center>

</body>
</html>
