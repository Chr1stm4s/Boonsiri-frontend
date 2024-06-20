<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    if ($_SESSION['id']) {
        $purchaseId = $_POST['id'];

        $requestData = [
            "id" => $purchaseId,
            "status" => 1, 
        ];

        $data = connect_api("{$API_URL}purchase/internal-update-purchase-status", $requestData);

        if ($data['responseCode'] === "000") {
            echo "success";
        } else {
            echo "create";

            var_dump($requestData);
            var_dump($data);
        }
    } else {
        echo "login";
    }
?>