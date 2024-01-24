<?php
require_once 'dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST["edit-category"];
    $brandName = $_POST['edit-brandName'];
    $description = $_POST['edit-description'];
    $qty = $_POST['edit-qty'];
    $priceBought = $_POST['edit-priceBought'];
    $exp_date = $_POST['edit-exp_date'];
    $priceSale = $_POST['edit-priceSale'];
    $id = $_POST['edit-id'];
    $stockAlert = $_POST['edit-stockAlert'];
    $sql = "UPDATE tbl_products SET category = ?, brandName = ?, description = ?, stock = ?, priceBought = ?, stockAlert = ?, exp_date = ?, priceSale = ? WHERE pID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssisissi", $category, $brandName, $description, $qty, $priceBought, $stockAlert, $exp_date, $priceSale, $id);

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