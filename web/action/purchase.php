<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');

    $shippingType = $_POST['shipping_type'];
    
    if ($shippingType) {
        $DataCart = [
            'customerId' => $_SESSION['id'], 
            'whsCode' => $_SESSION['whsCode']
        ];
    
        $APIResponse = connect_api("$API_Link/v1/cart/list-cart", $DataCart);
    
        $CartList = $APIResponse['cartModels'];
    
        $listOfItems = array();
    
        if ($APIResponse['responseCode'] == 000) {
            
            foreach ($CartList as $cart) {
                $item = array(
                    'productId' => $cart['productId'],
                    'amount' => $cart['amount']
                );
    
                array_push($listOfItems, $item);
            }
    
            $DataPurchase = [
                'customerId' => $_SESSION['id'], 
                'shippingType' => $shippingType, 
                'listOfItems' => $listOfItems
            ];
        
            $APIResponse = connect_api("$API_Link/v1/purchase/insert-purchase", $DataPurchase);
        
            if ($APIResponse['responseCode'] == 000) {
                $_SESSION['purchase_id'] = $APIResponse['purchase']['id'];
    
                echo json_encode($APIResponse);
            } else {
                echo json_encode($APIResponse);
            }
        } else {
            echo json_encode($APIResponse);
        }
    } else {
        echo json_encode([
            "shippingType" => $shippingType,
        ]);
    }
?>