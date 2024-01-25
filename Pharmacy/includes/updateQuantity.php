<?php
    require_once 'dbCon.php';
    $pID = $_POST['pID'];
    $transID = $_POST['transID'];
    $quantity = $_POST['quantity'];
    $operation = $_POST['operation'];

    $stmt = $conn->prepare("UPDATE tbl_cart SET qty = ? WHERE transID = ?");
    $stmt->bind_param("ii", $quantity, $transID);
    if ($stmt->execute()) {
        echo "Quantity updated successfully";
    } else {
        echo "Error updating quantity: " . $stmt->error;
    }
    $stmt->close();
    if ($operation != 'cancel') {
        $stmt = $conn->prepare("UPDATE tbl_products SET stock = stock " . ($operation == 'increase' ? '-' : '+') . " 1 WHERE pID = ?");
    } else {
        $stmt = $conn->prepare("UPDATE tbl_products SET stock = (SELECT qty FROM tbl_cart WHERE transID = ?) WHERE pID = ?");
    }
    $stmt->bind_param("i", $pID);
    if ($stmt->execute()) {
        echo "Stock updated successfully";
    } else {
        echo "Error updating stock: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();