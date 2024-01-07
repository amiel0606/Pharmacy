<?php
include_once './includes/header.php';
if (!isset($_SESSION["uID"])) {
    header("location: ./index.php");
    exit();
}
?>
    <div class="right-panel">
        <p class="name">Name</p>
        <p class="role">Role</p>
        <h1 class="title">Inventory</h1>
        <div class="table-products">
            <table id="product-grid">
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="overlay" style="display: none;">
            <div id="popup">
                <div class="error-container" style="display:none;">
                    <p id="error" style="display:none;"></p>
                    <button id="closeError" style="display:none;">X</button>
                </div>
                <form action="./includes/addProduct.php" method="post">
                    <input required class="inputs" placeholder="Barcode" type="text" name="barcode" id="barcode">
                    <select required name="category" id="category">
                        <option value="" disabled selected hidden>Category</option>
                        <option value="Medicine">Medicine</option>
                        <option value="Supply">Supply</option>
                    </select>
                    <input required class="inputs" placeholder="Brand Name" type="text" name="brandName" id="brandName">
                    <input required class="inputs" placeholder="Description" type="text" name="description" id="description">
                    <input required class="inputs" placeholder="Quantity" type="number" name="qty" id="qty">
                    <input required class="inputs" placeholder="Price Bought" type="number" name="priceBought" id="priceBought">
                    <input class="inputs" placeholder="Expiration Date" type="date" name="exp_date" id="exp_date">
                    <input required class="inputs" placeholder="Price for Sale" type="number" name="priceSale" id="priceSale">
                    <input class="btnAdd" id="add" name="add" type="submit" value="Add Product"></input>
                </form>
                <button class="btnClose" id="closePopup">Close</button>
            </div>
        </div>
        <button class="btnAdd" id="addProductButton">Add Product</button>
            <div id="edit-form-container" style="display:none">
                <form id="edit" method="post">
                    <input required class="inputs" placeholder="id" type="hidden" name="edit-id" id="edit-id">
                    <input required class="inputs" placeholder="Barcode" type="text" name="edit-barcode" id="edit-barcode">
                        <select required name="edit-category" id="edit-category">
                            <option value="" disabled selected hidden>Category</option>
                            <option value="Medicine">Medicine</option>
                            <option value="Supply">Supply</option>
                        </select>
                    <input required class="inputs" placeholder="Brand Name" type="text" name="edit-brandName" id="edit-brandName">
                    <input required class="inputs" placeholder="Description" type="text" name="edit-description" id="edit-description">
                    <input required class="inputs" placeholder="Quantity" type="number" name="edit-qty" id="edit-qty">
                    <input required class="inputs" placeholder="Price Bought" type="number" name="edit-priceBought" id="edit-priceBought">
                    <input class="inputs" placeholder="Expiration Date" type="date" name="edit-exp_date" id="edit-exp_date">
                    <input required class="inputs" placeholder="Price for Sale" type="number" name="edit-priceSale" id="edit-priceSale">
                    <input class="btnAdd" id="save" name="save" type="submit" value="Save"></input>
                </form>
                <button class="btnClose" id="closeEditPopup">Close</button>
            </div>
    </div>
<script>
$(document).ready(function() {
    function loadProducts() {
        return $.ajax({
            url: 'includes/loadProducts.php',
            type: 'GET'
        }).done(function(data) {
            var headers = '<tr><th>pID</th><th>Brand Name</th><th>Description</th><th>Category</th><th>Stock</th><th>Price Bought</th><th>Expiration Date</th><th>Price Sale</th><th>Edit</th><th>Delete</th></tr>';
            $('#product-grid').html(headers + data);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log('AJAX request failed: ' + textStatus);
        });
    }
    function deleteProduct(pID) {
        $.ajax({
            type: 'POST',
            url: 'includes/deleteProduct.php',
            data: {pID: pID, delete: true},
            success: function() {
                loadProducts();
                alert('Product deleted successfully');
            },
            error: function() {
                alert('Error deleting product');
            }
        });
    }
    function editProduct(formData) {
        $.ajax({
            url: 'includes/editProducts.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                alert('Product updated successfully!');
                loadProducts();
                $('#edit-form-container').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX request failed: ' + textStatus);
            }
        });
    }
    function addProduct(formData) {
        $.ajax({
            url: 'includes/addProduct.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                loadProducts();
                alert('Product added successfully!');
                $('#overlay').hide();
                $('#popup').hide();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Product not added!' + textStatus);
                console.log('AJAX request failed: ' + textStatus);
            }
        });
    }
    $('#product-grid').on('click', '.delete-button', function(e) {
        e.preventDefault();
        var pID = $(this).data('id');
        deleteProduct(pID);
    });
    $('#save').click(function(e) {
        e.preventDefault();
        var formData = $('#edit').serialize();
        editProduct(formData);
    });
    $('#product-grid').on('click', '.edit-button', function(e) {
        e.preventDefault();
        var pID = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'includes/getProduct.php',
            data: {id: pID},
            success: function(response) {
                var product = response.split(',');
                $('#edit-id').val(product[0]);
                $('#edit-barcode').val(product[1]);
                $('#edit-category').val(product[2]);
                $('#edit-brandName').val(product[3]);
                $('#edit-description').val(product[4]);
                $('#edit-qty').val(product[5]);
                $('#edit-priceBought').val(product[6]);
                $('#edit-exp_date').val(product[8]);
                $('#edit-priceSale').val(product[7]);
                $('#edit-form-container').show();
            },
            error: function() {
                alert('Error getting product details');
            }
        });
    });
    $('#add').click(function(e) {
        e.preventDefault();
        var formData = $('form').serialize();
        addProduct(formData);
    });
    $('#addProductButton').click(function() {
        $('#overlay').show();
        $('#popup').show();
    });
    $('#closePopup').click(function() {
        $('#overlay').hide();
        $('#popup').hide();
    });
    $('#closeEditPopup').click(function() {
        $('#overlay').hide();
        $('#edit-form-container').hide();
    });
    loadProducts();
});
</script>
<?php 
include_once './includes/footer.php';
?>