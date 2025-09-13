<?php 

include("connection.php");

$statement = $conn->prepare("SELECT * FROM products WHERE product_category = 'shoe';");


$statement->execute();  

$result = $statement -> get_result();

?>