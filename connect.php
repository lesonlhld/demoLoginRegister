<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "demoThucTap";


// $servername = "db4free.net";
// $username = "leson0310";
// $password = "leson0108";
// $dbname = "demothuctap";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
?>
