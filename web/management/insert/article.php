<?php
    require_once "../../functions.php";

    $categoryId = $_POST['categoryId'];
    $id = $_POST['id'];
    $title = $_POST['title'];
    $intro = $_POST['intro'];
    $metaTitle = $_POST['metaTitle'];
    $metaDescription = $_POST['metaDescription'];
    $keywords = $_POST['keywords'];

    if ($id == 0) {
        $file = $_FILES['thumbnail']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);
    
        $thumbnail = time() . ".$ext";
        
        $APIURL = "{$API_URL}article/insert-article";
                    
        $APIDataRequest = [
            "categoryId" => $categoryId,
            "thumbnail" => $thumbnail,
            "title" => $title,
            "intro" => $intro,
            "metaTitle" => $metaTitle,
            "metaDescription" => $metaDescription,
            "keywords" => $keywords
        ];
    
        $APIDataResponse = connect_api($APIURL, $APIDataRequest);
        
        if ($APIDataResponse['responseDesc'] == "Success") {
            $ArticleID = $APIDataResponse['article']['id'];

            if ($_FILES['thumbnail']['name']) {
                $path = "../../articles/$ArticleID";

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
    
                $image_file_path = "$path/$thumbnail";
    
                if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $image_file_path)) {
                    echo "success";
                } else {
                    echo "upload failed";
                }
            } else {
                echo "no image";
    
                exit();
            }
        } else {
            var_dump($APIDataRequest);
            var_dump($APIDataResponse);

            exit();
        }
    } else {
        $APIURL = "{$API_URL}article/update-article";

        if ($_FILES['thumbnail']['name']) {
            $file = $_FILES['thumbnail']['name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
        
            $thumbnail = time() . ".$ext";

            $path = "../../articles/$id";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image_file_path = "$path/$thumbnail";

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $image_file_path)) {
                    
                $APIDataRequest = [
                    "categoryId" => $categoryId,
                    "id" => $id,
                    "thumbnail" => $thumbnail,
                    "title" => $title,
                    "intro" => $intro,
                    "metaTitle" => $metaTitle,
                    "metaDescription" => $metaDescription,
                    "keywords" => $keywords
                ];
            
                $APIDataResponse = connect_api($APIURL, $APIDataRequest);
                
                if ($APIDataResponse['responseDesc'] == "Success") {
                    echo "success";
                } else {
                    var_dump($APIDataRequest);
                    var_dump($APIDataResponse);

                    exit();
                }
            } else {
                echo "upload failed";
            }
        } else {
            $thumbnail = $_POST['thumbnail'];
                    
            $APIDataRequest = [
                "categoryId" => $categoryId,
                "id" => $id,
                "thumbnail" => $thumbnail,
                "title" => $title,
                "intro" => $intro,
                "metaTitle" => $metaTitle,
                "metaDescription" => $metaDescription,
                "keywords" => $keywords
            ];
        
            $APIDataResponse = connect_api($APIURL, $APIDataRequest);
            
            if ($APIDataResponse['responseDesc'] == "Success") {
                echo "success";
            } else {
                var_dump($APIDataRequest);
                var_dump($APIDataResponse);

                exit();
            }
        }
    }
?>