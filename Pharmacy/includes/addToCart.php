<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'dbCon.php';
$searchTerm = $_GET['term'];
$stmt = $conn->prepare("SELECT * FROM tbl_products WHERE pID LIKE ? OR brandName LIKE ? OR description LIKE ? OR category LIKE ?");
$likeTerm = '%' . $searchTerm . '%';
$stmt->bind_param('ssss', $likeTerm, $likeTerm, $likeTerm, $likeTerm);
$stmt->execute();
$result = $stmt->get_result();
echo '<table>';
echo '<tr>';
echo '<th>pID</th>';
echo '<th>Barcode</th>';
echo '<th>Category</th>';
echo '<th>Brand Name</th>';
echo '<th>Description</th>';
echo '<th>Stock</th>';
echo '<th>Purchase Price (₱)</th>';
echo '<th>Expiration Date</th>';
echo '<th>Unit Cost (₱)</th>';
echo '</tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['pID']) . '</td>';
    echo '<td>' . htmlspecialchars($row['barcode']) . '</td>';
    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
    echo '<td>' . htmlspecialchars($row['brandName']) . '</td>';
    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
    echo '<td>' . htmlspecialchars($row['stock']) . '</td>';
    echo '<td>' . htmlspecialchars($row['priceBought']) . '</td>';
    echo '<td>' . htmlspecialchars($row['exp_date']) . '</td>';
    echo '<td>' . htmlspecialchars($row['priceSale']) . '</td>';
    echo '</tr>';
}

echo '</table>';

$stmt->close();
$conn->close();
