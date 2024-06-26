<?php
    require_once "../../functions.php";

    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = nl2br($_POST['description']);
    $metaTitle = $_POST['metaTitle'];
    $metaDescription = $_POST['metaDescription'];
    $keywords = $_POST['keywords'];

    $requestData = [
        "id" => $id,
        "title" => $title,
        "description" => $description,
        "metaTitle" => $metaTitle,
        "metaDescription" => $metaDescription,
        "keywords" => $keywords,
    ];

    $data = connect_api("{$API_URL}category/update-category", $requestData);

    if ($data['responseCode'] === "000") {
        if ($_FILES['image']['name']) {
            $file_name=$_FILES["image"]["name"];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            
            $image = time().".$ext";
        
            $upload = move_uploaded_file($_FILES['image']['tmp_name'], "../../products/category/$image");

            if ($upload) {
                $requestData = [
                    "id" => $id,
                    "title" => $title,
                    "description" => $description,
                    "image" => $image,
                    "metaTitle" => $metaTitle,
                    "metaDescription" => $metaDescription,
                    "keywords" => $keywords,
                ];
            
                $data = connect_api("{$API_URL}category/update-category", $requestData);
                
                if ($data['responseCode'] === "000") {
                    echo "success";
                } else {
                    echo "image \n";

                    var_dump($data);
                }
            } else {
                echo "upload \n";
                var_dump($data);
            }
        } else {
            echo "success";
        }
    } else {
        echo "update \n";

        var_dump($data);
    }