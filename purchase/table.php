<?php
session_start();
if (!isset($_SESSION['uname'])) {
    echo"<script> alert('Failed! Please Register')";
    header("Location: ../login/index.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </head>
  <body>
  <?php include("../navbar.php");?>
<?php include("../float.php");?>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h5><i class="bi bi-journal-richtext"></i> Purchase Details</h5>
                <a href="index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Purchase</a>
            </div>
            <div class="col-md-12 table-responsive mt-3">
                <table id="myTable" class="table table-bordered" style="border-color:black;"   >
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Bill Image</th>
                            <th>Bill.No</th>
                            <th>Supplier_id</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>CGST%</th>
                            <th>SGST%</th>
                            <th>Total Amount</th>
                            <!-- <th>Payment Type</th> -->
                            <th>Purchase Date</th>
                            <th>Delete</th>
                            <!-- <th>Edit</th> -->
                            <th>Bill</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    </tbody>
                </table>
            </div>
            <!-- row end -->
        </div>
        <!-- Container end -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
     integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
  </body>
  <script>
     fetch("http://localhost/erp/purchase/read.php").then(
            res => {
                res.json().then(
                    data => {
                        if(data.data.length > 0){
                            var temp ="";
                            data.data.forEach((itemData)=>{
                                temp +="<tr>";
                                temp +="<td>" + itemData.id+"</td>";
                                temp +="<td><img src='../images/"+itemData.bill_img+ "'alt='images' style='width:50px; height: 50px; object-fit: contain;'></td>";
                                temp +="<td>"+itemData.bill_no+"</td>";
                                temp +="<td><a href='../suppliers/table.php'>" + itemData.supplier_id+"</a></td>";
                                temp +="<td>" + itemData.product_code+"</td>";
                                temp +="<td>" + itemData.product_name+"</td>";
                                temp +="<td>" + itemData.quantity+"</td>";
                                temp +="<td>" + itemData.unit_price+"</td>";
                                temp +="<td>" + itemData.cgst+"</td>";
                                temp +="<td>" + itemData.sgst+"</td>";
                                temp +="<td>" + itemData.total+"</td>";
                                // temp +="<td>" + itemData.payment_type+"</td>";
                                temp +="<td>" + itemData.purchase_date+"</td>";
                                temp +="<td><i id='delete' class='bi bi-trash-fill' data-bill='"+ itemData.bill_no +"'></i></td>";
                                // temp +="<td><i id='edit' class='bi bi-pen-fill' data-bill='"+ itemData.bill_no +"'></i></td>";
                                temp +="<td><i  id='view' class='bi bi-eye-fill' data-bill='"+itemData.bill_no+"'></i></td>";
                                temp +="</tr>";
                            });
                            document.getElementById('data').innerHTML= temp;
                        }
                    }
                )
            }
        )
        $(document).on('click','#delete',function(){
                var bill=$(this).data('bill');
                var rowText=$(this).closest('tr').text().trim();
                var qty=$(this).closest('tr').find("td:eq(6)").html();
                // console.log(qty);
                var code=$(this).closest('tr').find("td:eq(4)").html();
                // console.log(code);
                var confirmation=confirm('Are you delete this item?');
                if(confirmation){
                    var deleteURL="http://localhost/erp/purchase/delete.php?bill="+bill+'&qty='+qty+'&code='+code;
                    $.ajax({
                        url:deleteURL,
                        method:'DELETE',
                        success:function(){
                            alert ("working");
                        }
                    });
                }
            });
         
    $(document).on('click','#view', function(){
      var bill=$(this).data('bill');
            var lastClickedCustomer={
            bill: bill,
            image: $(this).closest('tr').find('td:eq(1) img').attr('src'),
            };
            var confirmation=confirm ('Are you view this bill?');
        if(confirmation){
            window.location.href="http://localhost/erp/purchase/bill.php?bill="+bill +
            "&image=" + encodeURIComponent(lastClickedCustomer.image) ;
        }
    });
  </script>
</html>