<?php
    require_once 'dbCon.php';

    if (isset($_POST['transID'])) {
        $transID = $_POST['transID'];
        $operation = $_POST['operation'];

        if ($operation == "deleteCart" && isset($_POST['pID'])) {
            $pID = $_POST['pID'];
            $stmt = $conn->prepare("DELETE FROM tbl_cart WHERE pID = ? AND transID = ?");
            $stmt->bind_param("ii", $pID, $transID);
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