<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    // Request body
    $data = [
        'customerId' => $_SESSION['id'], 
        'productId' => $_POST['id'], 
        'amount' => $_POST['amount'], 
        'whsCode' => $_SESSION['whsCode']
    ];

    $APIResponse = connect_api("{$API_Link}api/v1/cart/insert-or-update-cart", $data);

    echo $APIResponse['responseDesc'];
?>