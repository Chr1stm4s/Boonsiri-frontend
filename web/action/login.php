<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    // if ($_POST['id'] && $_POST['fname'] && $_POST['lname'] && $_POST['whsCode'] && $_POST['phone']) {
    if ($_POST['id'] && $_POST['fname'] && $_POST['lname'] && $_POST['phone']) {
        $_SESSION['id'] = $_POST['id'];
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['lname'] = $_POST['lname'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['line'] = $_POST['line'];

        $DataAPI = [
            "customerId"=> $_POST['id'], 
            "id"=> $_POST['address_id']
        ];

        $API = connect_api("https://ecmapi.boonsiri.co.th/api/v1/address/set-address-profile", $DataAPI);

        if ($API['responseCode'] == 000) {
            // $_SESSION['address_id'] = $_POST['address_id'];
            $_SESSION['name'] = $_POST['fname'] . " " . $_POST['lname'];
            $_SESSION['address'] = $_POST['addressMain'] . " " . $_POST['addressSub'] . " " . $_POST['district'] . " " . $_POST['amphur'];
            $_SESSION['province'] = $_POST['province'];
            $_SESSION['postcode'] = $_POST['postcode'];
            $_SESSION['whsCode'] = $API['whsCode'];
        }

        echo "success";
    } else {
        echo "\nid: " . $_POST['id'];
        echo "\nfname: " . $_POST['fname'];
        echo "\nlname: " . $_POST['lname'];
        echo "\nemail: " . $_POST['email'];
        echo "\nphone: " . $_POST['phone'];
        echo "\nline: " . $_POST['line'];
        echo "\naddress_id: " . $_POST['address_id'];
        echo "\nname: " . $_POST['fname'] . " " . $_POST['lname'];
        echo "\naddress: " . $_POST['addressMain'] . " " . $_POST['addressSub'] . " " . $_POST['district'] . " " . $_POST['amphur'];
        echo "\nprovince: " . $_POST['province'];
        echo "\npostcode: " . $_POST['postcode'];
        echo "\nwhsCode: " . $_POST['whsCode'];
    }