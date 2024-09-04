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

<!-- head started -->
<head>
  <title>Attendance Management System</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="student.css">
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
    <a href="report.php">My Report</a>
    <a href="account.php">My Account</a>
    <a href="../logout.php">Logout</a>
  </div>

</header>
<center>

<!-- Content, Tables, Forms, Texts, Images started -->
<div class="row">
<h3><center>If record is not showing that's mean record is not available.</center></h3>
  <div class="content">
    <center><h3 id="logo1" style="padding: 5px;
    color: rgb(221, 219, 219);
    width: 300px;
    background-color: #566586;
    border-radius: 10px;
    box-shadow: -.5px -.5px 7px 7px rgb(162, 147, 176);">Student Report</h3></center>
    <br>
    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">

  <div class="form-group">

    <label  for="input1"  class="col-sm-3 control-label">Select Subject</label>
      <div class="col-sm-4">
      <select name="whichcourse" id="input1" style="height:30px;">
        <option  value="data_mining">Data Mininig</option>
        <option  value="software">Software Engineering</option>
        <option  value="dbms">Database Management System</option>
        <option  value="data_analytics">Data Analytics</option>
        <option  value="os">Operating System</option>
        <option  value="daa">Data Analysis and Algorithm</option>
      </select>
      </div>

  </div>

  <div class="form-group">
      <label for="input1" class="col-sm-3 control-label">Your Reg. No.</label>
        <div class="col-sm-7">
            <input type="text" style="height:30px;" name="sr_id"  class="form-control" id="input1" placeholder="enter your reg. no." />
        </div>
  </div>
  <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
  </form>
  <div class="content"><br></div>

  <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
  <table class="table table-striped">

  <?php
  //checking the form for ID
  if(isset($_POST['sr_btn'])){
    $sr_id = $_POST['sr_id'];
    $course = $_POST['whichcourse'];

    $i=0;
    $count_pre = 0;
    
    // Query for counting presents
    $all_query = $connection->query("SELECT stat_id, COUNT(*) as countP FROM attendance WHERE stat_id='$sr_id' AND course = '$course' AND st_status='Present'");

    // Query for total classes
    $singleT = $connection->query("SELECT COUNT(*) as countT FROM attendance WHERE stat_id='$sr_id' AND course = '$course'");
    
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
