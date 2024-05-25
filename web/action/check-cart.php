<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $requestData = [
        "customerId" => $_SESSION['id'],
        "whsCode" => $_SESSION['whsCode'], 
    ];

    $data = connect_api("$API_Link/v1/cart/list-cart", $requestData);

    echo json_encode($data);

    exit;
?>