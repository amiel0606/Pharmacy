<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'dbCon.php';
    $item = $_POST['item'];
    $transID = $_POST['transID'];
    $customerName = $_POST['customer'];
    $stmt = $conn->prepare("INSERT INTO tbl_cart (pID, brandName, description, lotNo, qty, unit_price, category, datePurchased, transID, custName, price, unit) VALUES (?, ?, ?, ?, 1, ?, ?, NOW(), ?, ?, ?, ?)");
    $stmt->bind_param("isssisssis",$item[0], $item[2], $item[3], $item[5], $item[9], $item[1], $transID, $customerName, $item[9], $item[10]);
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