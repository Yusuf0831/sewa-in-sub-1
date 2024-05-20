<?php
$conn = new mysqli("localhost","root","","db_sewa_kendaraan");
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  exit();
}
?> 