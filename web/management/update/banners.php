<?php
    require_once "../../functions.php";

    $id = $_POST['id'];
    $url = ($_POST['url']) ? $_POST['url'] : "#";
    $altText = $_POST['altText'];
    $APIURL = $_POST['APIURL'];

    $DataAPIRequest = [
        "id" => $id, 
        "altText" => $altText, 
        "url" => $url
    ];

    $DataAPIResponse = connect_api($APIURL, $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        echo "success";
    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>