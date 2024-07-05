<?php
    require_once "../functions.php";
    require_once "SimpleXLSXGen.php";

    $GetCustomersDataAPIResponse = connect_api("{$API_URL}customer/list-customer");

    $CustomersDataExport[] = [
        "CustomerID", 
        "ชื่อ", 
        "นามสกุล", 
        "เบอร์โทรศัพท์", 
        "email", 
        "LINE ID", 
        "วันที่สมัคร", 
        "วันที่เข้าใช้งานล่าสุด", 
        "cardCode", 
    ];

    foreach ($GetCustomersDataAPIResponse['customers'] as $list) {
        $CustomersDataExport[] = [
            $list['id'], 
            $list['fname'], 
            $list['lname'], 
            $list['phone'], 
            $list['email'], 
            $list['line'], 
            thai_date($list['added']), 
            ($list['lastLogin']) ? thai_date($list['lastLogin']) : "ยังไม่มีการเข้าใช้งาน", 
            $list['cardCode'], 
        ];
    }

    $file = 'customers-'.time().'.xlsx';

    $xlsx = Shuchkin\SimpleXLSXGen::fromArray( $CustomersDataExport );
    $xlsx->saveAs("./report/$file");

    echo json_encode(["response" => "success", "file" => $file]);
?>