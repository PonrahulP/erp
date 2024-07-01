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
function storedata($input){
    global $conn;
    $uname=mysqli_real_escape_string($conn,$input['uname']);
    // $_SESSION['uname']=$uname;
    $password=mysqli_real_escape_string($conn,$input['pwd']);
    $pass=password_hash($password,PASSWORD_DEFAULT);
    $email=mysqli_real_escape_string($conn,$input['mail']);
    $contact=mysqli_real_escape_string($conn,$input['contact']);
    $role=mysqli_real_escape_string($conn,$input['role']);
    $bank=mysqli_real_escape_string($conn,$input['bank']);
    $cash=mysqli_real_escape_string($conn,$input['cash']);
    $image=mysqli_real_escape_string($conn,$_FILES['logo']['name']);
    if(empty(trim($uname))){
        return error422('Enter Your Username');
    }elseif(empty(trim($password))){
        return error422('Enter Your Password');
    }elseif(empty(trim($email))){
        return error422('Enter Your Email Id');
    }elseif(empty(trim($contact))){
        return error422('Enter Your Contact');
    }elseif(empty(trim($role))){
        return error422('Enter Your Role');
    }elseif(empty(trim($bank))){
        return error422('Enter Your Opening Bank Balance');
    }elseif(empty(trim($cash))){
        return error422('Enter Your Opening Cash Balance');
    }else{
        $filename=$_FILES['logo']['name'];
        $temp_name=$_FILES['logo']['tmp_name'];
        $filesize=$_FILES['logo']['size'];
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
                        // echo json_encode($data);
                    }
                }else{
                    $data=[
                        'status'=>505,
                        'message'=>"File Already Exists",
                    ];
                    header("HTTP/1.0 505 File Already Exists");
                    // echo json_encode($data);
                }
            }else{
                $data=[
                    'status'=>500,
                    'message'=>"Other Files Not Allowed",
                ];
                header("HTTP/1.0 500 Other Files Not Allowed");
                // echo json_encode($data);
            }
        }
        $query="INSERT INTO users(username,password,email,contact,role,logo,opening_bank_balance,opening_cash_balance) VALUES('$uname','$pass','$email','$contact','$role','$image','$bank','$cash')";
        $result=mysqli_query($conn,$query);
        if($result){
            echo "<script>alert('Registration successful!');</script>";
        echo "<script>window.location.href='../login/index.php';</script>";
        }else{
            $data=[
                'status'=>305,
                'alert'=>"Internal Server Error",
            ];
            header("HTTP/1.0 305 Internal Server Error");
            echo json_encode($data);
        }
    }
}
?>