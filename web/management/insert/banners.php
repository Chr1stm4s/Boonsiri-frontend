<?php
    require_once "../../functions.php";

    $api = $_POST['api'];
    $location = $_POST['location'];
    $url = ($_POST['url']) ? $_POST['url'] : "#";
    $altText = $_POST['altText'];
    $APIURL = ($api == "banner") ? "{$API_Link}api/v1/banner/insert-banner" : "{$API_Link}api/v1/featured/insert-featured";

    // Count # of uploaded files in array
    $total = count($_FILES['image']['name']);

    // Loop through each file
    for ($i = 0; $i < $total; $i++) {

        //Get the temp file path
        $tmpFilePath = $_FILES['image']['tmp_name'][$i];

        //Make sure we have a file path
        if ($tmpFilePath != "") {
            $file = $_FILES['image']['name'][$i];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
        
            $image = time() . "-$i.$ext";

            $path = ($api == "banner") ? "../../slideshows/home/header-$location" : "../../featured";

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            //Setup our new file path
            $newFilePath = "$path/$image";

            //Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $BannerAPIDataRequest = [
                    'location' => $location, 
                    'url' => $url, 
                    'altText'=> $altText, 
                    'image'=> $image
                ];
            
                $BannerAPIDataResponse = connect_api($APIURL, $BannerAPIDataRequest);
                
                if (@$BannerAPIDataResponse['responseDesc'] != "Success") {
                    var_dump($_POST);
                    var_dump($BannerAPIDataRequest);
                    var_dump($BannerAPIDataResponse);

                    exit();
                }
            } else {
                echo "upload failed";
            }
        } else {
            echo "no image";
        }
    }

    echo "success";
?>