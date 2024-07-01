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
    $type=mysqli_real_escape_string($conn,$input['type']);
    $amnt=mysqli_real_escape_string($conn,$input['amnt']);
    if(empty(trim($type))){
        return error422('Enter Your Payment_type');
    }elseif(empty(trim($amnt))){
        return error422('Enter Amount');
    }else{
        $sql="INSERT INTO balance(payment_type,amount) VALUES('$type','$amnt')";
        $result=mysqli_query($conn,$sql);
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
function getbank($customerParams){
    global $conn;
    if($customerParams['id'] == null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $query="SELECT * FROM balance WHERE id='$customerid' LIMIT 1";
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
function getbanklist(){
    global $conn;
    $query="SELECT * FROM balance";
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
function deletebank($customerParams){
    global $conn;
    if(!isset($customerParams)){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $query="DELETE FROM balance WHERE id='$customerid'";
    $result=mysqli_query($conn,$query);
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
function updatebank($customerInput,$customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $type=mysqli_real_escape_string($conn,$customerInput['type']);
    $amnt=mysqli_real_escape_string($conn,$customerInput['amnt']);
    if(empty(trim($type))){
        return error422('Enter Your Payment Type');
    }elseif(empty(trim($amnt))){
        return error422('Enter Amount');
    }else{
        $query="UPDATE balance SET payment_type='$type',amount='$amnt' WHERE id='$customerid'";
        $result=mysqli_query($conn,$query);
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