<?php
    require_once 'dbCon.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->set_charset("utf8mb4");
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
        $stmt->bind_param("i", $pID);
    } else {
        $stmt = $conn->prepare("UPDATE tbl_products SET stock = (SELECT qty FROM tbl_cart WHERE transID = ?) WHERE pID = ?");
        $stmt->bind_param("ii", $transID, $pID);
    }
    if ($stmt->execute()) {
        echo "Stock updated successfully";
    } else {
        echo "Error updating stock: " . $stmt->error;
    }
    $stmt->close();

    // DELETE PAG 0 NA ANG STOCK
    $stmt = $conn->prepare("DELETE FROM tbl_products WHERE stock <= 0");
    if ($stmt->execute()) {
        echo "Records with zero or less stock deleted successfully";
    } else {
        echo "Error deleting records: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
?>
