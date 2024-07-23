<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');

    $MessageRequest = [
        "message" => "*มีคำสั่งซื้อรอแอดมินสรุปยอด*\nจากสาขา {$_SESSION['whsCode']}\nชื่อสินค้า : {$_POST['product']}\nจำนวน : {$_POST['amount']} {$_POST['uom_code']}\nชื่อผู้สั่งซื้อ: {$_SESSION['name']}\nเบอร์ติดต่อ: {$_SESSION['phone']}"
    ];

    $MessageData = connect_api("{$API_URL}boonsiri/universal-line-notify", $MessageRequest);
    
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