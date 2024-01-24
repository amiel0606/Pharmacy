<?php
    require_once 'dbCon.php';
    $item = $_POST['item'];
    $transID = $_POST['transID'];
    $stmt = $conn->prepare("INSERT INTO tbl_cart (pID, brandName, description, qty, price, category, datePurchased, transID) VALUES (?, ?, ?, 1, ?, ?, NOW(), ?)");
    $stmt->bind_param("ississ",$item[0], $item[2], $item[3], $item[7], $item[1], $transID);
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