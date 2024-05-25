<?php
    require_once "../../functions.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['checkboxValues'])) {
            $checkboxValues = $_POST['checkboxValues'];

            $PromotionAPIURL = "$API_Link/v1/promotion/set-promotion-by-item-code";

            // foreach ($checkboxValues as $value) {
                $PromotionAPIDataRequest = [
                    'itemCode' => $checkboxValues, 
                    'promotionId' => 0, 
                ];

                $PromotionDataAPI = connect_api($PromotionAPIURL, $PromotionAPIDataRequest);

                if ($PromotionDataAPI['responseCode'] == 000) {
                    echo "success";
                } else {
                    var_dump($PromotionDataAPI);

                    exit();
                }
            // }

            // echo "success";
        } else {
            echo "No data received.";
        }
    } else {
        echo "Invalid request.";
    }
?>