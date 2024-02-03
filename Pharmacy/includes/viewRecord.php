<?php
    require_once 'dbCon.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $transID = $_REQUEST['transID'];
    $custName = $_REQUEST['custName'];    
    $sql = "SELECT * FROM tbl_cart WHERE transID = ? AND custName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $transID, $custName);
    $stmt->execute();
    $result = $stmt->get_result();
    echo "<table>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['transID'] . "</td>";
        echo "<td>" . $row['brandName'] . " " . $row['description'] . "</td>";
        echo "<td>" . $row['datePurchased'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    $stmt->close();
    $conn->close();