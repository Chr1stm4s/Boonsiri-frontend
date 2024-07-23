<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $purchaseId = $_POST['purchaseId'];
    $quality = $_POST['quality'];
    $services = $_POST['services'];
    $delivery = $_POST['delivery'];
    $message = $_POST['message'];

    $requestData = [
        "purchaseId" => $purchaseId,
        "quality" => $quality,
        "services" => $services,
        "delivery" => $delivery,
        "message" => $message,
    ];

    $data = connect_api("{$API_URL}review/insert-review", $requestData);

    if ($data['responseCode'] === "000") {

        $review_id = $data['review']['id'];

        $requestData = [
            "id" => $purchaseId,
            "status" => 7,
        ];
    
        $data = connect_api("{$API_URL}purchase/internal-update-purchase-status", $requestData);

        if ($data['responseCode'] === "000") {
            if ($_FILES['review']['name'][0]) {
                if (!file_exists("../reviews/$review_id")) {
                    mkdir("../reviews/$review_id", 0777, true);
                }

                foreach($_FILES["review"]["tmp_name"] as $key=>$tmp_name) {
                    $file_name=$_FILES["review"]["name"][$key];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    
                    $review_image = "review-$review_id-$key.$ext";
                
                    $upload = move_uploaded_file($_FILES['review']['tmp_name'][$key], "../reviews/$review_id/$review_image");

                    if ($upload) {
                        $requestData = [
                            "reviewsId" => $review_id,
                            "image" => $review_image,
                        ];
                    
                        $data = connect_api("{$API_URL}reviews-image/insert-reviews-image", $requestData);
                        
                        if ($data['responseCode'] !== "000") {
                            echo "image";
                        }
                    } else {
                        echo "image";
                    }
                }
            }

            if ($_FILES['video']['name']) {
                $file_name=$_FILES["video"]["name"];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                
                $review_video = "review-$review_id-video.$ext";

                if (!file_exists("../reviews/$review_id")) {
                    mkdir("../reviews/$review_id", 0777, true);
                }
            
                $upload = move_uploaded_file($_FILES['video']['tmp_name'], "../reviews/$review_id/$review_video");

                if ($upload) {
                    $requestData = [
                        "reviewsId" => $review_id,
                        "image" => $review_video,
                    ];
                
                    $data = connect_api("{$API_URL}reviews-image/insert-reviews-image", $requestData);
                    
                    if ($data['responseCode'] !== "000") {
                        echo "video";
                    }
                } else {
                    echo "video ";
                }
            }

            echo "success";
        } else {
            echo "updateing";
        }
    } else {
        echo "sending";
    }