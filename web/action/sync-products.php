<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    connect_api("{$API_URL}boonsiri/ECom/product/sync-product-all");
?>