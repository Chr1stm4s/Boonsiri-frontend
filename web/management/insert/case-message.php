<?php
    require_once "../../functions.php";

    header('Access-Control-Allow-Origin: *');

    $caseId = $_POST['caseId'];
    $message = $_POST['message'];
    $status = $_POST['status'];

    $requestData = [
        "caseId" => $caseId,
        "customerId" => 0, 
        "userId" => $_SESSION['admin_id'], 
        "message" => $message, 
        "status" => $status
    ];

    $data = connect_api("{$API_URL}case-message/insert-case-message", $requestData);

    if ($data['responseCode'] === "000") {
        if (@$_FILES['claim']['tmp_name'][0]) {
            $messageId = $data['casesMessage']['id'];

            foreach($_FILES["claim"]["tmp_name"] as $key=>$tmp_name) {
                $file_name=$_FILES["claim"]["name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                
                $message_file = "message-$messageId-$key.$ext";

                $requestData = [
                    "messageId" => $messageId,
                    "file" => $message_file,
                ];
            
                $data = connect_api("{$API_URL}case-file/insert-case-file", $requestData);
                    
                if ($data['responseCode'] !== "000") {
                    var_dump($requestData);
                    var_dump($data);

                    exit();
                } else {
                    if (!file_exists("../../cases/$caseId")) {
                        mkdir("../../cases/$caseId", 0777, true);
                    }
                
                    $upload = move_uploaded_file($_FILES['claim']['tmp_name'][$key], "../../cases/$caseId/$message_file");

                    if (!$upload) {
                        echo "upload\n";

                        echo $upload;

                        exit();
                    }
                }
            }
        }

        if ($status == 3) {
            $requestData = [
                "id" => $_POST['purchaseId'],
                "status" => 9,
            ];
        
            $data = connect_api("{$API_URL}purchase/internal-update-purchase-status", $requestData);

            if ($data['responseCode'] !== "000") {
                var_dump($requestData);
                var_dump($data);

                exit();
            }
        }

        echo "success";
    } else {
        var_dump($requestData);
        var_dump($data);
    }