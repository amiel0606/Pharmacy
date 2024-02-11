<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'dbCon.php';
    if (isset($_POST['transID'])) {
        $transID = $_POST['transID'];
        $operation = $_POST['operation'];

        if ($operation == "deleteCart" && isset($_POST['id'])) {
            $id = $_POST['id'];
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE id = ? AND transID = ?");
            $stmt->bind_param("ii", $id, $transID);
        } elseif ($operation == "cancelCart") {
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE transID = ?");
            $stmt->bind_param("i", $transID);
        }

        if ($stmt->execute()) {
            echo "Operation performed successfully";
        } else {
            echo "Error performing operation: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();