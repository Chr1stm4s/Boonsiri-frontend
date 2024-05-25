<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $APIRequest = [
        'id' => $_SESSION['id'], 
        'fname' => $_POST['fname'], 
        'lname' => $_POST['lname'], 
        'email' => $_POST['email'], 
        'line' => $_POST['line'], 
    ];

    $Result = connect_api("$API_Link/v1/customer/update-customer-profile", $APIRequest);

    if ($Result['responseCode'] == 000) {
        $_SESSION['fname'] = $_POST['fname'];
        $_SESSION['lname'] = $_POST['lname'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['line'] = $_POST['line'];

        echo "success";
    } else {
        var_dump($Result);
    }
?>