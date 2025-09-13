<?php
 
 include("connection.php");

$stmt = $conn->prepare("SELECT * FROM products WHERE product_category = 'wears';");

$stmt ->execute();

$result = $stmt->get_result();

?>