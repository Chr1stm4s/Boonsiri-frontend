<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $APIRequest = [
        'id' => $_SESSION['id'], 
        'password' => $_POST['password'], 
    ];

    $Result = connect_api("{$API_URL}customer/update-customer-password", $APIRequest);

    if ($Result['responseCode'] == 000) {
        echo "success";
    } else {
        var_dump($Result);
    }
?>