<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    connect_api("{$API_Link}api/v1/boonsiri/ECom/product/sync-product-all");
?>