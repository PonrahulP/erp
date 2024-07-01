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
function storeexpenses($input){
    global $conn;
    $type=mysqli_real_escape_string($conn,$input['type']);
    $name=mysqli_real_escape_string($conn,$input['name']);
    $date=mysqli_real_escape_string($conn,$input['date']);
    $amnt=mysqli_real_escape_string($conn,$input['amnt']);
    $payment=mysqli_real_escape_string($conn,$input['payment']);
    if(empty(trim($type))){
        return error422('Enter Your Expenses Type');
    }elseif(empty(trim($name))){
        return error422('Enter Your Name');
    }elseif(empty(trim($date))){
        return error422('Enter date');
    }elseif(empty(trim($amnt))){
        return error422('Enter Amount');
    }elseif(empty(trim($payment))){
        return error422('Enter Your Payment Type');
    }else{
        $sql="INSERT INTO expenses(expenses_type,name,date,amount,payment_type) VALUES('$type','$name','$date','$amnt','$payment');UPDATE balance SET amount=amount-'$amnt' WHERE payment_type='$payment'";
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
function getexpenses($customerParams){
    global $conn;
    if($customerParams['id'] == null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $query="SELECT * FROM expenses WHERE id='$customerid' LIMIT 1";
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
function getexpenseslist(){
    global $conn;
    $query="SELECT * FROM expenses";
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
function deleteexpenses($customerParams){
    global $conn;
    if(!isset($customerParams)){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $amnt=mysqli_real_escape_string($conn,$customerParams['amnt']);
    $type=mysqli_real_escape_string($conn,$customerParams['type']);
    $query="DELETE FROM expenses WHERE id='$customerid';UPDATE balance SET amount=amount+'$amnt' WHERE payment_type='$type'";
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
function updateexpenses($customerInput,$customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $type=mysqli_real_escape_string($conn,$customerInput['type']);
    $name=mysqli_real_escape_string($conn,$customerInput['name']);
    $date=mysqli_real_escape_string($conn,$customerInput['date']);
    $amnth=mysqli_real_escape_string($conn,$customerInput['amnth']);
    $amnt=mysqli_real_escape_string($conn,$customerInput['amnt']);
    $amntf=$amnt-$amnth;
    $payment=mysqli_real_escape_string($conn,$customerInput['payment']);
    if(empty(trim($type))){
        return error422('Enter Your Expenses Type');
    }elseif(empty(trim($name))){
        return error422('Enter Your Name');
    }elseif(empty(trim($date))){
        return error422('Enter Date');
    }elseif(empty(trim($amnt))){
        return error422('Enter Amount');
    }elseif(empty(trim($payment))){
        return error422('Enter Payment Type');
    }
    else{
        $query="UPDATE expenses SET expenses_type='$type',name='$name',date='$date',amount='$amnt',payment_type='$payment'WHERE id='$customerid';UPDATE balance SET amount=amount-'$amntf' WHERE payment_type='$payment'";
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
}
?>