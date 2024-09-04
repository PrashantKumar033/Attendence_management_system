<?php
$host = 'localhost'; 
$user = 'root'; 
$pass = ''; 
$db = 'attsystem';

$conn = mysqli_connect('localhost', 'root', '', 'attsystem') or die('Cannot connect to server');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
