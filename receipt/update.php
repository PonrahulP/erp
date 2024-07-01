<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:POST');
header('Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers,Authorization,X-Request-With');
include ('function.php');
$requestmethod=$_SERVER["REQUEST_METHOD"];
if($requestmethod=="POST"){
    $inputdata=json_decode(file_get_contents("php://input"),true);
    if(empty($inputdata)){
        $updatereceipt=updatereceipt($_POST,$_GET);
    }
    else{
        $updatereceipt=updatereceipt($inputdata);
    }
    header("Location:table.php");
    echo $updatereceipt;
}
else{
    $data=[
        'status'=>404,
        'message'=>$requestmethod ."Method Not Allowed",
    ];
    header("HTTP/1.0 404 Method Not Allowed");
    echo json_encode($data);
}
?>