<?php
// session_start();
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
function storedata($input){
    global $conn;
    $supplier=mysqli_real_escape_string($conn,$input['supplier']);
    $bill=mysqli_real_escape_string($conn,$input['bill']);
    $date=mysqli_real_escape_string($conn,$input['date']);
    $image=mysqli_real_escape_string($conn,$_FILES['image']['name']);
    $filename=$_FILES['image']['name'];
        $temp_name=$_FILES['image']['tmp_name'];
        $filesize=$_FILES['image']['size'];
        if(empty($filename)){
            $data=[
                'status'=>405,
                'message'=>"Please Select Image",
            ];
            header("HTTP/1.0 405 Please Select Image");
            echo json_encode($data);
        }else{
            $filepath="../images/";
            $file_ext=strtolower(pathinfo($filename,PATHINFO_EXTENSION));
            $valid_ext=array('jpeg','jpg','png','gif');
            if(in_array($file_ext,$valid_ext)){
                if(!file_exists($filepath.$filename)){
                    if($filesize<5000000){
                        move_uploaded_file($temp_name,$filepath.$filename);
                    }else{
                        $data=[
                            'status'=>409,
                            'message'=>"File Size Too Large",
                        ];
                        header("HTTP/1.0 409 File Size Too Large");
                        echo json_encode($data);
                    }
                }else{
                    $data=[
                        'status'=>505,
                        'message'=>"File Already Exists",
                    ];
                    header("HTTP/1.0 505 File Already Exists");
                    echo json_encode($data);
                }
            }else{
                $data=[
                    'status'=>500,
                    'message'=>"Other Files Not Allowed",
                ];
                header("HTTP/1.0 500 Other Files Not Allowed");
                echo json_encode($data);
            }
        }
    $query="INSERT INTO purchase1 (supplier_id,bill_no,bill_img,purchase_date	) VALUES ('$supplier','$bill','$image','$date')";
    $result=mysqli_multi_query($conn,$query);
    $product_codes = $input['code'];
    $product_names = $input['product_name'];
    $quantities = $input['quantity'];
    $unit_prices = $input['unit_price'];
    $cgsts = $input['cgst'];
    $sgsts = $input['sgst'];
    $totals = $input['total'];
    // $bills=$input['bill1'];
    // $types=$input['type'];

    for ($i = 0; $i < count($product_codes); $i++) {
    $product=mysqli_real_escape_string($conn,$product_codes[$i]);
    $name=mysqli_real_escape_string($conn,$product_names[$i]);
    $qty=mysqli_real_escape_string($conn,$quantities[$i]);
    $uprice=mysqli_real_escape_string($conn, $unit_prices[$i]);
    $cgst=mysqli_real_escape_string($conn, $cgsts [$i]);
    $sgst=mysqli_real_escape_string($conn, $sgsts[$i]);
    $total=mysqli_real_escape_string($conn, $totals [$i]);
    // $bill=mysqli_real_escape_string($conn, $bills [$i]);
    // $type=mysqli_real_escape_string($conn, $types [$i]);
    
    
            $query1="INSERT INTO purchase2(bill_no,product_code	,product_name,quantity,unit_price,cgst,sgst,total) VALUES('$bill','$product','$name','$qty','$uprice','$cgst','$sgst','$total')";
            $res=mysqli_multi_query($conn,$query1);
            $sql="UPDATE products SET quantity=quantity+'$qty' WHERE product_code='$product'";
            $res=mysqli_query($conn,$sql);
    }
       
         if($res){
            $data=[
                'status'=>200,
                'message'=>"Success",
            ];
            header("HTTP/1.0 200 Internal Server Error");
            return json_encode($data);
        }
        else{
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
    // }
    function getstock($customerParams){
        global $conn;
        if($customerParams['id'] == null){
            return error422('Enter Your id');
        }
        $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
        $query="SELECT * FROM purchase WHERE id='$customerid' LIMIT 1";
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
        $query="SELECT purchase1.id, purchase1.bill_img,purchase1.bill_no,purchase1.supplier_id,purchase2.product_code,purchase2.product_name,purchase2.quantity,purchase2.unit_price,purchase2.cgst,purchase2.sgst,purchase2.total,purchase1.purchase_date
        FROM purchase1
        INNER JOIN purchase2 ON purchase1.bill_no = purchase2.bill_no
        ";
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
        $query="DELETE purchase1, purchase2
        FROM purchase1
        INNER JOIN purchase2 ON purchase1.bill_no = purchase2.bill_no
        WHERE purchase1.bill_no = '$customerid';
        UPDATE products SET quantity=quantity-'$qty' WHERE product_code='$code'";
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
   
    ?>