<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $data = [
        'customerId' => $_SESSION['id'], 
        'productId' => $_POST['productId'], 
        'amount' => 0, 
    ];

    $APIResponse = connect_api("{$API_Link}api/v1/cart/insert-or-update-cart", $data);

    if ($APIResponse['responseCode'] == 000) {
        echo "success";
    } else {
        var_dump($data);
        var_dump($APIResponse);
    }
?>