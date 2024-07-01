<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo "<script>alert('Failed! Please Register');</script>";
    header("Location: ../login/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../navbar.php");?>
<?php include("../float.php");?>

<div class="container mt-5">
    <div class="row">
        <div class="d-flex justify-content-between">
            <h5><i class="bi bi-journal-richtext"></i> Products Details</h5>
            <a href="index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Products</a>
        </div>
        <div class="col-md-12 table-responsive mt-3">
            <table id="example" class="display table table-bordered" style="width:100%;border-color:black;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="data">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    fetch("http://localhost/erp/products/read.php").then(
        res => {
            res.json().then(
                data => {
                    if(data.data.length > 0){
                        var temp ="";
                        data.data.forEach((itemData, index)=>{
                            temp +="<tr>";
                            temp +="<td>" + (index + 1) +"</td>";
                            temp +="<td><img src='../images/"+itemData.image+ "'alt='images' style='width:50px; height: 50px; object-fit: contain;'></td>";
                            temp +="<td>" + itemData.product_name+"</td>";
                            temp +="<td>" + itemData.product_code+"</td>";
                            temp +="<td>" + itemData.description+"</td>";
                            temp +="<td>" + itemData.unit_price+"</td>";
                            temp +="<td>" + itemData.quantity+"</td>";
                            temp +="<td><i id='delete' class='bi bi-trash-fill' data-id='"+ itemData.id +"'></i></td>";
                            temp +="<td><i id='edit' class='bi bi-pen-fill' data-id='"+ itemData.id +"'></i></td>";
                            temp +="</tr>";
                        });
                        document.getElementById('data').innerHTML= temp;
                        table.rows.add($(temp)).draw();  // Add the rows to the DataTable
                    }
                }
            )
        }
    );

    $(document).on('click','#delete',function(){
        var id=$(this).data('id');
        var rowText=$(this).closest('tr').text().trim();
        var confirmation=confirm('Are you sure you want to delete this item?');
        if(confirmation){
            var deleteURL="http://localhost/erp/products/delete.php?id="+id;
            $.ajax({
                url: deleteURL,
                method: 'DELETE',
                success: function(){
                    alert("Item deleted successfully");
                    location.reload();  // Reload the page to see the changes
                }
            });
        }
    });

    $(document).on('click','#edit', function(){
        var id=$(this).data('id');
        var lastClickedCustomer={
            id: id,
            image: $(this).closest('tr').find('td:eq(1) img').attr('src'),
            name: $(this).closest('tr').find('td:eq(2)').text(),
            code: $(this).closest('tr').find('td:eq(3)').text(),
            description: $(this).closest('tr').find('td:eq(4)').text(),
            uprice: $(this).closest('tr').find('td:eq(5)').text(),
            qty: $(this).closest('tr').find('td:eq(6)').text(),
        };
        var confirmation = confirm('Are you sure you want to edit this data?');
        if(confirmation){
            window.location.href="http://localhost/erp/products/form_update.php?id="+ id +
                "&image=" + encodeURIComponent(lastClickedCustomer.image) +
                "&name=" + encodeURIComponent(lastClickedCustomer.name) +
                "&code=" + encodeURIComponent(lastClickedCustomer.code) +
                "&description=" + encodeURIComponent(lastClickedCustomer.description) +
                "&uprice=" + encodeURIComponent(lastClickedCustomer.uprice) +
                "&qty=" + encodeURIComponent(lastClickedCustomer.qty) ;
        }
    });
});
</script>
</body>
</html>
