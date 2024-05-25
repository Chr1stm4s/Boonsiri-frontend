<?php
    require_once "../functions.php";

    $DataAPIRequest = [
        "userCode" => $_POST['userCode'], 
        "password" => $_POST['password'], 
    ];

    $DataAPIResponse = connect_api("$API_Link/v1/user/login", $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        $_SESSION['admin_id'] = $DataAPIResponse['user']['id'];
        $_SESSION['admin_userName'] = $DataAPIResponse['user']['userName'];
        $_SESSION['admin_permission'] = $DataAPIResponse['user']['permission'];

        echo "success";
    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>