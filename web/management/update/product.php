<?php
    require_once "../../functions.php";

    $DataAPIRequest = [
        "id" => $id, 
        "metaTitle" => $_POST['metaTitle'],
        "metaDescription" => $_POST['metaDescription'],
        "keyWords" => $_POST['keywords'],
        "url" => $_POST['url'],
        "thumbnail" => $image,
        "weight" => $_POST['weight'],
        "sku" => $_POST['sku'],
        "title" => $_POST['title'],
        "description" => $_POST['description'],
        "price" => $_POST['price']
    ];

    $DataAPIResponse = connect_api("$API_Link/v1/product/update-product", $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        echo "success";
    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>