<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
<link rel="stylesheet" href="./css/records.css">
<div class="right-panel">
    <p class="name">Name</p>
    <p class="role">Role</p>
    <h1 class="title">Records</h1>
    <div id="records-container">
        <div id="search-container">
            <input class="inputs" type="text" id="search-records" placeholder="Search Records">
        <table id="records">
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $.ajax({
    url: './includes/getRecords.php',
    type: 'get',
    dataType: 'json',
    success: function(data) {
        console.log(data);
        var table = $('#records');
        table.empty();
        table.append('<tr><th>Transaction ID</th><th>Customer Name</th><th>Purchase Date</th><th>Status</th><th>View</th></tr>');
        $.each(data, function(i, record) {
        console.log('Record ' + (i+1) + ': ', record);
        var row = $('<tr>');
        row.append('<td>' + record.transID + '</td>');
        row.append('<td>' + record.name + '</td>');
        row.append('<td>' + record.datePurchased + '</td>');
        row.append('<td>' + record.status + '</td>');
        row.append('<td><button class="btnAdd" id="view" data-transid="' + record.transID + '" data-custname="' + record.name + '">View</button></td>');
        table.append(row);
    });
    }
});

    $('#records').on('click', '#view', function(e) {
    var transID = $(this).data('transid');
    var custName = $(this).data('custname');
    window.location.replace("./orderSummary.php?transID=" + transID + "&custName=" + custName);
    });
});
</script>
<?php
include_once './includes/footer.php';
?>