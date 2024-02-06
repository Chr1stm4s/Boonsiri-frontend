<?php
    require_once "../../functions.php";

    if($_POST['type'] == "multiple") {
        $id_array = $_POST['id'];
        foreach($id_array as $id) {
            $dataAPI = [
                "id" => $id
            ];

            $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/mapping-branch/delete-mapping-branch", $dataAPI);

            if ($data['responseCode'] != 000) {
                var_dump($data);

                exit();
            }
        }

        echo "success";
    } else {
        $id = $_POST['id'];

        $dataAPI = [
            "id" => $id
        ];

        $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/mapping-branch/delete-mapping-branch", $dataAPI);

        if ($data['responseCode'] == 000) {
            echo "success";
        } else {
            var_dump($data);

            exit();
        }
    }
?>