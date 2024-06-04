<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-auto mx-auto">
            <table class="table table-bordered">
                <tbody>

                    <?php
                    require_once "./functions.php";

                    $apiUrl = "{$API_Link}api/v1/product/list-product-all";

                    $requestData = [
                        "itemSize" => "",
                        'orderByColumn' => '',
                        'orderBy' => '',
                        'pageNo' => 0,
                        'pageSize' => 0
                    ];

                    // Decode the response
                    $dataAPI = connect_api($apiUrl, $requestData);


                    $i = 1;

                    if ($dataAPI['responseCode'] == "000") {
                        foreach ($dataAPI['products'] as $product) {
                            $itemCode = str_replace("/", "", $product['itemCode']);
                            $filename = "./products/gallery/" . $itemCode . "/";
                    ?>

                            <tr>
                                <th><?= $i; ?>.</th>
                                <td><?= $itemCode; ?></td>

                                <?php
                                    if (file_exists($filename)) {
                                ?>
                                
                                <td>
                                    <span style='background-color:dark; color:darkblue;'>Yes</span>
                                </td>
                                <td>
                                    
                                    <?php
                                        $images = glob($filename . "*.*");

                                        foreach($images as $image) {
                                            $InsertImageURL = "{$API_Link}api/v1/product/insert-product-image";
                                            $explode = explode("/", $image);

                                            $image_file_name = end($explode);

                                            $InsertImageRequestData = [
                                                "itemCode" => $product['itemCode'],
                                                'image' => $image_file_name,
                                                'altText' => $product['title']
                                            ];

                                            // Decode the response
                                            $InsertImageResponseAPI = connect_api($InsertImageURL, $InsertImageRequestData);

                                    ?>

                                    <ul>
                                        <li><?=$image;?></li>
                                    </ul>
                                    
                                    <?php
                                        }
                                    ?>

                                </td>
                                
                                <?php
                                    } else {
                                ?>

                                <td colspan="2"></td>

                                <?php
                                    }
                                ?>

                            </tr>

                    <?php
                            $i++;
                        }
                    } else {
                        echo $dataAPI['responseCode'];
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>