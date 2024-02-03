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
    $lot = $_POST['edit-lot'];
    $stockAlert = $_POST['edit-stockAlert'];
    $receipt = $_POST['edit-receipt'];
    $unit = $_POST['edit-unit'];
    $sql = "UPDATE tbl_products SET category = ?, brandName = ?, description = ?, lotNo = ?, stock = ?, unit = ?, priceBought = ?, stockAlert = ?, exp_date = ?, priceSale = ?, receipt = ? WHERE pID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssississsi", $category, $brandName, $description, $lot, $qty, $unit, $priceBought, $stockAlert, $exp_date, $priceSale, $receipt, $id);

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