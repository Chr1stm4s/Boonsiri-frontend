<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    connect_api("$API_Link/v1/boonsiri/expire-order");
?>