<?php
    require_once "../../functions.php";
    
    $id = $_POST['id'];

    $DataAPIRequest = [
        "productId" => $id
    ];

    $DataAPIResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/product/get-product-by-id", $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        $file = $_FILES['image']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        $image = time().".$ext";

        $upload = move_uploaded_file($_FILES['image']['tmp_name'], "../../products/$image");

        if ($upload) {
            
            $ThumbnailDataAPIRequest = [
                "id" => $id, 
                "metaTitle" => $DataAPIResponse['product']['metaTitle'], 
                "metaDescription" => $DataAPIResponse['product']['metaDescription'], 
                "keyWords" => $DataAPIResponse['product']['keywords'], 
                "url" => $DataAPIResponse['product']['url'], 
                "thumbnail" => $image, 
                "weight" => $DataAPIResponse['product']['weight'], 
                "sku" => $DataAPIResponse['product']['sku'], 
                "title" => $DataAPIResponse['product']['title'], 
                "description" => $DataAPIResponse['product']['description'], 
                "price" => $DataAPIResponse['product']['price']
            ];

            $ThumbnailDataAPIResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/product/update-product", $ThumbnailDataAPIRequest);

            if ($ThumbnailDataAPIResponse['responseCode'] == "000") {
                echo "success";
            } else {
                var_dump($ThumbnailDataAPIRequest);
                var_dump($ThumbnailDataAPIResponse);
            }
        } else {
            echo "upload";
        }

    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>