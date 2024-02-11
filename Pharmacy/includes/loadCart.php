<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once 'dbCon.php';
    $transID = $_POST['transID'];
    $stmt = $conn->prepare("SELECT * FROM tbl_cart WHERE transID = ?");
    $stmt->bind_param("s", $transID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-id='" . $row['id'] . "' data-pid='" . $row['pID'] . "'>";
        echo "<td>" . $row['brandName'] . $row['description'] .  "</td>";
        echo "<td>" . "<button class='decrease'>-</button>" . "<span class='quantity'>" . $row['qty'] . "</span>" . "<button class='increase'>+</button>" . "</td>";
        echo "<td>" . $row['category'] . "</td>";
        echo "<td>" . $row['unit_price'] . "</td>";
        echo "<td>
                <a href='#' data-id='" . $row['id'] . "' data-pid='" . $row['pID'] . "' class='delete-button'><img class='col-img' src='./images/trash.png' alt='Delete'></a>
            </td>";
        echo "</tr>";
    }
    $stmt->close();
    $conn->close();