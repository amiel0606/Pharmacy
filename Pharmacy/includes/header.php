<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./images/logo.png">
    <title>Cure-Med</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/inventory.css">
    <link rel="stylesheet" href="./css/settings.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION['uID'])) {
        if ($_SESSION['role'] == 'Employee') {
            echo "<div style='display:block' class='left-panel'>";
            echo "<img class='DashLogo' src='./images/logo.jpg'>";
            echo "<h3 class='logo-text'> CureMed Pharma and Medical Supplies Trading</h3>";
            echo "<ul>";
            echo "<li class='links'> <img class='logo-left' src='./images/dashboard.png'><a  class='links' href='./dashboard.php'>Dashboard </a></li>";
            echo "<li class='links'> <img class='logo-left' src='./images/pos.png'><a  class='links' href='#'>Point of Sales </a></li>";
            echo "<li class='links' style='display: none;'> <img class='logo-left' src='./images/inventory.png'><a  class='links' href='./inventory.php'>Inventory </a></li>";
            echo "<li class='links style='display: none;'> <img class='logo-left' src='./images/file.png'><a  class='links' href='./records.php'>Records </a></li>";
            echo "<li class='links' style='display: none;'> <img class='logo-left' src='./images/gear.png'><a  class='links' href='./settings.php'>Settings </a></li>";
            echo "<li class='links'> <img class='logo-left' src='./images/logout.png'><a  class='links' href='./includes/logout.php'>Logout </a></li>";
            echo "</ul>";
            echo "</div>";
        }
        else {
            echo "<div style='display:block' class='left-panel'>";
            echo "<img class='DashLogo' src='./images/logo.jpg'>";
            echo "<h3 class='logo-text'> CureMed Pharma and Medical Supplies Trading</h3>";
            echo "<ul>";
                echo "<li class='links'> <img class='logo-left' src='./images/dashboard.png'><a  class='links' href='./dashboard.php'>Dashboard </a></li>";
                echo "<li class='links'> <img class='logo-left' src='./images/pos.png'><a  class='links' href='./pos.php'>Point of Sales </a></li>";
                echo "<li class='links'> <img class='logo-left' src='./images/inventory.png'><a  class='links' href='./inventory.php'>Inventory </a></li>";
                echo "<li class='links'> <img class='logo-left' src='./images/file.png'><a  class='links' href='./records.php'>Records </a></li>";
                echo "<li class='links'> <img class='logo-left' src='./images/gear.png'><a  class='links' href='./settings.php'>Settings </a></li>";
                echo "<li class='links'> <img class='logo-left' src='./images/logout.png'><a  class='links' href='./includes/logout.php'>Logout </a></li>";
            echo "</ul>";
        echo "</div>";
        }
    }
    else {
        echo "<div style='display:none' class='left-panel'>";
        echo "<img class='DashLogo' src='./images/logo.jpg'>";
        echo "<h3 class='logo-text'> CureMed Pharma and Medical Supplies Trading</h3>";
        echo "<ul>";
            echo "<li class='links'> <img class='logo-left' src='./images/dashboard.png'><a  class='links' href='./dashboard.php'>Dashboard </a></li>";
            echo "<li class='links'> <img class='logo-left' src='./images/pos.png'><a  class='links' href='#'>Point of Sales </a></li>";
            echo "<li class='links'> <img class='logo-left' src='./images/inventory.png'><a  class='links' href='./inventory.php'>Inventory </a></li>";
            echo "<li class='links'> <img class='logo-left' src='./images/gear.png'><a  class='links' href='./settings.php'>Settings </a></li>";
            echo "<li class='links'> <img class='logo-left' src=''./images/logout.png'><a  class='links' href='./logout.php'>Logout </a></li>";
        echo "</ul>";
    echo "</div>";
    }
    ?>
<script>
        $(document).ready(function(){
            $.ajax({
                url: './includes/getUserData.php',
                type: 'post',
                data: {username: '<?php if(isset($_SESSION["username"])){echo $_SESSION["username"];} else{echo"Not logged in";} ?>'},
                success: function(response){
                    var data = response.split(',');
                    $('.name').text(data[0] + ' ' + data[1]);
                    $('.role').text(data[3]);
                    $('#fnames').val(data[0]);
                    $('#lnames').val(data[1]);
                    $('#unames').val(data[2]);
                    $('#roless').val(data[3]);
                }
            });
        });
</script>