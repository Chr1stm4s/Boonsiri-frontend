<?php
    require_once "../../functions.php";

    $articleId = $_POST['articleId'];
    $id = $_POST['id'];
    $type = $_POST['type'];
    $header = $_POST['header'];

    if ($id == 0) {
        $APIURL = "{$API_URL}article-detail/insert-article-detail";

        if ($type == 1) {
            $APIDataRequest = [
                "articleId" => $articleId,
                "type" => $type,
                "header" => $header,
                "content" => $_POST['content'],
            ];
        } elseif ($type == 2) {
            if ($_FILES['content']['name']) {
                $file = $_FILES['content']['name'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
            
                $content = time() . ".$ext";

                $path = "../../articles/$articleId";

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
    
                $image_file_path = "$path/$content";
    
                if (move_uploaded_file($_FILES['content']['tmp_name'], $image_file_path)) {
                        
                    $APIDataRequest = [
                        "articleId" => $articleId,
                        "type" => $type,
                        "header" => $header,
                        "content" => $content,
                    ];
                } else {
                    echo "upload failed";
                }
            } else {
                echo "no image";
    
                exit();
            }
        } else {
            echo "no type";

            exit();
        }
        
        $APIDataResponse = connect_api($APIURL, $APIDataRequest);
            
        if ($APIDataResponse['responseDesc'] == "Success") {
            echo "success";
        } else {
            var_dump($APIDataRequest);
            var_dump($APIDataResponse);

            exit();
        }
    } else {
        $APIURL = "{$API_URL}article-detail/update-article-detail";

        if ($type == 1) {
            $APIDataRequest = [
                "id" => $id,
                "header" => $header,
                "articleId" => $articleId,
                "type" => $type,
                "content" => $_POST['content'],
            ];
        } elseif ($type == 2) {
            if ($_FILES['content']['name']) {
                $file = $_FILES['content']['name'];
                $ext = pathinfo($file, PATHINFO_EXTENSION);
            
                $content = time() . ".$ext";
    
                $image_file_path = "../../articles/$articleId/$content";
    
                if (move_uploaded_file($_FILES['content']['tmp_name'], $image_file_path)) {
                    $APIDataRequest = [
                        "id" => $id,
                        "header" => $header,
                        "content" => $content,
                        "articleId" => $articleId,
                        "type" => $type
                    ];
                } else {
                    echo "upload failed";
                }
            } else {
                echo "no image";
    
                exit();
            }
        } else {
            echo "no type";

            exit();
        }
        
        $APIDataResponse = connect_api($APIURL, $APIDataRequest);
            
        if ($APIDataResponse['responseDesc'] == "Success") {
            echo "success";
        } else {
            var_dump($APIDataRequest);
            var_dump($APIDataResponse);

            exit();
        }
    }
?>