<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $HeaderCartDataAPI = [
        'customerId' => $_SESSION['id'],
        'whsCode' => $_SESSION['whsCode']
    ];

    $HeaderCartData = connect_api("$API_Link/v1/cart/list-cart", $HeaderCartDataAPI);

    if ($HeaderCartData === null) {
        echo $_SESSION['cart'] = 0;
    } else {
        echo $_SESSION['cart'] = count($HeaderCartData['cartModels']);
    }
?>