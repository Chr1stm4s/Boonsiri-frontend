<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    // Request body
    $data = [
        'customerId' => $_SESSION['id'], 
        'productId' => $_POST['id'], 
        'amount' => $_POST['amount'], 
        'addressProfilesId' => $_SESSION['address_id']
    ];

    $APIResponse = connect_api("{$API_URL}preorder/insert-preorder", $data);

    echo $APIResponse['responseDesc'];
?>