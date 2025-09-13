<?php 

$hostName = 'localhost';
$userName = 'root';
$password = '';
$dbName = 'php_project';


$conn = new mysqli($hostName, $userName, $password, $dbName);
if ($conn->connect_error) {
    die('connection failed'. $conn->connect_error);
}

?>