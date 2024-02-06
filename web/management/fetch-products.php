<?php
    require_once "../functions.php";

    header('Content-Type: application/json');

    $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/product/list-product";

    $requestData = [
        'whsCode' => "SSK", 
        'orderByColumn' => '',  
        'orderBy' => '', 
        'pageNo' => intval($_POST['start']) + 1, 
        'pageSize' => intval($_POST['length'])
    ];

    // Decode the response
    $dataAPI = connect_api($apiUrl, $requestData);

    if ($dataAPI['responseCode'] == "000") {
        // Prepare the data in the format required by DataTables
        $data = [];
        
        foreach ($dataAPI['products'] as $product) {
            $image = ($product['thumbnail'] && file_exists("../products/".$product['thumbnail'])) ? "../products/".$product['thumbnail'] : "../images/logo.png";
            $data[] = [
                $product['id'],
                "<img src='{$image}' class='product-thumbnail' data-bs-toggle='modal' data-bs-target='#ThumbnailModal' data-bs-id='{$product['id']}' data-bs-img='{$image}' data-bs-title='{$product['title']}'>",
                "<p class='mb-0 btn-tooltip' data-bs-title='{$product['title']}'>{$product['title']}</p>",
                "<p class='mb-0 btn-tooltip' data-bs-title='{$product['sku']}'>{$product['sku']}</p>",
                "{$product['weight']} KG",
                number_format($product['price'])." THB",
                time_ago("th", $product['updates']),
                "<a href='#' class='btn btn-primary btn-tooltip disabled' target='_blank' data-bs-title='view'><i class='fa-regular fa-eye'></i></a>
                <a href='./product-images.php?id={$product['id']}' class='btn btn-outline-dark btn-tooltip' data-bs-title='gallery'><i class='fa-solid fa-images'></i></a>
                <button type='button' class='btn btn-warning btn-tooltip btn-edit' disabled data-bs-title='edit'><i class='fa-regular fa-pen-to-square'></i></button>"
            ];
        }

        // Return the data in the format required by DataTables
        $result = [
            "draw" => intval($_POST['draw']),
            "recordsTotal" => count($data),
            "recordsFiltered" => 653,
            "data" => $data
        ];

        echo json_encode($result);
    } else {
        echo json_encode($requestData);
        echo json_encode($dataAPI);
    }
?>