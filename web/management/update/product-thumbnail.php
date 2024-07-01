<?php
    require_once "../../functions.php";
    
    $id = $_POST['id'];

    $DataAPIRequest = [
        "productId" => $id
    ];

    $DataAPIResponse = connect_api("{$API_URL}product/get-product-by-id", $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        $file = $_FILES['image']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        $image = time().".$ext";

        $upload = move_uploaded_file($_FILES['image']['tmp_name'], "../../products/$image");

        if ($upload) {
            $ThumbnailDataAPIRequest = [
                "itemCode" => $DataAPIResponse['product']['itemCode'], 
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

            $ThumbnailDataAPIResponse = connect_api("{$API_URL}product/update-product-by-item-code", $ThumbnailDataAPIRequest);

            if ($ThumbnailDataAPIResponse['responseCode'] == "000") {
                echo "success";
            } else {
                var_dump($ThumbnailDataAPIRequest);
                var_dump($ThumbnailDataAPIResponse);
            }

            // $host = "43.249.35.194";
            // $user = "admin_boonsiri";
            // $pass = "9MhQtskkZ6zYXhSmQDHy";
            // $database = "admin_boonsiri";
            // $con = mysqli_connect($host, $user, $pass, $database);
            
            // // Check connection
            // if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
            
            // // Change character set to utf8
            // mysqli_set_charset($con,"utf8");

            // date_default_timezone_set('Asia/Bangkok');

            // $itemCode = $DataAPIResponse['product']['itemCode'];

            // $UpdateSQL = "UPDATE `products` SET `thumbnail` = '$image' WHERE `item_code` = '$itemCode'";
            // $UpdateQuery = mysqli_query($con, $UpdateSQL) or die(mysqli_error($con));

            // if ($UpdateQuery) {
            //     echo "success";
            // } else {
            //     echo "update";
            // }
        } else {
            echo "upload";
        }
    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>