<?php
    require_once "../functions.php";
    require_once "SimpleXLSXGen.php";

    $id = $_POST['id'];

    $PromotionDataAPIRequest = [
        "id" => $id
    ];

    $PromotionDataAPIResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/promotion/get-promotion", $PromotionDataAPIRequest);

    if ($PromotionDataAPIResponse['responseCode'] == 000) {

        $GetPromotionOrderDataAPIRequest = [
            "promotionId" => $id, 
            "purchaseStatus" => 6
        ];

        $GetPromotionOrderDataAPIResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/promotion/list-product-promotion", $GetPromotionOrderDataAPIRequest);

        if ($GetPromotionOrderDataAPIResponse['responseCode'] == 000) {
            $PromotionData = $PromotionDataAPIResponse['promotion'];

            $PromotionType = [
                "ลดราคาสินค้า",
                "ลดราคาสินค้า", 
                "ลดค่าส่ง", 
                "ส่งฟรี"
            ];

            $OrderDataExport = [];

            $OrderDataExport[] = [
                "Promotion: ", 
                $PromotionData['title'], 
                $PromotionType[$PromotionData['type']]. ": ", 
                ($PromotionData['type'] == 3) ? "ส่งฟรี" : $PromotionData['discount'] . " บาท", 
                "วันที่เริ่ม: ", 
                $PromotionData['startDate'], 
                "วันที่สิ้นสุด", 
                $PromotionData['endDate']
            ];

            $OrderDataExport[] = [];
            $OrderDataExport[] = [];

            $OrderDataExport[] = [
                "ลำดับ", 
                "SKU", 
                "ชื่อสินค้า", 
                "จำนวนที่สั่งซื้อ"
            ];

            $i = 1;

            foreach ($GetPromotionOrderDataAPIResponse['promotions'] as $list) {
                $OrderDataExport[] = [
                    $i, 
                    $list['itemCode'], 
                    $list['productTitle'], 
                    (@$list['uomCode']) ? $list['amount'] . " " . $list['uomCode'] : $list['amount'] . " " . "ชิ้น", 
                ];

                $i++;
            }
            
            $file = "promotion-$id-".time().".xlsx";

            $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $OrderDataExport );
            $xlsx->saveAs("./report/$file"); // or downloadAs('books.xlsx') or $xlsx_content = (string) $xlsx 

            echo json_encode(["response" => "success", "file" => $file]);
        } else {
            echo $GetPromotionOrderDataAPIResponse['responseCode'];
        }
    } else {
        echo $PromotionDataAPIResponse['responseCode'];
    }
?>