<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    if ($_SESSION['id']) {
        $purchaseId = $_POST['id'];

        $requestData = [
            "id" => $purchaseId,
            "status" => 2, 
        ];

        $data = connect_api("$API_Link/v1/purchase/internal-update-purchase-status", $requestData);

        if ($data['responseCode'] === "000") {
            echo "success";
        } else {
            echo "check";
        }
    } else {
        echo "login";
    }
?>