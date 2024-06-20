<?php
    require_once "../../functions.php";

    $id = $_POST['id'];
    $type = $_POST['type'];
    $title = $_POST['title'];
    $metaTitle = $_POST['metaTitle'];
    $metaDescription = $_POST['metaDescription'];
    $keywords = $_POST['keywords'];

    if ($_FILES['cover']['name']) {
        $file_name=$_FILES["cover"]["name"];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        
        $cover = time().".$ext";
    
        $upload = move_uploaded_file($_FILES['cover']['tmp_name'], "../../meta/$cover");

        if ($upload) {
            $DataAPIRequest = [
                "id" => $id,
                "type" => $type,
                "cover" => $cover,
                "title" => $title,
                "metaTitle" => $metaTitle,
                "metaDescription" => $metaDescription,
                "keywords" => $keywords,
            ];
        } else {
            echo "upload \n";
            var_dump($data);

            return;
        }
    } else {
        $DataAPIRequest = [
            "id" => $id,
            "type" => $type,
            "title" => $title,
            "metaTitle" => $metaTitle,
            "metaDescription" => $metaDescription,
            "keywords" => $keywords,
        ];
    }

    $DataAPIResponse = connect_api("{$API_URL}page/update-page", $DataAPIRequest);

    if ($DataAPIResponse['responseCode'] == "000") {
        echo "success";
    } else {
        var_dump($DataAPIRequest);
        var_dump($DataAPIResponse);
    }
?>