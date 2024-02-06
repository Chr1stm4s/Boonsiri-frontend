<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $purchaseId = $_POST['purchaseId'];
    $message = $_POST['message'];

    $requestData = [
        "purchaseId" => $purchaseId,
        "message" => $message,
    ];

    $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/review/insert-review", $requestData);

    if ($data['responseCode'] === "000") {
        echo "success";

        $review_id = $data['review']['id'];

        $requestData = [
            "id" => $purchaseId,
            "status" => 7,
        ];
    
        $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/internal-update-purchase-status", $requestData);
    } else {
        echo "sending";
    }

    if ($_FILES['review']['name']) {
        foreach($_FILES["review"]["tmp_name"] as $key=>$tmp_name) {
            $file_name=$_FILES["review"]["name"][$key];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            
            $review_image = "review-$review_id-$key.$ext";

            if (!file_exists("../reviews/$review_id")) {
                mkdir("../reviews/$review_id", 0777, true);
            }
        
            $upload = move_uploaded_file($_FILES['review']['tmp_name'][$key], "../reviews/$review_id/$review_image");

            if ($upload) {
                $requestData = [
                    "reviewsId" => $review_id,
                    "image" => $review_image,
                ];
            
                $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/reviews-image/insert-reviews-image", $requestData);
                
                if ($data['responseCode'] !== "000") {
                    exit();
                }
            } else {
                exit();
            }
        }
    }