<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    $customer_id = $_SESSION['id'];
    $name = $_POST['name'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $addressMain = $_POST['address_main'];
    $addressSub = $_POST['address_sub'];
    $line = $_POST['line'];
    $district = $_POST['district'];
    $amphur = $_POST['amphur'];
    $province = $_POST['province'];
    $postcode = $_POST['postcode'];
    $isMain = (isset($_POST['isMain'])) ? 1 : 0;

    $InsertAddressAPIRequest = [
        'customerId' => $_SESSION['id'], 
        'name' => $name, 
        'fname' => $fname, 
        'lname' => $lname, 
        'phone' => $phone, 
        'email' => $email, 
        'line' => $line, 
        'addressMain' => $addressMain, 
        'addressSub' => $addressSub, 
        'province' => $province, 
        'amphur' => $amphur, 
        'district' => $district, 
        'isMain' => $isMain
    ];

    $InsertAddressResponse = connect_api("$API_Link/v1/address/insert-address-profile", $InsertAddressAPIRequest);

    if ($InsertAddressResponse['responseCode'] == 000) {
        if ($isMain == 1) {
            $_SESSION['address_id'] = $InsertAddressResponse['addressProfile']['id'];
            $_SESSION['name'] = $InsertAddressResponse['addressProfile']['fname'] . " " . $InsertAddressResponse['addressProfile']['lname'];
            $_SESSION['address'] = $InsertAddressResponse['addressProfile']['addressMain'] . " " . $InsertAddressResponse['addressProfile']['addressSub'] . " " . $InsertAddressResponse['addressProfile']['districtName'] . " " . $InsertAddressResponse['addressProfile']['amphurName'];
            $_SESSION['province'] = $InsertAddressResponse['addressProfile']['provinceName'];
            $_SESSION['postcode'] = $InsertAddressResponse['addressProfile']['postcode'];
            $_SESSION['whsCode'] = $InsertAddressResponse['addressProfile']['whsCode'];
        }

        echo "success";
    } else {
        echo $InsertAddressResponse['responseCode'];
    }
?>