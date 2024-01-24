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
                <input type="text" name="custName" id="custName" placeholder="Customer Name">
                <h4 id="transID"></h4>
                <button id="cancel">X</button>
            </div>
            <div id="tableCart">
            <table id="cart">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Price (₱)</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
            </div>
        <button id="cash">Cash</button>
        <button id="terms">Terms</button>
        </div>
        <div id="overlay" style="display: none;">
            <div id="popup">
                <h3>Enter Date of Payment</h3>
                <input class="inputs" type="date" name="dateTerms" id="dateTerms">
                <button class="btnAdd" id="confirm">Confirm</button>
                <button class="btnClose" id="closePopup">Close</button>
            </div>
        </div>
    </div>
    <div class="total">
    <div class="row">
        <h3>Subtotal</h3>
        <h3>VAT</h3>
        <h3>Total</h3>
    </div>
    <div class="row">
        <h3 id="subtotal">₱0.00</h3>
        <h3 id="vat">₱0.00</h3>
        <h3 id="total">₱0.00</h3>
    </div>
</div>

    <button id="newBTN" class="btn-new"> New Transaction</button>
</div>

<script>
$(document).ready(function() {
    var $results = $('<div id="results"></div>').insertAfter('#search');
    var d = new Date();
    var month = String(d.getMonth() + 1).padStart(2, '0');
    var day = String(d.getDate()).padStart(2, '0');
    var today = d.getFullYear() + '-' + month + '-' + day;
    var output = d.getFullYear() + (month<10 ? '0' : '') + month + (day<10 ? '0' : '') + day;
    $('#dateTerms').attr('min', today);
    $.ajax({
    url: './includes/getTransID.php',
    type: 'GET',
    success: function(data) {
        var newTransID = data;
        document.getElementById('transID').textContent = output+"000"+newTransID;
    },
    error: function(request, status, error) {
        console.log("Error: " + error);
    }
});
    $results.hide();
    $('.total').hide();
    $('.main').hide();
    $('#transID').hide();
    $('#newBTN').show();
    $('#newBTN').on('click', function() {
        $('.main').show();
        $('#newBTN').hide();
        $('transID').text('');
        $('#cart tbody').empty();
        $('.total').show();
    });
    $('#cancel').on('click', function() {
        $('.main').hide();
        $('#newBTN').show();
        $('.total').hide();
    });
    $('#terms').on('click', function() {
        $('#overlay').show();
    });
    $('#closePopup').on('click', function() {
        $('#overlay').hide();
    });
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
            url: './includes/getSearchResults.php',
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
                var rowData = $(this).children('td').map(function() {
                    console.log($(this).text());
                    return $(this).text();
                }).get();
                var transID = $('#transID').text();
                $.ajax({
                    url: './includes/insertIntoCart.php',
                    method: 'POST',
                    data: {
                        item: rowData,
                        transID: transID
                    },
                    success: function(response) {
                        $('#cart tbody').empty();
                        $.ajax({
                            url: './includes/loadCart.php',
                            method: 'POST',
                            data: {
                                transID: transID 
                            },
                            success: function(response) {
                                $('#cart').append(response);
                            },
                            error: function(request, status, error) {
                                console.log("Error: " + error);
                            }
                        });
                            $.ajax({
                                url: './includes/getCartItems.php', 
                                method: 'POST',
                                data: {
                                    transID: transID 
                                },
                                success: function(response) {
                                    console.log(response);
                                    var items = JSON.parse(response);
                                    console.log(items);
                                    var subtotal = 0;
                                    for (var i = 0; i < items.length; i++) {
                                        subtotal += items[i].price * items[i].qty;
                                    }
                                    var vatRate = 0.12;
                                    var totalBeforeVAT = subtotal / (1 + vatRate);
                                    var vat = subtotal - totalBeforeVAT;
                                    $('#subtotal').text('₱' + totalBeforeVAT.toFixed(2));
                                    $('#vat').text('₱' + vat.toFixed(2));
                                    $('#total').text('₱' + subtotal.toFixed(2));
                                },
                                error: function(request, status, error) {
                                    console.log("Error: " + error);
                                }
                                });
                    },
                    error: function(request, status, error) {
                        console.log("Error: " + error);
                    }
                });
            });
            }
        });
    });
    $('#cart').on('click', '.delete-button', function(e) {
    e.preventDefault();
    var pID = $(this).data('id');
    var transID = $('#transID').text();
    $.ajax({
        url: './includes/paVOID.php',
        method: 'POST',
        data: {
            pID: pID
        },
        success: function(response) {
            $('#cart tbody').empty();
            $.ajax({
                url: './includes/loadCart.php',
                method: 'POST',
                data: {
                    transID: transID 
                },
                success: function(response) {
                    $('#cart tbody').append(response);
                },
                error: function(request, status, error) {
                    console.log("Error: " + error);
                }
            });
        },
        error: function(request, status, error) {
            console.log("Error: " + error);
        }
    });
});
function calculateTotals() {
    var transID = $('#transID').text();
    $.ajax({
        url: './includes/getCartItems.php', 
        method: 'POST',
        data: {
            transID: transID 
        },
        success: function(response) {
            var items = JSON.parse(response);
            var subtotal = 0;
            for (var i = 0; i < items.length; i++) {
                subtotal += items[i].price * items[i].qty;
            }
            var vatRate = 0.12;
            var totalBeforeVAT = subtotal / (1 + vatRate);
            var vat = subtotal - totalBeforeVAT;
            $('#subtotal').text('₱' + totalBeforeVAT.toFixed(2));
            $('#vat').text('₱' + vat.toFixed(2));
            $('#total').text('₱' + subtotal.toFixed(2));
        },
        error: function(request, status, error) {
            console.log("Error: " + error);
        }
    });
}
$('#cart').on('click', '.increase', function() {
    var quantityElement = $(this).siblings('.quantity');
    var quantity = parseInt(quantityElement.text());
    quantityElement.text(quantity + 1);
    var transID = $('#transID').text();
    var pID = $(this).closest('tr').data('id');
    $.ajax({
        url: './includes/updateQuantity.php',
        method: 'POST',
        data: {
            pID: pID,
            transID: transID,
            quantity: quantity + 1
        },
        success: function(response) {
            console.log(response);
            calculateTotals();
        },
        error: function(request, status, error) {
            console.log("Error: " + error);
        }
    });
});

$('#cart').on('click', '.decrease', function() {
    var quantityElement = $(this).siblings('.quantity');
    var quantity = parseInt(quantityElement.text());
    var transID = $('#transID').text();
    var pID = $(this).closest('tr').data('id');
    if (quantity > 1) {
        $.ajax({
            url: './includes/updateQuantity.php', 
            method: 'POST',
            data: {
                pID: pID,
                transID: transID,
                quantity: quantity - 1
            },
            success: function(response) {
                console.log(response);
                calculateTotals();
            },
            error: function(request, status, error) {
                console.log("Error: " + error);
            }
        });
    }
});
});

</script>
<?php
include_once './includes/footer.php';
?>