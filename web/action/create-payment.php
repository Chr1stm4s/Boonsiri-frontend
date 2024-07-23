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
            $MessageRequest = [
                "message" => "มีคำสั่งซื้อจากสาขา {$_SESSION['whsCode']}"
            ];

            $MessageData = connect_api("{$API_URL}boonsiri/universal-line-notify", $MessageRequest);

            if ($MessageData['responseCode'] === "000") {
                echo "success";
            } else {
                echo json_encode($MessageData);
            }
        } else {
            echo json_encode($data);
        }
    } else {
        echo "login";
    }
?>