<?php
session_start();
require ("../dbconfig.php");
require ("data.php");
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
    <title>ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
     crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  </head>
  <style>
            #blink {
                animation: blinker 1.5s linear infinite;
                text-color: red;
                font-family: sans-serif;
            }
            @keyframes blinker {
                50% {
                    opacity: 0.5;
                }
            }
        </style>
  <body>
  <?php include("../navbar.php");?>
<!-- cards -->
<div class="row mt-3 align-baseline py-2">
  <div class="col-sm-3 mb-3 mb-sm-0 align-items-stretch">
    <div class="card text-bg-secondary mb-3 py-2">
      <div class="card-body">
        <h4 class="card-title"><i class="bi bi-cart-fill h3"></i></h4>
        <h5 class="card-text text-warning">Total Sales:<a id="blink" class="text-danger" style="text-decoration:none;">
          <?php
          include ("../dbconfig.php");
          $sql="SELECT bill_no FROM sales1";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_num_rows($result)){
            echo $row;
          }
          else{
            echo "No Data";
          }
          ?></a><br>
          Total Customers:<a id="blink" class="text-danger" style="text-decoration:none;">
          <?php
          include ("../dbconfig.php");
          $sql="SELECT customer_id FROM customers";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_num_rows($result)){
            echo $row;
          }
          else{
            echo "No Data";
          }
          ?></a>
        </h4>
        <hr>
        <a href="../sales/table.php" class="btn btn-primary"><i class="bi bi-journal-richtext"></i> Sales Report</a>
      </div>
    </div>
  </div>
  <div class="col-sm-3 align-items-stretch">
    <div class="card text-bg-secondary mb-3 py-2">
      <div class="card-body mh-100 d-inline-block">
        <h4 class="card-title mt-0"><i class="bi bi-bag-fill h3"></i></h4>
        <h5 class="card-text text-warning align-items-stretch">Total Purchase: <a id="blink" class="text-danger" style="text-decoration:none;">   
        <?php
          include ("../dbconfig.php");
          $sql="SELECT bill_no FROM purchase1";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_num_rows($result)){
            echo $row;
          }else{
            echo "No Data";
          }
          ?></a>
          <br>
           Total Suppliers:<a id="blink" class="text-danger" style="text-decoration:none;">
           <?php
          include ("../dbconfig.php");
          $sql="SELECT supplier_id FROM suppliers";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_num_rows($result)){
            echo $row;
          }else{
            echo "No Data";
          }
          ?></a>
        </h5>
        <hr>
        <a href="../purchase/table.php" class="btn btn-primary"><i class="bi bi-journal-richtext"></i> Purchase Report</a>
      </div>
    </div>
  </div>
        <!-- </div> -->
        <!-- <div class="row mt-2"> -->

<div class="col-sm-3 mh-25 d-inline-block align-items-stretch">
    <div class="card text-bg-secondary mb-3 py-2">
  
      <div class="card-body mh-25 d-inline-block">
        <h4 class="card-title mt-0"> <i class="bi bi-bank2 h3"></i></h4>
        <h5 class="card-text text-warning py-0.2">Opening:<a id="blink" class="text-danger" style="text-decoration:none;" href='../users/index.php'>
          <!-- <h5 id="blink"> -->
        <?php
          include ("../dbconfig.php");
          $sql="SELECT opening_bank_balance FROM users";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_fetch_assoc($result)){
            // $res=mysqli_fetch_assoc($row,MYSQLI_ASSOC);
            echo $row['opening_bank_balance'];
          }else{
            echo "No Data";
          }
          ?></a><br>
          Current:<a class="text-danger" id="blink" href="../balance/index.php" style="text-decoration:none;">
        <?php
          include ("../dbconfig.php");
          $sql="SELECT amount FROM balance WHERE payment_type='bank'";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_fetch_assoc($result)){
            // $res=mysqli_fetch_assoc($row,MYSQLI_ASSOC);
            echo $row['amount'];
          }else{
            echo "No Data";
          }
          ?></a>
        </h4>
        <hr>
        <a href="../balance/bank_balance.php" class="btn btn-primary"><i class="bi bi-journal-richtext"></i> Balance Report</a>
      </div>
    </div>
  </div>
