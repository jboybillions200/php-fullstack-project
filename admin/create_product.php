<?php
include("../server/connection.php");

if (isset($_POST['create_product'])) {

    $title = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $offer = $_POST['offer'];
    $color = $_POST['color'];
    $category = $_POST['category'];

    // Upload directory
    $target_dir = "../assets/imgs/";

    // Handle image uploads
    $image1 = $_FILES['image1']['name'];
    $image2 = $_FILES['image2']['name'];
    $image3 = $_FILES['image3']['name'];
    $image4 = $_FILES['image4']['name'];

    // Full path
    $target_file1 = $target_dir . basename($image1);
    $target_file2 = $target_dir . basename($image2);
    $target_file3 = $target_dir . basename($image3);
    $target_file4 = $target_dir . basename($image4);

    // Move uploaded files
    if (
        move_uploaded_file($_FILES['image1']['tmp_name'], $target_file1) &&
        move_uploaded_file($_FILES['image2']['tmp_name'], $target_file2) &&
        move_uploaded_file($_FILES['image3']['tmp_name'], $target_file3) &&
        move_uploaded_file($_FILES['image4']['tmp_name'], $target_file4)
    ) {
        // Insert into DB
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, product_special_offer, product_color, product_category, product_image, product_image2, product_image3, product_image4) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $title, $description, $price, $offer, $color, $category, $image1, $image2, $image3, $image4);

        if ($stmt->execute()) {
            header("Location: product.php?success_message=Product Created Successfully");
            exit;
        } else {
            header("Location: product.php?error=Something went wrong, try again.");
            exit;
        }
    } else {
        header("Location: product.php?error=Failed to upload images.");
        exit;
    }
} else {
    header("Location: product.php");
    exit;
}
?>
