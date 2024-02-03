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
        <h3 id="subtotal"></h3>
        <h3 id="vat"></h3>
        <h3 id="total"></h3>
    </div>
</div>

    <button id="newBTN" class="btn-new"> New Transaction</button>
    <div id="myModal" class="modal">
    <div class="modal-content">
        <p id="modalMessage"></p>
    </div>
</div>

</div>

<script>

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
    // $('#transID').hide();
    $('#newBTN').show();
    $('#cart').hide();
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
        var custName = $('#custName').val();
        var transID = $('#transID').text();
        if (!custName) {
        showMessage('Please add customer name', 1000);
        return;
        }
        $.ajax({
            url: './includes/updateCart.php', 
            method: 'POST',
            data: {
                custName: custName,
                operation: 'updateCustName',
                transID: transID
            },
            success: function(response) {
                console.log(response);
                $('#overlay').show();
            },
            error: function(request, status, error) {
                console.log("Error: " + error);
            }
        });
    });
    $('#confirm').on('click', function() {
    calculateTotals();
    var transID = $('#transID').text();
    var dateTerms = $('#dateTerms').val();
    var custName = $('#custName').val();
    var subtotal = $('#subtotal').val();
    var vat = $('#vat').val();
    var total = $('#total').val();
    console.log(transID + subtotal + vat + total);
    $.ajax({
        url: './includes/updateCart.php', 
        method: 'POST',
        data: {
            dateTerms: dateTerms,
            operation: 'confirmTerms',
            transID: transID,
            custName: custName,
            subtotal: subtotal,
            vat: vat,
            total: total
        },
        success: function(response) {
            showMessage('Transaction completed', 1000);
            $('.main').hide();
            $('#newBTN').show();
            $('transID').text('');
            $('#cart tbody').empty();
            $('.total').hide();
            $('#overlay').hide();
            $('#custName').val('');
            $('#dateTerms').val('');
            $('#popup').hide();
        },
        error: function(request, status, error) {
            console.log("Error: " + error);
        }
    });
});

$('#cash').on('click', function(e) {
    e.preventDefault();
    var transID = $('#transID').text();
    var custName = $('#custName').val();
    if (!custName) {
        showMessage('Please add customer name', 1000);
        return;
    }
    $.ajax({
        url: './includes/updateCart.php',
        method: 'POST',
        data: {
            transID: transID,
            operation: "cash",
            custName: custName
        },
        success: function(response) {
            showMessage('Transaction completed', 1000);
            $('#cart tbody').empty();
            $('.main').hide();
            $('#newBTN').show();
            $('.total').hide();
            $('#custName').val('');
            $('#transID').text('');
            $('#total').text('');
            $('#vat').text('');
            $('#subtotal').text('');
        },
        error: function(request, status, error) {
            console.log("Error updating status: " + error);
        }
    });
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
                var $customer = $('#custName').val();
                $tbody.html(response);
                $table.append($tbody);
                $results.html($table);
                $results.find('tbody tr').on('click', function() {
                var rowData = $(this).children('td').map(function() {
                    $('#cart').show();
                    return $(this).text();
                }).get();
                var transID = $('#transID').text();
                $.ajax({
                    url: './includes/insertIntoCart.php',
                    method: 'POST',
                    data: {
                        item: rowData,
                        transID: transID,
                        customer: $customer
                    },
                    success: function(response) {
                        $('#cart tbody').empty();
                        $('#search').val('');
                        $results.hide();
                        $('#search').focus();
                        console.log(response);
                        showMessage('Success adding into cart', 1000);
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
    var quantity = $(this).closest('tr').find('.quantity').text();
        $.ajax({
        url: './includes/paVOID.php',
        method: 'POST',
        data: {
            pID: pID,
            transID: transID,
            operation: "deleteCart"
        },
        success: function(response) {
            $('#cart tbody').empty();
            calculateTotals();
            $.ajax({
                url: './includes/loadCart.php',
                method: 'POST',
                data: {
                    transID: transID 
                },
                success: function(response) {
                    $('#cart tbody').append(response);
                    $.ajax({
                        url: './includes/updateStock.php',
                        method: 'POST',
                        data: {
                            pID: pID,
                            quantity: quantity
                        },
                        success: function(response) {
                            console.log("Stock updated successfully");
                            console.log(response);
                            console.log(quantity + " " + pID)
                        },
                        error: function(request, status, error) {
                            console.log("Error updating stock: " + error);
                        }
                    });
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

var originalQuantities = {};

$('#cart').on('click', '.increase, .decrease', function() {
    var operation = $(this).hasClass('increase') ? 'increase' : 'decrease';
    var quantityElement = $(this).siblings('.quantity');
    var quantity = parseInt(quantityElement.text());
    var transID = $('#transID').text();
    var pID = $(this).closest('tr').data('id');
    if (!originalQuantities[pID]) {
        originalQuantities[pID] = quantity;
    }
    if (operation == 'increase' || (operation == 'decrease' && quantity > 1)) {
        quantityElement.text(operation == 'increase' ? quantity + 1 : quantity - 1);
        $.ajax({
            url: './includes/updateQuantity.php', 
            method: 'POST',
            data: {
                pID: pID,
                transID: transID,
                quantity: operation == 'increase' ? quantity + 1 : quantity - 1,
                operation: operation
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

$('#cancel').on('click', function(e) {
    e.preventDefault();
    var transID = $('#transID').text();
    var rows = $('#cart tbody tr');
    rows.each(function() {
        var row = $(this);
        var pID = row.data('id');
        var quantity = row.find('.quantity').text();
        $.ajax({
            url: './includes/updateStock.php',
            method: 'POST',
            data: {
                pID: pID,
                quantity: quantity
            },
            success: function(response) {
                console.log("Stock updated successfully");
            },
            error: function(request, status, error) {
                console.log("Error updating stock: " + error);
            }
        });
    });
        $.ajax({
        url: './includes/paVOID.php',
        method: 'POST',
        data: {
            transID: transID,
            operation: "cancelCart"
        },
        success: function(response) {
            console.log("All items deleted from cart");
            $('#cart tbody').empty();
        },
        error: function(request, status, error) {
            console.log("Error deleting items from cart: " + error);
        }
    });
});

});
function showMessage(message, timeout = 3000) {
    $('#modalMessage').text(message);
    $('#myModal').show();
    setTimeout(function() {
        $('#myModal').hide();
    }, timeout);
}

</script>
<?php
include_once './includes/footer.php';
?>