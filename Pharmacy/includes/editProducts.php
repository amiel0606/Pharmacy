<?php
require_once 'dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['edit-barcode'];
    $category = $_POST["edit-category"];
    $brandName = $_POST['edit-brandName'];
    $description = $_POST['edit-description'];
    $qty = $_POST['edit-qty'];
    $priceBought = $_POST['edit-priceBought'];
    $exp_date = $_POST['edit-exp_date'];
    $priceSale = $_POST['edit-priceSale'];
    $id = $_POST['edit-id'];

    $sql = "UPDATE tbl_products SET barcode = ?, category = ?, brandName = ?, description = ?, stock = ?, priceBought = ?, exp_date = ?, priceSale = ? WHERE pID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisssi", $barcode, $category, $brandName, $description, $qty, $priceBought, $exp_date, $priceSale, $id);

    if ($stmt->execute()) {
        echo "Product updated successfully";
    } else {
        echo "No changes were made.";
    }

    $stmt->close();
} else {
    echo "Product id is not set";
}

$conn->close();