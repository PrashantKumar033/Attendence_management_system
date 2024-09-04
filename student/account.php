<?php
ob_start();
session_start();
if($_SESSION['name']!='oasis')
{
  header('location: ../login.php');
}
include('connect.php'); 

try {
  // Checking form data and empty fields
  if(isset($_POST['done'])) {
    if (empty($_POST['name'])) {
      throw new Exception("Name cannot be empty");
    }
    if (empty($_POST['dept'])) {
      throw new Exception("Department cannot be empty");
    }
    if(empty($_POST['batch'])) {
      throw new Exception("Batch cannot be empty");
    }
    if(empty($_POST['email'])) {
      throw new Exception("Email cannot be empty");
    }
    // initializing the student id
    $sid = $_POST['id'];

    // Updating student's information in the database table "students"
    $stmt = mysqli_prepare($conn, "UPDATE students SET st_name=?, st_dept=?, st_batch=?, st_sem=?, st_email=? WHERE st_id=?");
    mysqli_stmt_bind_param($stmt, 'sssssi', $_POST['name'], $_POST['dept'], $_POST['batch'], $_POST['semester'], $_POST['email'], $sid);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      $success_msg = 'Updated successfully.';
    } else {
      $error_msg = 'Update failed or no changes were made.';
    }
    mysqli_stmt_close($stmt);
  }
} catch(Exception $e) {
  $error_msg = $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Online Attendance Management System 1.0</title>
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
<!-- Content, Tables, Forms, Texts, Images started -->
<center>

<div class="row">
    <div class="content">
        <center><h3 id="logo1" style="padding: 5px;
        color: rgb(221, 219, 219);
        width: 300px;
        background-color: #566586;
        border-radius: 10px;
        box-shadow: -.5px -.5px 7px 7px rgb(162, 147, 176);">Update Account</h3></center>
        <br>
        <!-- Error or Success Message print-->
        <p>
        <?php
          if(isset($success_msg))
          {
            echo $success_msg;
          }
          if(isset($error_msg))
          {
            echo $error_msg;
          }
        ?>
          </p>
          <br>
          <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="input1" class="col-sm-3 control-label">Registration No.</label>
                <div class="col-sm-7">
                  <input type="text" name="sr_id" style="height:30px;" class="form-control" id="input1" placeholder="Enter your reg. no." />
                </div>
            </div>
            <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
          </form>
          <div class="content"></div>
      <?php
      if(isset($_POST['sr_btn'])) {
  $sr_id = $_POST['sr_id'];
  $i=0;
  
  // Searching student information with the given ID
  $query = mysqli_prepare($connection, "SELECT * FROM students WHERE st_id=?");
  mysqli_stmt_bind_param($query, 'i', $sr_id);
  mysqli_stmt_execute($query);
  $result = mysqli_stmt_get_result($query);

  while ($data = mysqli_fetch_array($result)) {
    $i++;
       
       ?>
  <form action="" method="post" class="form-horizontal col-md-6 col-md-offset-3">
   <table class="table table-striped">
      <tr>
        <td>Registration No.:</td>
        <td><?php echo $data['st_id']; ?></td>
      </tr>

      <tr>
          <td>Student's Name:</td>
          <td><input type="text" name="name" value="<?php echo $data['st_name']; ?>"></input></td>
      </tr>

      <tr>
          <td>Department:</td>
          <td><input type="text" name="dept" value="<?php echo $data['st_dept']; ?>"></input></td>
      </tr>

      <tr>
          <td>Batch:</td>
          <td><input type="text" name="batch" value="<?php echo $data['st_batch']; ?>"></input></td>
      </tr>
      
      <tr>
          <td>Semester:</td>
          <td><input type="text" name="semester" value="<?php echo $data['st_sem']; ?>"></input></td>
      </tr>

      <tr>
          <td>Email:</td>
          <td><input type="text" name="email" value="<?php echo $data['st_email']; ?>"></input></td>
      </tr>
      <input type="hidden" name="id" value="<?php echo $sr_id; ?>">
      
      <tr><td></td></tr>
      <tr>
        <td></td>
        <td><input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Update" name="done" /></td>  
      </tr>
    </table>
</form>
     <?php 
    }
    mysqli_stmt_close($query);
    } 
    ?>
    </div>
  </div>
  </center>
</body>
</html>