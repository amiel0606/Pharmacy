<?php
    require_once 'dbCon.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $transID = $_POST['transID'];
    $operation = $_POST['operation'];
    if ($operation == 'confirmTerms') {
        $dateTerms = $_POST['dateTerms'];
        $custName = $_POST['custName'];
        $stmt = $conn->prepare("SELECT price, qty FROM tbl_cart WHERE transID = ?");
        $stmt->bind_param("i", $transID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $gross = 0;
            while ($row = $result->fetch_assoc()) {
                $gross += $row['price'] * $row['qty'];
            }
            $subtotal = $gross / 1.12;
            $vat = $gross - $subtotal;
            $total = $gross;
        } else {
            echo "Error calculating subtotal, VAT, and total: " . $stmt->error;
        }
        $stmt->close();
        $stmt = $conn->prepare("UPDATE tbl_cart SET status = 'Terms', dateToPay = ? WHERE transID = ?");
        $stmt->bind_param("si", $dateTerms, $transID);
        if ($stmt->execute()) {
            echo "Status and dateToPay updated successfully";
        } else {
            echo "Error updating status and dateToPay: " . $stmt->error;
        }
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO tbl_records (transID, name, subtotal, vat, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddd", $transID, $custName, $subtotal, $vat, $total);
        if ($stmt->execute()) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($operation == 'updateCustName') {
        $custName = $_POST['custName'];
        $stmt = $conn->prepare("UPDATE tbl_cart SET custName = ? WHERE transID = ?");
        $stmt->bind_param("si", $custName, $transID);
        if ($stmt->execute()) {
            echo "Customer name updated successfully";
        } else {
            echo "Error updating customer name: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($operation == 'cash') {
        $custName = $_POST['custName'];
        $stmt = $conn->prepare("SELECT price, qty FROM tbl_cart WHERE transID = ?");
        $stmt->bind_param("i", $transID);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $gross = 0;
            while ($row = $result->fetch_assoc()) {
                $gross += $row['price'] * $row['qty'];
            }
            $subtotal = $gross / 1.12;
            $vat = $gross - $subtotal;
            $total = $gross;
        } else {
            echo "Error calculating subtotal, VAT, and total: " . $stmt->error;
        }
        $stmt = $conn->prepare("UPDATE tbl_cart SET status = 'Cash' WHERE transID = ?");
        $stmt->bind_param("i", $transID);
        if ($stmt->execute()) {
            echo "Status updated to 'Cash' successfully";
        } else {
            echo "Error updating status to 'Cash': " . $stmt->error;
        }
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO tbl_records (transID, name, subtotal, vat, total) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssddd", $transID, $custName, $subtotal, $vat, $total);
        if ($stmt->execute()) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();