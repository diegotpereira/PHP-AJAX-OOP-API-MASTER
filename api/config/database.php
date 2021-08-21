<?php
$servername = "localhost";
$banco = "db_php_ajax_oop_api_master";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $banco, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>