<?php
    require_once 'dbCon.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $transID = $_REQUEST['transID'];
    $custName = $_REQUEST['custName'];    
    $sql = "SELECT tbl_cart.*, tbl_products.* FROM tbl_cart 
            INNER JOIN tbl_products ON tbl_cart.pID = tbl_products.pID 
            WHERE tbl_cart.transID = ? AND tbl_cart.custName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $transID, $custName);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = array();
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode($items);
    $stmt->close();
    $conn->close();