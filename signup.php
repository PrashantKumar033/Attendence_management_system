<?php
include('connect.php'); 
try {
    if(isset($_POST['signup'])) {
        // from here show error if any space is not filled up from all
        if (empty($_POST['email'])) {
          throw new Exception("Email can't be empty.");
        }
        if (empty($_POST['uname'])) {
          throw new Exception("Username can't be empty.");
        }
        if (empty($_POST['pass'])) {
          throw new Exception("Password can't be empty.");
        }
        if (empty($_POST['fname'])) {
          throw new Exception("Full name can't be empty.");
        }
        if (empty($_POST['phone'])) {
          throw new Exception("Phone can't be empty.");
        }
        if (empty($_POST['type'])) {
          throw new Exception("Type can't be empty.");
        }
        // here we are trying to prepare the all data in DB using sql command 
        $stmt = $connection->prepare("INSERT INTO admininfo (username, password, email, fname, phone, type) VALUES (?, ?, ?, ?, ?, ?)");
        // here we declair variables to insert data
        $stmt->bind_param("ssssss", $param_username, $param_password, $param_email, $param_fname, $param_phone, $param_type);
        
        // Set parameters
        $param_username = $_POST['uname'];
        $param_password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Creates a password hash
        $param_email = $_POST['email'];
        $param_fname = $_POST['fname'];
        $param_phone = $_POST['phone'];
        $param_type = $_POST['type'];
        
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            $success_msg = "Signup Successfully!";
        } else {
            throw new Exception("Error: " . $stmt->error);
        }

        // Close statement
        $stmt->close();
    }
} catch (Exception $e) {
    $error_msg = $e->getMessage();
}

// Close connection
$connection->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<title>Attendance Management System</title>
<meta charset="UTF-8">
  
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
   
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
   
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<header>

  <h1>Attendance Management System</h1>

</header>
<center>
<h1 id="login">Signup</h1>
<div class="content">

  <div class="row">
    <?php
    if(isset($success_msg)) echo $success_msg;
    if(isset($error_msg)) echo $error_msg;
     ?>
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
      </div>
      </div>

      <input type="submit" class="btn btn-primary col-md-2 col-md-offset-8" value="Signup" name="signup" />
    </form>
  </div>
    <br>
    <p><strong>Already have an account? <a href="index.php">Login</a> here.</strong></p>
  </div>

</center>

</body>
</html>