<div class="col-sm-3 mh-25 d-inline-block align-items-stretch">
    <div class="card text-bg-secondary mb-3 py-2">
      <div class="card-body mh-25 d-inline-block">
        <h4 class="card-title"><i class="bi bi-wallet2 h3"></i></h4>
        <h5 class="card-text text-warning align-items-stretch">Opening:<a id="blink" class="text-danger" style="text-decoration:none;" href='../users/index.php'>
        <?php
          include ("../dbconfig.php");
          $sql="SELECT opening_cash_balance FROM users";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_fetch_assoc($result)){
            // $res=mysqli_fetch_assoc($row,MYSQLI_ASSOC);
            echo $row['opening_cash_balance'];
          }else{
            echo "No Data";
          }
          ?></a><br>
          Current: <a id="blink" class="text-danger"  href="../balance/index.php" style="text-decoration:none;">
        <?php
          include ("../dbconfig.php");
          $sql="SELECT amount FROM balance WHERE payment_type='cash'";
          $result=mysqli_query($conn,$sql);
          if($row=mysqli_fetch_assoc($result)){
            // $res=mysqli_fetch_assoc($row,MYSQLI_ASSOC);
            echo $row['amount'];
          }else{
            echo "No Data";
          }
          ?></a>
        </h4>
        <hr>
        <a href="../balance/cash_balance.php" class="btn btn-primary"><i class="bi bi-journal-richtext"></i> Balance Report</a>
      </div>
    </div>
  </div>
<!-- </div> -->
        </div>
        </div>
<hr>
<div class="row">
  <div class="col-sm-4">
<div class="card" style="width: 25rem; border-color:black;">
  <div class="card-body">
    <h5 class="card-title" style="text-align:center;">Sales Graph</h5>
    <p class="card-text"><canvas id="myChart" width="5px" height="5px"></canvas></p>
  </div>
</div>
        </div>

<div class="card" style="width: 50rem;border-color:black;">
  <div class="card-body">
    <h5 class="card-title" style="text-align:center;">Sales Report</h5>
    <hr>
    <table class="table table-bordered" style="border-color:black;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Customer Id</th>
                            <th>Bill.No</th>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                    </tbody>
                </table>
  </div>
</div>
        </div>
        

<script>
        // Pass PHP data to JavaScript
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;
        
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // or 'line', 'pie', etc.
            data: {
                labels: labels,
                datasets: [{
                    label: 'QUANTITY',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                legend:{ display: false },
                // label:{
                    // display:true,
                    // text:'marks'
                // }
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

     fetch("http://localhost/erp/sales/read.php").then(
            res => {
                res.json().then(
                    data => {
                        if(data.data.length > 0){
                            var temp ="";
                            data.data.forEach((itemData)=>{
                                temp +="<tr>";
                                temp +="<td>" + itemData.id+"</td>";
                                temp +="<td><a href='../customer/table.php'>" + itemData.customer_id+"</a></td>";
                                temp +="<td>"+itemData.bill_no+"</td>";
                                temp +="<td>" + itemData.product_name+"</td>";
                                temp +="<td>" + itemData.product_code+"</td>";
                                temp +="<td>" + itemData.quantity+"</td>";
                                temp +="<td>" + itemData.unit_price+"</td>";
                                temp +="<td><a href='../sales/table.php'>" + itemData.grand_total+"</a></td>";
                                temp +="</tr>";
                            });
                            document.getElementById('data').innerHTML= temp;
                        }
                    }
                )
            }
        )
    </script>
</body>

</html>
