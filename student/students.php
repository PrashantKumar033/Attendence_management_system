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

<div class="row">
  <div class="content">
  <center><h3 style="padding: 5px;
    color: rgb(221, 219, 219);
    width: 300px;
    background-color: #566586;
    border-radius: 10px;
    box-shadow: -.5px -.5px 7px 7px rgb(162, 147, 176);">Student List</h3></center>
    <br>
    <form method="post" action="" class="form-horizontal col-md-6 col-md-offset-3">
      <div class="form-group">
        <label for="input1" class="col-sm-3 control-label">Batch</label>
          <div class="col-sm-7">
            <input type="text" name="sr_batch" style="height:30px" class="form-control" id="input1" placeholder="Enter batch" />
          </div>
      </div>
      <input type="submit" class="btn btn-primary col-md-3 col-md-offset-7" value="Go!" name="sr_btn" />
    </form>

    <div class="content"></div>
      <table style="border:1px solid black" class="table table-striped">
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

// Initialize an array to store fetched students.
$students = [];

// Check if the form was submitted
if (isset($_POST['sr_btn'])) {
    $sr_batch = $_POST['sr_batch'];
    // Prepare a query to fetch students from the specified batch
    $query = "SELECT * FROM students WHERE st_batch = ?";
    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("s", $sr_batch);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $connection->error;
    }
  }
  ?>
    <?php foreach ($students as $data): ?>
      <tr>
        <td><?php echo htmlspecialchars($data['st_id']); ?></td>
        <td><?php echo htmlspecialchars($data['st_name']); ?></td>
        <td><?php echo htmlspecialchars($data['st_dept']); ?></td>
        <td><?php echo htmlspecialchars($data['st_batch']); ?></td>
        <td><?php echo htmlspecialchars($data['st_sem']); ?></td>
        <td><?php echo htmlspecialchars($data['st_email']); ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>
</center>
</body>
</html>
