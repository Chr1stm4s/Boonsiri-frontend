<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    if ($_SESSION['id']) {
        $purchaseId = $_POST['id'];

        $requestData = [
            "id" => $purchaseId,
        ];

        $data = connect_api("{$API_URL}purchase/get-purchase", $requestData);

        if (in_array($data['purchase']['status'], [3,4,5,6,7])) {
            echo "success";
        } else {
            $requestData = [
                "id" => $purchaseId,
                "status" => 2, 
            ];
    
            $data = connect_api("{$API_URL}purchase/internal-update-purchase-status", $requestData);
    
            if ($data['responseCode'] === "000") {
                echo "success";
            } else {
                echo "check";
            }
        }
    } else {
        echo "login";
    }
?>