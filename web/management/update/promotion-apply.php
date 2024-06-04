<?php
    require_once "../../functions.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['checkboxValues'])) {
            $checkboxValues = $_POST['checkboxValues'];
            $promotionId = $_POST['promotionId'];

            $PromotionAPIURL = "{$API_Link}api/v1/promotion/set-promotion-by-item-code";

            foreach ($checkboxValues as $value) {
                $PromotionAPIDataRequest = [
                    'itemCode' => $value, 
                    'promotionId' => $promotionId, 
                ];

                $PromotionDataAPI = connect_api($PromotionAPIURL, $PromotionAPIDataRequest);

                if ($PromotionDataAPI['responseCode'] == 000) {
                    
                } else {
                    var_dump($PromotionDataAPI);

                    exit();
                }
            }

            echo "success";
        } else {
            echo "No data received.";
        }
    } else {
        echo "Invalid request.";
    }
?>