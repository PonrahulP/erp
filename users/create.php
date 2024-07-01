<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type,Access-Control-Allow-Headers,Authorization,X-Request-With');
include ('function.php');
$requestmethod=$_SERVER['REQUEST_METHOD'];
if($requestmethod=='POST'){
    $inputdata=json_decode(file_get_contents("php://input"),true);
    if(empty($inputdata)){
        $storedata=storedata($_POST);
    }else{
        $storedata=storedata($inputdata);
    }
    header("Location:../login/index.php");
    echo $storedata;
   
}else{
    $data=[
        'status'=>404,
        'message'=>$requestmethod."Method Not Allowed",
    ];
    header("HTTP/1.0 404 Method Not Allowed");
    echo json_encode($data);
}
?>