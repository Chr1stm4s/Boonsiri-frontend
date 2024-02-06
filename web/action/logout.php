<?php
    require_once "../functions.php";

    header('Access-Control-Allow-Origin: *');
    
    $_SESSION['id'] = null;
    $_SESSION['fname'] = null;
    $_SESSION['lname'] = null;
    $_SESSION['email'] = null;
    $_SESSION['phone'] = null;
    $_SESSION['address_id'] = null;
    $_SESSION['name'] = null;
    $_SESSION['address'] = null;
    $_SESSION['province'] = null;
    $_SESSION['postcode'] = null;
    $_SESSION['whsCode'] = null;

    session_destroy();

    redirect(rootURL());
?>