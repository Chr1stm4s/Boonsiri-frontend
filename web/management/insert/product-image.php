<?php
    require_once "../../functions.php";

    $id = $_POST['id'];
    $itemCode = $_POST['itemCode'];
    $title = $_POST['title'];

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

            if (!file_exists("../../products/gallery/$id")) {
                mkdir("../../products/gallery/$id", 0777, true);
            }

            //Setup our new file path
            $newFilePath = "../../products/gallery/$id/$image";

            //Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $APIURL = "$API_Link/v1/product/insert-product-image";
                    
                $ProductAPIDataRequest = [
                    'itemCode' => $itemCode, 
                    'altText'=> $title, 
                    'image'=> $image
                ];
            
                $ProductAPIDataResponse = connect_api($APIURL, $ProductAPIDataRequest);
                
                if ($ProductAPIDataResponse['responseDesc'] != "Success") {
                    var_dump($ProductAPIDataRequest);
                    var_dump($ProductAPIDataResponse);

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