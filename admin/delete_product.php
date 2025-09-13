<?php session_start(); 

include"../server/connection.php";

?> 

<?php 
 if(isset($_SESSION['admin_logged_in'])){
    header("Location: login.php");
    exit;
 }
 
if(isset($_SESSION["admin_logged_in"])){
    header("Location: login.php");
    exit;
}

 if(isset($_GET["product_id"])){
    $product_id = $_GET["product_id"];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
   if( $stmt->execute()){

    header("Location: product.php?deleted_succesfully=Product Has Been Deleted Succesfully");
 }else{
    header("Location: product.php?deleted_failure=Could Not Delete Products");
  }

 }
?>