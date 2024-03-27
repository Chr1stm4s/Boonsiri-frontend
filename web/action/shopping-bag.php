<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $HeaderCartDataAPI = [
        'customerId' => $_SESSION['id'],
        'whsCode' => $_SESSION['whsCode']
    ];

    $HeaderCartData = connect_api("https://ecmapi.boonsiri.co.th/api/v1/cart/list-cart", $HeaderCartDataAPI);

    if ($HeaderCartData === null) {
        echo 0;
    } else {
        echo $HeaderCartCount = count($HeaderCartData['cartModels']);
    }
?>