<?php
    include_once 'dbCon.php';
    $sql = "SELECT id FROM tbl_cart ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $lastTransID = $row["id"];
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    $newTransID = substr($lastTransID, 0, -1) . ((substr($lastTransID, -1) + 1) % 10);
    echo $newTransID;