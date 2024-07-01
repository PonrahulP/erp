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
    $supplier=mysqli_real_escape_string($conn,$input['id']);
    $name=mysqli_real_escape_string($conn,$input['name']);
    $contact=mysqli_real_escape_string($conn,$input['contact']);
    $address=mysqli_real_escape_string($conn,$input['address']);
    $email=mysqli_real_escape_string($conn,$input['email']);
    if(empty(trim($supplier))){
        return error422('Enter Your Customer Id');
    }elseif(empty(trim($name))){
        return error422('Enter Your Customer Name');
    }elseif(empty(trim($contact))){
        return error422('Enter Your Contact');
    }elseif(empty(trim($address))){
        return error422('Enter Your Address');
    }elseif(empty(trim($email))){
        return error422('Enter Your Email');
    }else{
        $query="INSERT INTO customers(customer_id,name,contact,address,email) VALUES('$supplier','$name','$contact','$address','$email')";
        $result=mysqli_query($conn,$query);
        if($result){
           
        }else{
            $data=[
                'status'=>305,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 305 Internal Server Error");
            echo json_encode($data);
        }
    }
}
    function getstock($customerParams){
        global $conn;
        if($customerParams['customer_id'] == null){
            return error422('Enter Your id');
        }
        $customerid=mysqli_real_escape_string($conn,$customerParams['customer_id']);
        $query="SELECT * FROM customers WHERE customer_id='$customerid' LIMIT 1";
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
        $query="SELECT * FROM customers";
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
        $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
        $query="DELETE FROM customers WHERE id='$customerid'";
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
        if(!isset($customerParams['id'])){
            return error422('Customer id is not found');
        }elseif($customerParams==null){
            return error422('Enter your id');
        }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $id=mysqli_real_escape_string($conn,$customerInput['id']);
    $name=mysqli_real_escape_string($conn,$customerInput['name']);
    $contact=mysqli_real_escape_string($conn,$customerInput['contact']);
    $address=mysqli_real_escape_string($conn,$customerInput['address']);
    $email=mysqli_real_escape_string($conn,$customerInput['email']);
    if(empty(trim($id))){
        return error422('Enter Your Customer Id');
    }elseif(empty(trim($name))){
        return error422('Enter Your Name');
    }elseif(empty(trim($contact))){
        return error422('Enter Your Contact');
    }elseif(empty(trim($address))){
        return error422('Enter Your Address');
    }elseif(empty(trim($email))){
        return error422('Enter Your Email');
    }else{
        $query="UPDATE customers SET customer_id='$id', name='$name',contact='$contact',address='$address',email='$email' WHERE id='$customerid' LIMIT 1";
        $result=mysqli_query($conn,$query);
        if($result){
            
        }else{
            $data=[
                'status'=>305,
                'message'=>"Internal Server Error",
            ];
            header("HTTP/1.0 305 Internal Server Error");
            echo json_encode($data);
        }
    }
}
?>