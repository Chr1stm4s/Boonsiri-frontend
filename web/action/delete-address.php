<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    $data = [
        'id' => $_POST['id']
    ];

    $APIResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/address/delete-address-profile", $data);

    if ($APIResponse['responseCode'] === "000") {
        $_SESSION['address_id'] = null;
        $_SESSION['name'] = null;
        $_SESSION['address'] = null;
        $_SESSION['province'] = null;
        $_SESSION['postcode'] = null;
        $_SESSION['whsCode'] = null;

        echo "success";
    } else {
        var_dump($APIResponse);
    }
?>