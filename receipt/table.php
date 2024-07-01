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
    <title>Payment Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
     crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
     integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
 <?php include("../navbar.php");?>
<?php include("../float.php");?>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <h5><i class="bi bi-journal-richtext"></i> Receipt Details</h5>
                <a href="index.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> New Receipt</a>
            </div>
            <div class="col-md-12 table-responsive mt-3">
                <table id="myTable" class="table table-bordered" style="border-color:black;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Bill No</th>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Received Amount</th>
                            <th>Pending Amount</th>
                            <th>Payment Type</th>
                            <th>Delete</th>
                            <th>Edit</th>
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
     fetch("http://localhost/erp/receipt/read.php").then(
            res => {
                res.json().then(
                    data => {
                        if(data.data.length > 0){
                            var temp ="";
                            data.data.forEach((itemData)=>{
                                temp +="<tr>";
                                temp +="<td>" + itemData.id+"</td>";
                                temp +="<td><a href='../sales/table.php' style='text-decoration:none;'>" + itemData.bill_no+"</a></td>";
                                temp +="<td>" + itemData.date+"</td>";
                                temp +="<td>" + itemData.total_amount+"</td>";
                                temp +="<td>" + itemData.amount+"</td>";
                                temp +="<td>" + itemData.pending_amount+"</td>";
                                temp +="<td>" + itemData.payment_type+"</td>";
                                temp +="<td><i id='delete' class='bi bi-trash-fill' data-id='"+ itemData.id +"'></i></td>";
                                temp +="<td><i id='edit' class='bi bi-pen-fill' data-id='"+ itemData.id +"'></i></td>";
                                temp +="</tr>";
                            });
                            document.getElementById('data').innerHTML= temp;
                        }
                    }
                )
            }
        )
        $(document).on('click','#delete',function(){
                var id=$(this).data('id');
                var rowText=$(this).closest('tr').text().trim();
                var amnt=$(this).closest('tr').find("td:eq(4)").html();
                var type=$(this).closest('tr').find("td:eq(6)").html();
                var confirmation=confirm('Are you delete this item?');
                if(confirmation){
                    var deleteURL="http://localhost/erp/receipt/delete.php?id="+id+'&amnt='+amnt+'&type='+type;
                    $.ajax({
                        url:deleteURL,
                        method:'DELETE',
                        success:function(){
                            alert ("working");
                        }
                    });
                }
            });
            $(document).on('click','#edit', function(){
            var id=$(this).data('id');
            var lastClickedCustomer={
            id: id,
            bill: $(this).closest('tr').find('td:eq(1)').text(),
            // console.log(name);
            date: $(this).closest('tr').find('td:eq(2)').text(),
            amnt: $(this).closest('tr').find('td:eq(3)').text(),
            receive: $(this).closest('tr').find('td:eq(4)').text(),
            pend: $(this).closest('tr').find('td:eq(5)').text(),
            type: $(this).closest('tr').find('td:eq(6)').text(),
        };
        var confirmation=confirm ('Are you edit this data?');
        if(confirmation){
            window.location.href="http://localhost/erp/receipt/form_update.php?id="+ id +
            "&bill=" + encodeURIComponent(lastClickedCustomer.bill)+
            "&date=" + encodeURIComponent(lastClickedCustomer.date)+
            "&amnt=" + encodeURIComponent(lastClickedCustomer.amnt)+
            "&receive=" + encodeURIComponent(lastClickedCustomer.receive)+
            "&pend=" + encodeURIComponent(lastClickedCustomer.pend)+
            "&type=" + encodeURIComponent(lastClickedCustomer.type);
        }
    });
  </script>
</html>