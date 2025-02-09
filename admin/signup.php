<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: ../index.php');
}
?>


<?php
include('connect.php');

$error_msg = '';
$success_msg = '';

try {
    if (isset($_POST['signup'])) {
        // Validation of empty fields
        $requiredFields = ['email', 'uname', 'pass', 'fname', 'phone', 'type'];
        foreach ($requiredFields as $fieldName) {
            if (empty($_POST[$fieldName])) {
                throw new Exception(ucfirst($fieldName) . " can't be empty.");
            }
        }

        // Insertion of data to database table admininfo
        // Prepare a statement to avoid SQL injections
        $stmt = $conn->prepare("INSERT INTO admininfo (username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssss", $_POST['uname'], $_POST['pass'], $_POST['email'], $_POST['fname'], $_POST['phone'], $_POST['type']);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            $success_msg = "Signup Successfully!";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

// Close connection
$conn->close();


?>

<!DOCTYPE html>
<html lang="en">

<!-- head started -->
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  <link rel="stylesheet" href="admin.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
  <link rel="stylesheet" href="styles.css" >
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body style="background-color:#bbcdd3">
    <header>
      <div>
        <h1>Attendance Management System</h1>
        <div class="navbar">
          <a href="signup.php">Create Users</a>
          <a href="index.php">Add Data</a>
          <a href="../logout.php">Logout</a>
        </div>
    </header>
<center>
  <h1 id="createuser">Create User</h1>
    <p>   
      <?php
        if(isset($success_msg)) echo $success_msg;
        if(isset($error_msg)) echo $error_msg;
      ?>
    </p>
    <br>
<div class="content">
  <div class="row">
    <form method="post" class="form-horizontal col-md-6 col-md-offset-3">
      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-7">
            <input type="text" name="email"  class="form-control" id="input1" placeholder="your email" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Username</label>
          <div class="col-sm-7">
            <input type="text" name="uname"  class="form-control" id="input1" placeholder="choose username" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-7">
            <input type="password" name="pass"  class="form-control" id="input1" placeholder="choose a strong password" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Full Name</label>
          <div class="col-sm-7">
            <input type="text" name="fname"  class="form-control" id="input1" placeholder="your full name" />
          </div>
      </div>

      <div class="form-group">
          <label for="input1" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-7">
            <input type="text" name="phone"  class="form-control" id="input1" placeholder="your phone number" />
          </div>
      </div>

      <div class="form-group" class="radio">
      <label for="input1" class="col-sm-3 control-label">Role</label>
      <div class="col-sm-7">
        <label>
          <input type="radio" name="type" id="optionsRadios1" value="student" checked> Student
        </label>
            <label>
          <input type="radio" name="type" id="optionsRadios1" value="teacher"> Teacher
        </label>
        <label>
          <input type="radio" name="type" id="optionsRadios1" value="admin"> Admin
        </label>
      </div>
      </div>

      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-8" value="Signup" name="signup" />
    </form>
  </div>
  <br>
  <p><strong>Already have an account? <a href="../index.php">Login</a> here.</strong></p>
</div>

</center>

</body>
</html>