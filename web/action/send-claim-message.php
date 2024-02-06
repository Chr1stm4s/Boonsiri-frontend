<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');

    $caseId = $_POST['caseId'];
    $message = $_POST['message'];

    $requestData = [
        "caseId" => $caseId,
        "customerId" => $_SESSION['id'],
        "userId" => 0,
        "message" => $message,
        "status" => 1
    ];

    $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case-message/insert-case-message", $requestData);

    if ($data['responseCode'] === "000") {
        if ($_FILES["claim"]["tmp_name"][0]) {
            $messageId = $data['casesMessage']['id'];

            foreach($_FILES["claim"]["tmp_name"] as $key=>$tmp_name) {
                $file_name=$_FILES["claim"]["name"][$key];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                
                $message_file = "message-$messageId-$key.$ext";

                $requestData = [
                    "messageId" => $messageId,
                    "file" => $message_file,
                ];
            
                $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case-file/insert-case-file", $requestData);
                    
                if ($data['responseCode'] !== "000") {
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
        }

        echo "success";
    } else {
        var_dump($requestData);
        var_dump($data);
    }