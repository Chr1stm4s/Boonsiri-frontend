<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    $requestData = [
        "cartId" => $_POST['cartId'],
        "customerId" => $_SESSION['id'], 
        "productId" => $_POST['productId'],
        "amount" => $_POST['amount'],
    ];

    $data = connect_api("{$API_URL}cart/edit-cart-amount", $requestData);

    echo json_encode($data);

    exit;
?>