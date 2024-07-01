<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .invoice-container {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
        }
        .table thead th {
            background-color: #f1f1f1;
        }
        .summary-table td {
            border: none;
        }
        .company-logo {
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="container invoice-container">
        <div class="row">
            <div class="col-md-6">
                <img src="../images/mobile.jpg" alt="Company Logo" class="company-logo">
                <h2>ERP</h2>
                <p>
                    AAA,<br>
                    BBB,<br>
                    CCC,<br>
                    Phone:9876543210<br>
                    Email: erp@gmail.com
                </p>
            </div>
            <?php
            include("../dbconfig.php");
            $bill=$_GET['bill'];
            $sql="SELECT sales_date,invoice_no FROM sales1 WHERE bill_no='$bill'";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
            ?>
            <div class="col-md-6 text-right">
                <h4>Invoice</h4>
                <p>
                    <strong>Date:</strong><?php echo $row['sales_date'];?><br>
                    <strong>Invoice #:</strong> <?php echo $row['invoice_no'];?>
                    <?php
                }
            }
            ?>
             <?php
            include("../dbconfig.php");
            $cus=$_GET['customer'];
            $sql="SELECT name,contact,address,email FROM customers WHERE customer_id='$cus'";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
            ?>
                </p>
                <h4>Customer Details</h4>
                <p>
                    <?php echo $row['name'];?><br>
                    <?php echo $row['address'];?><br>
                    <?php echo $row['contact'];?><br>
                    <?php echo $row['email'];?>
                </p>
                <?php
                }
            }
            ?>
            </div>
        </div>
        <table class="table table-bordered mt-4">
            <thead class="thead-dark">
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php
            include("../dbconfig.php");
            $bill1=$_GET['bill'];
            $sql="SELECT product_name,quantity,unit_price,total FROM sales2 WHERE bill_no='$bill1'";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
               echo "<tr>";
                 echo   "<td>". $row['product_name']."</td>";
                   echo "<td>".$row['quantity']."</td>";
                    echo "<td>Rs.".$row['unit_price']."</td>";
                    echo "<td>Rs.".$row['total']."</td>";
               echo  "</tr>";
                }
            }
            ?>
                <!-- Add more product rows as needed -->
            </tbody>
        </table>
        <?php
            include("../dbconfig.php");
            $bill2=$_GET['bill'];
            $sql="SELECT sub_total,cgst,cgst_amount,sgst,sgst_amount,discount,grand_total FROM sales1 WHERE bill_no='$bill2'";
            $res=mysqli_query($conn,$sql);
            if(mysqli_num_rows($res)>0){
                while($row=mysqli_fetch_assoc($res)){
            ?>

        <table class="table summary-table">
            <tr>
                <td class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">Rs.<?php echo $row['sub_total'];?></td>
            </tr>
            <tr>
                <td class="text-right"><strong>CGST (<?php echo $row['cgst'];?>%):</strong></td>
                <td class="text-right">Rs.<?php echo $row['cgst_amount'];?></td>
            </tr>
            <tr>
                <td class="text-right"><strong>SGST (<?php echo $row['sgst'];?>%):</strong></td>
                <td class="text-right">Rs.<?php echo $row['sgst_amount'];?></td>
            </tr>
            <tr>
                <td class="text-right"><strong>Discount:</strong></td>
                <td class="text-right">Rs.<?php echo $row['discount'];?></td>
            </tr>
            <tr>
                <td class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right">Rs.<?php echo $row['grand_total'];?></td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
        <?php
        include('../dbconfig.php');
        include('word.php');
        $bill3=$_GET['bill'];
        $sql="SELECT grand_total FROM sales1 WHERE bill_no='$bill3'";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_assoc($res)){
                $obj=new IndianCurrency($row['grand_total']);
                $words=$obj->get_words();
                ?>
           

        <p><strong>Amount in Words:</strong><?php echo $words;?> </p>
        <?php
            }
        }
        ?>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Signature:</strong> __________________________</p>
            </div>
        </div>
    </div>
</body>
</html>
