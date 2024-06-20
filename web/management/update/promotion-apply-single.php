<?php
    require_once "../../functions.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['checkboxValues'])) {
            $PromotionAPIURL = "{$API_URL}promotion/set-promotion-by-item-code";

            $PromotionAPIDataRequest = [
                'itemCode' => $_POST['checkboxValues'], 
                'promotionId' => $_POST['promotionId'], 
            ];

            $PromotionDataAPI = connect_api($PromotionAPIURL, $PromotionAPIDataRequest);

            if ($PromotionDataAPI['responseCode'] == 000) {
                echo "success";
            } else {
                var_dump($PromotionDataAPI);

                exit();
            }
        } else {
            echo "No data received.";
        }
    } else {
        echo "Invalid request.";
    }
?>