<?php
    require_once "../../functions.php";

    $id = $_POST['id'];
    $title = $_POST['title'];
    $intro = $_POST['intro'];
    $metaTitle = $_POST['metaTitle'];
    $metaDescription = $_POST['metaDescription'];
    $keywords = $_POST['keywords'];

    if ($id == 0) {
        $APIURL = "{$API_Link}api/v1/article-category/insert-article-category";

        if ($_FILES['thumbnail']['name']) {
            $file = $_FILES['thumbnail']['name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
        
            $thumbnail = time() . ".$ext";

            $image_file_path = "../../articles/$thumbnail";

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $image_file_path)) {
                    
                $APIDataRequest = [
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
            echo "no image";

            exit();
        }
    } else {
        $APIURL = "{$API_Link}api/v1/article-category/update-article-category";

        if ($_FILES['thumbnail']['name']) {
            $file = $_FILES['thumbnail']['name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
        
            $thumbnail = time() . ".$ext";

            $image_file_path = "../../articles/$thumbnail";

            if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $image_file_path)) {
                    
                $APIDataRequest = [
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