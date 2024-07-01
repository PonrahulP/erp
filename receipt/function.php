<?php
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
    $billno=mysqli_real_escape_string($conn,$input['billno']);
    $date=mysqli_real_escape_string($conn,$input['date']);
    $type=mysqli_real_escape_string($conn,$input['type']);
    $amnt=mysqli_real_escape_string($conn,$input['amnt']);
    $receive=mysqli_real_escape_string($conn,$input['receive']);
    $pend=mysqli_real_escape_string($conn,$input['pend']);
    if(empty(trim($billno))){
        return error422('Enter Your Bill No');
    }elseif(empty(trim($date))){
        return error422('Enter date');
    }elseif(empty(trim($type))){
        return error422('Enter Payment Type');
    }
    elseif(empty(trim($amnt))){
        return error422('Enter Total Amount');
    } elseif(empty(trim($receive))){
        return error422('Enter Received Amount');
    }else{
        $sql="INSERT INTO receipt(bill_no,total_amount,amount,pending_amount,date,payment_type) VALUES('$billno','$amnt','$receive','$pend','$date','$type');UPDATE balance SET amount=amount+'$receive' WHERE payment_type='$type'";
        $result=mysqli_multi_query($conn,$sql);
        if($sql){
           
        }else{
            $data=[
                'status'=>209,
                'message'=>"Failed"
            ];
            header("HTTP/1.0 209 Failed");
            echo json_encode($data);
        }
    }
}
function getreceipt($customerParams){
    global $conn;
    if($customerParams['id'] == null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $query="SELECT * FROM receipt WHERE id='$customerid' LIMIT 1";
    $result=mysqli_query($conn,$query);
    if($result){
        if(mysqli_num_rows($result)==1){
            $res=mysqli_fetch_assoc($result);
            $data=[
                'status'=>201,
                'message'=>"EXPENSES FOUND",
                'data'=> $res,
            ];
            header("HTTP/1.0 201 EXPENSES FOUND");
            return json_encode($data);

        }else{
            $data=[
                'status'=>405,
                'message'=>"EXPENSES NOT FOUND",
            ];
            header("HTTP/1.0 405 EXPENSES NOT FOUND");
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
function getreceiptlist(){
    global $conn;
    $query="SELECT * FROM receipt";
    $result=mysqli_query($conn,$query);
    if($result){
        if(mysqli_num_rows($result)>0){
            $res=mysqli_fetch_all($result,MYSQLI_ASSOC);
            $data=[
                'status'=>201,
                'message'=>"EXPENSES FOUND",
                'data'=>$res,
            ];
            header("HTTP/1.0 201 EXPENSES FOUND");
            return json_encode($data);
        }else{
            $data=[
                'status'=>201,
                'message'=>"EXPENSES NOT FOUND",
            ];
            header("HTTP/1.0 201 EXPENSES NOT FOUND");
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
function deletereceipt($customerParams){
    global $conn;
    if(!isset($customerParams)){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $amnt=mysqli_real_escape_string($conn,$customerParams['amnt']);
    $type=mysqli_real_escape_string($conn,$customerParams['type']);
    $query="DELETE FROM receipt WHERE id='$customerid';UPDATE balance SET amount=amount-'$amnt' WHERE payment_type='$type'";
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
function updatereceipt($customerInput,$customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $bill=mysqli_real_escape_string($conn,$customerInput['bill']);
    $date=mysqli_real_escape_string($conn,$customerInput['date']);
    $amnt=mysqli_real_escape_string($conn,$customerInput['amnt']);
    $paid=mysqli_real_escape_string($conn,$customerInput['receive']);
    $paid1=mysqli_real_escape_string($conn,$customerInput['receive1']);
    $paidf=$paid-$paid1;
    $pend=mysqli_real_escape_string($conn,$customerInput['pend']);
    $type=mysqli_real_escape_string($conn,$customerInput['type']);
    if(empty(trim($bill))){
        return error422('Enter Bill No');
    }elseif(empty(trim($date))){
        return error422('Enter Date');
    }elseif(empty(trim($amnt))){
        return error422('Enter Amount');
    }
    elseif(empty(trim($type))){
        return error422('Enter Payment Type');
    }else{
        $query="UPDATE receipt SET bill_no='$bill',date='$date',total_amount='$amnt',amount='$paid',pending_amount='$pend',payment_type='$type' WHERE id='$customerid';UPDATE balance SET amount=amount+'$paidf' WHERE payment_type='$type'";
        $result=mysqli_multi_query($conn,$query);
        if($result){
         
            $data=[
                'status'=>500,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
?>