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
    // $category=mysqli_real_escape_string($conn,$input['category']);
    $name=mysqli_real_escape_string($conn,$input['name']);
    $code=mysqli_real_escape_string($conn,$input['code']);
    $description=mysqli_real_escape_string($conn,$input['desc']);
    $qty=mysqli_real_escape_string($conn,$input['qty']);
    $uprice=mysqli_real_escape_string($conn,$input['uprice']);
    $image=mysqli_real_escape_string($conn,$_FILES['image']['name']);
   if(empty(trim($name))){
        return error422('Enter Your Product Name');
    }elseif(empty(trim($code))){
        return error422('Enter Your Product Code');
    }elseif(empty(trim($description))){
        return error422('Enter Your Product Description');
    }elseif(empty(trim($qty))){
        return error422('Enter Your Qunatity');
    }elseif(empty(trim($uprice))){
        return error422('Enter Your Unit Price');
    }else{
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
        $query="INSERT INTO products(product_name,product_code,description,unit_price,quantity,image	)
         VALUES('$name','$code','$description','$uprice','$qty','$image')";
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
    if($customerParams['id'] == null){
        return error422('Enter Your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    $query="SELECT * FROM products WHERE id='$customerid' LIMIT 1";
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
    $query="SELECT * FROM products";
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
    $query="DELETE FROM products WHERE id='$customerid' LIMIT 1";
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
function updatedata($customerInput,$customerParams){
    global $conn;
    if(!isset($customerParams['id'])){
        return error422('Customer id is not found');
    }elseif($customerParams==null){
        return error422('Enter your id');
    }
    $customerid=mysqli_real_escape_string($conn,$customerParams['id']);
    // $category=mysqli_real_escape_string($conn,$customerInput['category']);
    $name=mysqli_real_escape_string($conn,$customerInput['name']);
    $code=mysqli_real_escape_string($conn,$customerInput['code']);
    $description=mysqli_real_escape_string($conn,$customerInput['desc']);
    $qty=mysqli_real_escape_string($conn,$customerInput['qty']);
    $uprice=mysqli_real_escape_string($conn,$customerInput['uprice']);
    $cimage=mysqli_real_escape_string($conn,$customerInput['cimage']);
    $uimage=mysqli_real_escape_string($conn,$customerInput['uimage']);
    if($uimage !=''){
        $updated_filename=$uimage;
        if(file_exists("../images/".$_FILES['uimage']['name'])){
            $data=[
                'status'=>701,
                'message'=>"File Already Exists",
            ];
            header("HTTP/1.0 701 File Already Exists");
            echo json_encode($data);
        }
    }else{
        $updated_filename=$cimage;
    }
    // echo $cimage;
    if(empty(trim($name))){
        return error422('Enter Your Product Name');
    }elseif(empty(trim($code))){
        return error422('Enter Your Product Code');
    }elseif(empty(trim($description))){
        return error422('Enter Your Product Description');
    }elseif(empty(trim($qty))){
        return error422('Enter Your Qunatity');
    }elseif(empty(trim($uprice))){
        return error422('Enter Your Unit Price');
    }else{
        $query="UPDATE products SET product_name='$name',product_code='$code',description='$description',unit_price='$uprice',quantity='$qty',image='$updated_filename' WHERE id='$customerid' LIMIT 1";
        $result=mysqli_query($conn,$query);
        // echo $query;
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