<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
<link rel="stylesheet" href="./css/records.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>

<div class="right-panel">
    <p class="name">Name</p>
    <p class="role">Role</p>
    <h1 class="title">Order Summary</h1>
    <div id="orderSummary-container">
        <p id="dateToPay"></p>
        <table id="orderSummary">
            <tr>

            </tr>
        </table>
        <button id="saveAsPDF">Save as PDF</button>
        <div id="totalPrice">

        </div>
</div>
<script>
$(document).ready(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var transID = urlParams.get('transID');
    var custName = urlParams.get('custName');
    $.ajax({
        url: './includes/viewRecord.php',
        type: 'POST',
        data: {transID: transID, custName: custName},
        dataType: 'json',
        success: function(items) {
            var cart = $('#orderSummary');
            cart.empty();
            cart.append('<tr><th>Transaction ID</th><th>Product</th><th>Category</th><th>Quantity</th><th>Price</th><th>Purchase Date</th></tr>');
            var totalPrice = 0;
            $.each(items, function(i, item) {
                var row = $('<tr>').attr('data-id', item.pID);
                row.append('<td>' + item.transID + '</td>');
                row.append('<td>' + item.brandName + " " + item.description + '</td>');
                row.append('<td>' + item.category + '</td>');
                row.append('<td>' + item.qty + '</td>');
                row.append('<td>' + item.price + '</td>');
                row.append('<td>' + item.datePurchased + '</td>');
                cart.append(row);
                totalPrice += item.price;
                if (item.status === 'Terms') {
                    $('#dateToPay').text('Date to Pay: ' + item.dateToPay);
                }
            });
            $('#totalPrice').text('Total Price: ' + totalPrice.toFixed(2));
        }
    });
});

$('#saveAsPDF').click(function() {
    var urlParams = new URLSearchParams(window.location.search);
    var transID = urlParams.get('transID');
    var custName = urlParams.get('custName');
    $.ajax({
        url: './includes/viewRecord.php',
        type: 'POST',
        data: {transID: transID, custName: custName},
        success: function(itemsString) {
            var items = JSON.parse(itemsString);
            console.log(items);
            var tableData = items.map(function(item, index) {
                return [
                    index + 1,
                    item.brandName, 
                    item.description + " \nExpiry date: " + item.exp_date, 
                    item.price, 
                    item.qty, 
                    item.unit ? item.unit : '',
                    item.lotNo,
                    item.price * item.qty
                ];
            });
            console.log(tableData);
            var datePurchased = items.length > 0 ? items[0].datePurchased : '';
            var invoiceTemplate = {
                outputType: jsPDFInvoiceTemplate.OutputType.Save,
                returnJsPDFDocObject: true,
                fileName: "Invoice 2021",
                orientationLandscape: false,
                compress: true,
                logo: {
                    src: "./images/logo.jpg",
                    type: 'jpg',
                    width: 20.23,
                    height: 20.21,
                    margin: {
                        top: 0,
                        left: 0
                    }
                },
                stamp: {
                    inAllPages: true, 
                    src: "./images/logo.jpg",
                    type: 'JPG', 
                    width: 20,
                    height: 20,
                    margin: {
                        top: 0,
                        left: 0
                    }
                },
                business: {
                    name: "CureMed Pharma and Medical Supplies Trading",
                    address: "684 Concordia Rizal Ave Ext, Malabon, 1470 Metro Manila",
                    phone: "8810 - 4112",
                    email: "curemedmedicalsupplies@gmail.com",
                    email_1: "09357176995",
                    website: "",
                },
                contact: {
                    label: "Invoice issued for:",
                    name: custName,
                },
                invoice: {
                    invDate: "Date Purchased: " + datePurchased,
                    headerBorder: false,
                    tableBodyBorder: false,
                    header: [
                        {title: "#", style: {width: 10}},
                        {title: "Brand Name", style: {width: 30}}, 
                        {title: "Description", style: {width: 50}}, 
                        {title: "Unit Price"},
                        {title: "Quantity"},
                        {title: "Unit"},
                        {title: "Lot Number"},
                        {title: "Amount"}
                    ],
                    table: tableData,
                    additionalRows: [],
                    invDescLabel: "",
                    invDesc: "",
                },
                footer: {
                    text: "Thank you for your business",
                },
                pageEnable: true,
                pageLabel: "Page ",
            };
            var pdfObject = jsPDFInvoiceTemplate.default(invoiceTemplate);
        }
    });
});
</script>
<?php
include_once './includes/footer.php';
?>