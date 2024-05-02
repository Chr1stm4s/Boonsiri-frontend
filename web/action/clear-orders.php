<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    connect_api("https://ecmapi.boonsiri.co.th/api/v1/boonsiri/expire-order");
?>