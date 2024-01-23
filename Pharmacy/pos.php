<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
<link rel="stylesheet" href="./css/pos.css">
<div class="right-panel">
    <p class="name">Name</p>
    <p class="role">Role</p>
    <h1 class="title">Point of Sales</h1>
    <div class="main">
        <div class="carts">
            <div class="search-container">
                <input type="text" name="search" id="search" placeholder="Scan/Search Products">
                <button id="cancel">X</button>
            </div>
            <table id="cart">
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Price</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </table>
        </div>
    </div>
    <button id="newBTN" class="btn-new"> New Transaction</button>
</div>

<script>
$(document).ready(function() {
    var $results = $('<div id="results"></div>').insertAfter('#search');
    $results.hide();
    $('#search').on('input keyup', function() {
        var search = $(this).val();
        if (search !== '') {
            $(this).css('background-image', 'none');
            $results.show();
        } else {
            $(this).css('background-image', "url('./images/glass.png')");
            $results.hide();
        }
        $.ajax({
            url: './includes/addToCart.php',
            method: 'GET',
            data: {
                term: search
            },
            success: function(response) {
                var $table = $('<table></table>');
                var $tbody = $('<tbody></tbody>');
                $tbody.html(response);
                $table.append($tbody);
                $results.html($table);
                $results.find('tbody tr').on('click', function() {
                    $('#cart').append($(this).clone());
                });
            }
        });
    });
});
</script>
<?php
include_once './includes/footer.php';
?>