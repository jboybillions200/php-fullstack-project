<?php
include("../server/connection.php");

if (isset($_POST['update_images'])) {
    $product_name = $_POST['product_name'];
    $product_id = $_POST['product_id'];

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $uploads = [];

    // Validate and collect images
    for ($i = 1; $i <= 4; $i++) {
        $file = $_FILES["image$i"];

        if (!in_array($file['type'], $allowed_types)) {
            header("Location: update_images_form.php?product_id=$product_id&product_name=$product_name&error=Only JPG, JPEG, PNG files allowed");
            exit();
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            header("Location: update_images_form.php?product_id=$product_id&product_name=$product_name&error=Upload failed for Image $i");
            exit();
        }

        $filename = $product_name . $i . ".jpeg";
        move_uploaded_file($file['tmp_name'], "../assets/imgs/" . $filename);
        $uploads[] = $filename;
    }

    // Update database
    $stmt = $conn->prepare("UPDATE products SET product_image=?, product_image2=?, product_image3=?, product_image4=? WHERE product_id=?");
    $stmt->bind_param("ssssi", $uploads[0], $uploads[1], $uploads[2], $uploads[3], $product_id);

    if ($stmt->execute()) {
        header("Location: product.php?images_updated=Image changed successfully");
    } else {
        header("Location: product.php?images_failed=Something went wrong, try again.");
    }

    $stmt->close();
}
?>
