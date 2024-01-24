<?php
    require_once 'dbCon.php';
    $pID = $_POST['pID'];
    $transID = $_POST['transID'];
    $quantity = $_POST['quantity'];
    $stmt = $conn->prepare("UPDATE tbl_cart SET qty = ? WHERE transID = ?");
    $stmt->bind_param("ii", $quantity, $transID);
    if ($stmt->execute()) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $stmt->error;
    }
    $stmt->close();
    $stmt = $conn->prepare("UPDATE tbl_products SET stock = stock - 1 WHERE pID = ?");
    $stmt->bind_param("i", $pID);
    if ($stmt->execute()) {
        echo "Stock updated successfully";
    } else {
        echo "Error updating stock: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
