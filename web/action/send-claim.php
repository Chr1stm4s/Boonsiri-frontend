<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');

    if ($_FILES['claim']) {
        $customerId = $_SESSION['id'];
        $purchaseId = $_POST['purchaseId'];
        $itemId = $_POST['itemId'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        $requestData = [
            "purchaseId" => $purchaseId,
            "customerId" => $customerId,
            "title" => $title,
            "description" => $description,
            "itemId" => $itemId,
        ];

        $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case/insert-case", $requestData);

        if ($data['responseCode'] === "000") {
            $caseId = $data['case']['id'];

            $requestData = [
                "caseId" => $caseId,
                "customerId" => $customerId,
                "userId" => 0,
                "message" => $description,
            ];
        
            $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case-message/insert-case-message", $requestData);

            if ($data['responseCode'] === "000") {
                $messageId = $data['casesMessage']['id'];

                foreach($_FILES["claim"]["tmp_name"] as $key=>$tmp_name) {
                    $file_name=$_FILES["claim"]["name"][$key];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    
                    $message_file = "message-$messageId-$key.$ext";
        
                    $requestData = [
                        "messageId" => $caseId,
                        "file" => $message_file,
                    ];
                
                    $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case-file/insert-case-file", $requestData);
                        
                    if ($data['responseCode'] !== "000") {
                        var_dump($requestData);
                        var_dump($data);

                        exit();
                    } else {
                        if (!file_exists("../cases/$caseId")) {
                            mkdir("../cases/$caseId", 0777, true);
                        }
                    
                        $upload = move_uploaded_file($_FILES['claim']['tmp_name'][$key], "../cases/$caseId/$message_file");

                        if (!$upload) {
                            echo "upload\n";
    
                            echo $upload;
    
                            exit();
                        }
                    }
                }
        
                $requestData = [
                    "id" => $purchaseId,
                    "status" => 8,
                ];
            
                $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/internal-update-purchase-status", $requestData);

                if ($data['responseCode'] == "000") {
                    echo "success";
                } else {
                    var_dump($requestData);
                    var_dump($data);
                }
            } else {
                var_dump($requestData);
                var_dump($data);
            }
        } else {
            var_dump($requestData);
            var_dump($data);
        }
    } else {
        echo "upload image";
    }