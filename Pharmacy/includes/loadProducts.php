<?php
require_once 'dbCon.php';

$sql = "SELECT * FROM tbl_products";
$result = mysqli_query($conn, $sql);

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['pID'] . "</td>";
    echo "<td>" . $row['brandName'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['stock'] . "</td>";
    echo "<td>" . $row['priceBought'] . "</td>";
    echo "<td>" . $row['exp_date'] . "</td>";
    echo "<td>" . $row['priceSale'] . "</td>";
    echo "<td><a href='#' data-id='" . $row['pID'] . "' class='edit-button'><img class='col-img' src='./images/editing.png' alt='Edit'></a></td>";
    echo "<td>
        <a href='#' data-id='" . $row['pID'] . "' class='delete-button'><img class='col-img' src='./images/trash.png' alt='Delete'></a>
        </td>";
    echo "</tr>";
}


mysqli_close($conn);