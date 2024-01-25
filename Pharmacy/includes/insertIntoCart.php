<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'dbCon.php';
    $item = $_POST['item'];
    $transID = $_POST['transID'];
    $customerName = $_POST['customer'];
    $stmt = $conn->prepare("INSERT INTO tbl_cart (pID, brandName, description, qty, price, category, datePurchased, transID, custName) VALUES (?, ?, ?, 1, ?, ?, NOW(), ?, ?)");
    $stmt->bind_param("ississs",$item[0], $item[2], $item[3], $item[7], $item[1], $transID, $customerName);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $stmt = $conn->prepare("UPDATE tbl_products SET stock = stock - 1 WHERE pID = ?");
    $stmt->bind_param("i", $item[0]);
    if ($stmt->execute()) {
        echo "Stock updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();