<?php
session_start();
require("../dbconfig.php");
function error422($message){
    $data=[
        'status'=>422,
        'message'=>$message,
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}


function storedata($input) {
    global $conn;

    // Sanitize input
    $customer = mysqli_real_escape_string($conn, $input['customer']);
    $bill = mysqli_real_escape_string($conn, $input['bill']);
    $invoice = mysqli_real_escape_string($conn, $input['invoice']);
    $date = mysqli_real_escape_string($conn, $input['date']);
    $sub = mysqli_real_escape_string($conn, $input['sub']);
    $cgst = mysqli_real_escape_string($conn, $input['cgst']);
    $cgstamnt = mysqli_real_escape_string($conn, $input['cgstamnt']);
    $sgst = mysqli_real_escape_string($conn, $input['sgst']);
    $sgstamnt = mysqli_real_escape_string($conn, $input['sgstamnt']);
    $discount = mysqli_real_escape_string($conn, $input['discount']);
    $type = mysqli_real_escape_string($conn, $input['type']);
    $grand = mysqli_real_escape_string($conn, $input['grand']);

    // Insert into sales1 table
    $query = "INSERT INTO sales1 (customer_id, bill_no, invoice_no, sales_date,sub_total,cgst,cgst_amount,sgst,sgst_amount,discount, grand_total,sales_type) 
              VALUES ('$customer', '$bill', '$invoice', '$date','$sub','$cgst','$cgstamnt','$sgst','$sgstamnt','$discount','$grand','$type')";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $_SESSION['message'] = "Failed to submit form!";
        header("Location: index.php");
        exit();
    }

    // Arrays for products data
    $code = $input['product'];
    $name = $input['product_name'];
    $qty = $input['quantity'];
    $uprice = $input['unit_price'];
    $total = $input['total'];
   
    $lowStockProducts = [];

    foreach($code as $index => $codes) {
        // Sanitize each input
        $names = mysqli_real_escape_string($conn, $name[$index]);
        $qtys = mysqli_real_escape_string($conn, $qty[$index]);
        $uprices = mysqli_real_escape_string($conn, $uprice[$index]);
        $totals = mysqli_real_escape_string($conn, $total[$index]);

        // Check stock quantity
        $query = "SELECT quantity FROM products WHERE product_code = '$codes'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $stock_quantity = $row['quantity'];
            $new_stock_quantity = $stock_quantity - $qtys;

            if ($new_stock_quantity < 30) {
                $lowStockProducts[] = $codes;
            }

            // Update product quantity
            $sql1 = "UPDATE products SET quantity = $new_stock_quantity WHERE product_code = '$codes'";
            mysqli_query($conn, $sql1);
        }

        // Insert into sales2 table
        $sql = "INSERT INTO sales2 (bill_no, product_code, product_name, quantity, unit_price,total, sales_type) 
                VALUES ('$bill', '$codes', '$names', '$qtys', '$uprices', '$totals',  '$type')";
        mysqli_query($conn, $sql);
    }

    $_SESSION['message'] = "Form submitted successfully! <a href='demo.php?bill=$bill&customer=$customer' target='_BLANK'>Click here to print</a>";
    
    // Handle low stock products
    if (!empty($lowStockProducts)) {
        $_SESSION['low_stock_products'] = $lowStockProducts;
    } else {
        unset($_SESSION['low_stock_products']);
    }
    
    header("Location: index.php");
    exit();
}

    function getstock($customerParams){
        global $conn;
        if($customerParams['id'] == null){
            return error422('Enter Your id');
        }
        $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
        $query="SELECT * FROM sales1 WHERE id='$customerid' LIMIT 1";
        $result=mysqli_query($conn,$query);
        if($result){
            if(mysqli_num_rows($result)==1){
                $res=mysqli_fetch_assoc($result);
                $data=[
                    'status'=>201,
                    'message'=>"STOCK FOUND",
                    'data'=> $res,
                ];
                header("HTTP/1.0 201 STOCK FOUND");
                // header("Location:table.php");
                return json_encode($data);
    
            }else{
                $data=[
                    'status'=>405,
                    'message'=>"STOCK NOT FOUND",
                ];
                header("HTTP/1.0 405 STOCK NOT FOUND");
                return json_encode($data);
            }
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
    function getstocklist(){
        global $conn;
        $query="SELECT sales1.id,sales1.bill_no,sales1.customer_id,sales1.invoice_no,sales1.sales_date,sales1.sub_total,sales1.cgst,sales1.cgst_amount
        ,sales1.sgst,sales1.sgst_amount,sales1.discount,sales1.grand_total,sales1.sales_type,sales2.product_code,sales2.product_name,sales2.quantity,sales2.unit_price,sales2.total FROM sales1 INNER JOIN sales2 ON sales1.bill_no=sales2.bill_no";
        $result=mysqli_query($conn,$query);
        if($result){
            if(mysqli_num_rows($result)>0){
                $res=mysqli_fetch_all($result,MYSQLI_ASSOC);
                $data=[
                    'status'=>201,
                    'message'=>"STOCK FOUND",
                    'data'=>$res,
                ];
                header("HTTP/1.0 201 STOCK FOUND");
                return json_encode($data);
            }else{
                $data=[
                    'status'=>201,
                    'message'=>"STOCK NOT FOUND",
                ];
                header("HTTP/1.0 201 STOCK NOT FOUND");
                return json_encode($data);
            }
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
    function deletestock($customerParams){
        global $conn;
        if(!isset($customerParams)){
            return error422('Customer id is not found');
        }elseif($customerParams==null){
            return error422('Enter Your id');
        }
        $customerid=mysqli_real_escape_string($conn,$customerParams['bill']);
        $qty=mysqli_real_escape_string($conn,$customerParams['qty']);
        $code=mysqli_real_escape_string($conn,$customerParams['code']);
        $query="DELETE sales1, sales2
        FROM sales1
        INNER JOIN sales2 ON sales1.bill_no = sales2.bill_no
        WHERE sales1.bill_no = '$customerid';
        UPDATE products SET quantity=quantity+'$qty' WHERE product_code='$code'";
        $result=mysqli_multi_query($conn,$query);
        if($result){
           
        }else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
    function updatedata($customerInput,$customerParams){
        global $conn;
        if(!isset($customerParams['bill'])){
            return error422('Customer id is not found');
        }elseif($customerParams==null){
            return error422('Enter your id');
        }
        $customerid=mysqli_real_escape_string($conn,$customerParams['bill']);
        $customer=mysqli_real_escape_string($conn,$customerInput['customer_id']);
        // $bill=mysqli_real_escape_string($conn,$input['bill_no']);
        $invoice=mysqli_real_escape_string($conn,$input['invoice_no']);
        $date=mysqli_real_escape_string($conn,$customerInput['sales_date']);
        $type=mysqli_real_escape_string($conn,$customerInput['type']);
        $sub=mysqli_real_escape_string($conn,$customerInput['sub_total']);
        $cgst=mysqli_real_escape_string($conn,$customerInput['cgst']);
        $cgsta=mysqli_real_escape_string($conn,$customerInput['cgst_amount']);
        $sgst=mysqli_real_escape_string($conn,$customerInput['sgst']);
        $sgsta=mysqli_real_escape_string($conn,$customerInput['sgsta']);
        $dis=mysqli_real_escape_string($conn,$customerInput['dis']);
        $grand=mysqli_real_escape_string($conn,$customerInput['grand_total']);
        $query="UPDATE sales1 SET customer_id='$customer',invoice_no='$invoice',sales_date='$date',sub_total='$sub',cgst='$cgst',cgst_amount='$cgsta',sgst='$sgst',sgst_amount='$sgsta',discount='$dis',grand_total='$grand',sales_type='$type' WHERE bill_no='$customerid'";
            $result=mysqli_multi_query($conn,$query);
        
            $product_codes = $customerInput['product_code'];
            $product_names = $customerInput['product_name'];
            $quantities = $customerInput['quantity'];
            $quantities1 = $customerInput['quantity1'];
            $unit_prices = $customerInput['unit_price'];
            $totals = $customerInput['total'];
    

            $bills=$customerParams['bill'];
            // $types=$customerInput['type'];
            for ($i = 0; $i < count($product_codes); $i++) {
                $product=mysqli_real_escape_string($conn,$product_codes[$i]);
                $name=mysqli_real_escape_string($conn,$product_names[$i]);
                $qty=mysqli_real_escape_string($conn,$quantities[$i]);
                $qty1=mysqli_real_escape_string($conn,$quantities1[$i]);
                $qtyf=$qty-$qty1;
                $uprice=mysqli_real_escape_string($conn, $unit_prices[$i]);
                $total=mysqli_real_escape_string($conn, $totals [$i]);
                $bill=mysqli_real_escape_string($conn, $bills [$i]);
                // $type=mysqli_real_escape_string($conn, $types [$i]);
                
               
                $query="UPDATE sales2 SET product_code='$product',product_name='$name',quantity='$qty',unit_price='$uprice',total='$total',sales_type='$type' WHERE bill_no='$bill'";
                $result=mysqli_query($conn,$query);
                $sql="UPDATE products SET quantity=quantity-'$qtyf' WHERE product_code='$product'";
                $res=mysqli_query($conn,$sql);
                    }
                   
            if($result){
               
            }else{
                $data=[
                    'status'=>500,
                    'message'=>"Internal Server Error",
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }
        }
    ?>