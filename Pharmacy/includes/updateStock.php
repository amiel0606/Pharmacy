<?php
    require_once 'dbCon.php';
    $pID = $_POST['pID'];
    $quantity = $_POST['quantity'];
    $sql = "UPDATE tbl_products SET stock = stock + $quantity WHERE pID = $pID";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $conn->close();
