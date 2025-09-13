<?php 
include"connection.php";

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category = 'watch';");

$stmt ->execute();

$result = $stmt->get_result();
?>