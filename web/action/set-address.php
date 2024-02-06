<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    if ($_POST['address_id']) {
        $_SESSION['address_id'] = $_POST['address_id'];

        $APIRequest = [
            'customerId' => $_SESSION['id'], 
            'id' => $_POST['address_id']
        ];

        $Result = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/address/set-address-profile", $APIRequest);

        if ($Result['responseCode'] == 000) {
            $_SESSION['address_id'] = $Result['addressProfileId'];
            $_SESSION['name'] = $Result['addressProfileFname'] . " " . $Result['addressProfileLname'];
            $_SESSION['address'] = $Result['addressMain'] . " " . $Result['addressSub'] . " " . $Result['districtName'] . " " . $Result['amphurName'];
            $_SESSION['province'] = $Result['provinceName'];
            $_SESSION['postcode'] = $Result['postcode'];
            $_SESSION['whsCode'] = $Result['whsCode'];

            echo "success";
        } else {
            var_dump($Result);
        }
    }
?>