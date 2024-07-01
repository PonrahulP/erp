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
    <title>Bank To Bank Report</title>
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
                <h5><i class="bi bi-journal-richtext"></i> Bill To Bill Details</h5>
                <!-- <a href="index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Sales</a> -->
            </div>
            <div class="col-md-12 table-responsive mt-3">
                <table id="myTable" class="table table-bordered" style="border-color:black;">
                    <thead>
                        <tr>
                        <th>S.No</th>
                            <th>Customer</th>
                            <th>Bill.No</th>
                            <th>Date</th>
                            <th>Quantity</th>
                            <th>CGST%</th>
                            <th>CGST Amount</th>
                            <th>SGST%</th>
                            <th>SGST Amount</th>
                            <th>Total Amount</th>
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
     fetch("http://localhost/erp/bill_to_bill/read.php").then(
            res => {
                res.json().then(
                    data => {
                        if(data.data.length > 0){
                            var temp ="";
                            data.data.forEach((itemData)=>{
                                temp +="<tr>";
                                temp +="<td>" + itemData.id+"</td>";
                                temp +="<td><a href='../customer/table.php' style='text-decoration:none;'>" + itemData.customer_id+"</a></td>";
                                temp +="<td>"+itemData.bill_no+"</td>";
                                temp +="<td>"+itemData.sales_date+"</td>";
                                temp +="<td>" + itemData.quantity+"</td>";
                                temp +="<td>" + itemData.cgst+"</td>";
                                temp +="<td>" + itemData.cgst_amount+"</td>";
                                temp +="<td>" + itemData.sgst+"</td>";
                                temp +="<td>" + itemData.sgst_amount+"</td>";
                                temp +="<td>" + itemData.grand_total+"</td>";
                                temp +="</tr>";
                            });
                            document.getElementById('data').innerHTML= temp;
                        }
                    }
                )
            }
        )
  </script>
</html>