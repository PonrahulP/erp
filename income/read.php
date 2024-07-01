<?php
header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Method:GET');
header('Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers,Authorization,X-Request-With');
include ('function.php');
$requestmethod=$_SERVER['REQUEST_METHOD'];
if($requestmethod=="GET"){
    if(isset($_GET['id'])){
        $income=getincome($_GET);  //single display
        header("Location:table.php");
        echo $income;
    }
    else{
        $incomelist=getincomelist(); //multiple display api 
        header("Location:table.php");
        echo $incomelist;
        
    }
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