<?php
    require_once "../functions.php";
    require_once "SimpleXLSXGen.php";

    $GetProductsDataAPIRequest = [
        "whsCode" => "",
        "itemSize" => "",
        "orderByColumn" => "",
        "orderBy" => "",
        "pageNo" => 0,
        "pageSize" => 0
    ];

    $GetProductsDataAPIResponse = connect_api("{$API_Link}api/v1/product/list-product-all", $GetProductsDataAPIRequest);

    $ProductsDataExport[] = [
        "ลำดับ", 
        "รูปปกสินค้า", 
        "SKU", 
        "ชื่อสินค้า", 
        "น้ำหนักขนส่ง", 
        "หน่วยนับ", 
        "ราคาสินค้า", 
    ];

    $i = 1;

    foreach ($GetProductsDataAPIResponse['products'] as $list) {
        $ProductsDataExport[] = [
            $i, 
            ($list['thumbnail'] && file_exists("../products/".$list['thumbnail'])) ? "มีรูปภาพ" : "", 
            $list['itemCode'], 
            $list['title'], 
            ($list['weight']) ? $list['weight'] . " กิโลกรัม" : "ไม่มี", 
            ($list['uomCode']) ? $list['uomCode'] : "ชิ้น", 
            $list['price'], 
        ];

        $i++;
    }

    $file = 'products-'.time().'.xlsx';

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $ProductsDataExport );
    $xlsx->saveAs("./report/$file");

    echo json_encode(["response" => "success", "file" => $file]);
?>