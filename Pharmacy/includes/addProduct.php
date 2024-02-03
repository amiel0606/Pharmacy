<?php
require_once 'dbCon.php';
$category = $_POST["category"];
$brandName = $_POST['brandName'];
$description = $_POST['description'];
$qty = $_POST['qty'];
$priceBought = $_POST['priceBought'];
$exp_date = $_POST['exp_date'];
$priceSale = $_POST['priceSale'];
$stockAlert = $_POST['stockAlert'];
$lotNo = $_POST['lot'];
$receipt = $_POST['receipt'];
$unit = $_POST['unit'];
$requiredFields = array("brandName", "description", "qty", "priceBought", "priceSale", "category", "receipt", "unit");

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo "error: Please fill in all required fields.";
        exit();
    }
}
$sql = "INSERT INTO tbl_products (brandName, description, lotNo, stock, unit, priceBought, priceSale, stockAlert, exp_date, category, receipt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisiiisss", $brandName, $description, $lotNo, $unit, $qty, $priceBought, $priceSale, $stockAlert, $exp_date, $category, $receipt);
$result = $stmt->execute();

if ($result) {
    echo "success";
} else {
    echo "error";
}

$stmt->close();
$conn->close();