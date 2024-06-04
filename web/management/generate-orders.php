<?php
    require_once "../functions.php";
    require_once "SimpleXLSXGen.php";

    $badge = array(
        'กำลังสั่งซื้อ',
        'รอชำระเงิน',
        'รอยืนยันชำระเงิน',
        'ชำระเงินแล้ว',
        'กำลังเตรียมสินค้า',
        'กำลังจัดส่ง',
        'รับสินค้าแล้ว',
        'รีวิวสำเร็จ',
        'มีสินค้าแจ้งเคลม',
        'เคลมแล้ว',
        'เสร็จสมบูรณ์',
        'เกินกำหนดชำระ'
    );

    $courier = array(
        'ไม่ระบุ',
        'บุญศิริ',
        'ขนส่งเอกชน (ภาคเหนือ)',
        'ขนส่งเอกชน (ภาคอื่นๆ)'
    );

    $OrderDataAPIRequest = [
        "customerId" => 0
    ];

    $OrderDataAPIResponse = connect_api("{$API_Link}api/v1/purchase/list-purchase", $OrderDataAPIRequest);

    if ($OrderDataAPIResponse['responseCode'] == 000) {
        $OrderDataExport = [];

        $OrderDataExport[] = [
            "เลขที่คำสั่งซื้อ", 
            "สถานะคำสั่งซื้อ", 
            "สายส่ง", 
            "ชื่อผู้สั่งซื้อ", 
            "ที่อยู่", 
            "เบอร์ติดต่อ", 
            "มูลค่าคำสั่งซื้อ", 
            "สาขาที่สั่งซื้อ", 
            "วันที่สั่งซื้อ", 
            "รายการสินค้า", 
            "ชื่อสินค้า", 
            "โปรโมชั่น", 
            "จำนวน", 
            "ราคาสินค้า", 
            "ค่าจัดส่ง", 
        ];

        if ($_POST['ReportStartDate'] && $_POST['ReportEndDate']) {
            $ReportStartDate = date("d-m-Y", strtotime($_POST['ReportStartDate']));
            $ReportEndDate = date("d-m-Y", strtotime($_POST['ReportEndDate']));

            foreach ($OrderDataAPIResponse['purchases'] as $item) {
                $OrderDate = date("d-m-Y", strtotime($item['added']));
    
                if (($OrderDate >= $ReportStartDate) && ($OrderDate <= $ReportEndDate)){
                    $GetOrderDataAPIRequest = [
                        "id" => $item['id']
                    ];
        
                    $GetOrderDataAPIResponse = connect_api("{$API_Link}api/v1/purchase/get-purchase", $GetOrderDataAPIRequest);
        
                    $OrderDataExport[] = [
                        $item['orderNo'], 
                        $badge[$item['status']], 
                        $courier[$item['courierId']], 
                        $item['fname'] . " " . $item['lname'], 
                        $item['address'] . " " . $item['district'] . " " . $item['amphur'] . " " . $item['province'] . " " . $item['postcode'], 
                        $item['phone'], 
                        $item['totalPrice'], 
                        $item['branchName'], 
                        $OrderDate
                    ];
        
                    $i = 1;
        
                    foreach ($GetOrderDataAPIResponse['purchase']['listItem'] as $list) {
                        $OrderDataExport[] = [
                            "", 
                            "", 
                            "", 
                            "", 
                            "", 
                            "", 
                            "", 
                            $i, 
                            $list['title'], 
                            $list['promotionId'], 
                            ($list['uomCode']) ? $list['amount'] . " " . $list['uomCode'] : $list['amount'] . " " . "ชิ้น", 
                            $list['eachLastPrice'], 
                            $list['lastShippingPrice'], 
                        ];
        
                        $i++;
                    }
                }
            }
        } else {
            foreach ($OrderDataAPIResponse['purchases'] as $item) {
                $OrderDate = date("d-m-Y", strtotime($item['added']));
                
                $GetOrderDataAPIRequest = [
                    "id" => $item['id']
                ];
    
                $GetOrderDataAPIResponse = connect_api("{$API_Link}api/v1/purchase/get-purchase", $GetOrderDataAPIRequest);
    
                $OrderDataExport[] = [
                    $item['orderNo'], 
                    $badge[$item['status']], 
                    $courier[$item['courierId']], 
                    $item['fname'] . " " . $item['lname'], 
                    $item['address'] . " " . $item['district'] . " " . $item['amphur'] . " " . $item['province'] . " " . $item['postcode'], 
                    $item['phone'], 
                    $item['totalPrice'], 
                    $item['branchName'], 
                    $OrderDate
                ];
    
                $i = 1;
    
                foreach ($GetOrderDataAPIResponse['purchase']['listItem'] as $list) {
                    $OrderDataExport[] = [
                        "", 
                        "", 
                        "", 
                        "", 
                        "", 
                        "", 
                        "", 
                        $i, 
                        $list['title'], 
                        $list['promotionId'], 
                        ($list['uomCode']) ? $list['amount'] . " " . $list['uomCode'] : $list['amount'] . " " . "ชิ้น", 
                        $list['eachLastPrice'], 
                        $list['lastShippingPrice'], 
                    ];
    
                    $i++;
                }
            }
        }
        
        $file = 'orders-'.time().'.xlsx';

        $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $OrderDataExport );
        $xlsx->saveAs("./report/$file"); // or downloadAs('books.xlsx') or $xlsx_content = (string) $xlsx 

        echo json_encode(["response" => "success", "file" => $file]);
    } else {
        echo $OrderDataAPIResponse['responseCode'];
    }
?>