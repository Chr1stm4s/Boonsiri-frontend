<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');

    if ($_FILES['claim']) {
        $customerId = $_SESSION['id'];
        $purchaseId = $_POST['purchaseId'];
        $orderNo = $_POST['orderNo'];
        $whsCode = $_POST['whsCode'];
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

        $data = connect_api("{$API_URL}case/insert-case", $requestData);

        if ($data['responseCode'] === "000") {
            $caseId = $data['case']['id'];

            $requestData = [
                "caseId" => $caseId,
                "customerId" => $customerId,
                "userId" => 0,
                "message" => $description,
            ];
        
            $data = connect_api("{$API_URL}case-message/insert-case-message", $requestData);

            if ($data['responseCode'] === "000") {
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
                    "status" => 12,
                ];
            
                $data = connect_api("{$API_URL}purchase/internal-update-purchase-status", $requestData);

                if ($data['responseCode'] == "000") {
                    $MessageRequest = [
                        "message" => "มีสินค้าแจ้งเคลมจากสาขา $whsCode\nเลขที่คำสั่งซื้อ $orderNo"
                    ];
        
                    $MessageData = connect_api("{$API_URL}boonsiri/universal-line-notify", $MessageRequest);
        
                    if ($MessageData['responseCode'] === "000") {
                        echo "success";
                    } else {
                        echo json_encode($MessageData);
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
            var_dump($requestData);
            var_dump($data);
        }
    } else {
        echo "upload image";
    }