<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "orders";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Orders</h1>
                </div>
                <div class="col-auto">
                    <input type="date" class="form-control" id="ReportStartDate">
                </div>
                <div class="col-auto px-0">
                    <input type="date" class="form-control" id="ReportEndDate">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" id="Export">Export</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">เลขที่คำสั่งซื้อ</th>
                                <th>ชื่อผู้สั่งซื้อ</th>
                                <th>ที่อยู่</th>
                                <th class="fit">เบอร์ติดต่อ</th>
                                <th class="text-end">ราคา</th>
                                <th class="px-4 fit text-center">สถานะ</th>
                                <th class="px-4 fit text-center">เลขขนส่ง</th>
                                <th class="fit">วันที่สั่งซื้อ</th>
                                <th class="fit">แก้ไขล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $badge = array(
                                '<span class="badge text-bg-light w-100">กำลังสั่งซื้อ</span>', 
                                '<span class="badge text-bg-light w-100">รอชำระเงิน</span>', 
                                '<span class="badge text-bg-success w-100">รอยืนยันชำระเงิน</span>', 
                                '<span class="badge text-bg-success w-100">ชำระเงินแล้ว</span>', 
                                '<span class="badge text-bg-info w-100">กำลังเตรียมสินค้า</span>', 
                                '<span class="badge text-bg-primary w-100">กำลังจัดส่ง</span>', 
                                '<span class="badge text-bg-success w-100">รับสินค้าแล้ว</span>', 
                                '<span class="badge text-bg-info w-100">รีวิวแล้ว</span>', 
                                '<span class="badge text-bg-danger w-100">มีสินค้าแจ้งเคลม</span>', 
                                '<span class="badge text-bg-success w-100">เคลมแล้ว</span>'
                            );

                            $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/purchase/list-purchase";
                            
                            $data = connect_api($apiUrl);

                            if ($data['responseCode'] == 000) {
                                foreach ($data['purchases'] as $purchase) {
                        ?>

                            <tr>
                                <th class="text-end">
                                    <a href="./order-details.php?id=<?=$purchase['id'];?>" class="text-dark text-decoration-none btn-tooltip" data-bs-title="ดูรายการสินค้า">
                                        <?=$purchase['orderNo'];?>
                                    </a>
                                </th>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$purchase['fname'];?> <?=$purchase['lname'];?>"><?=$purchase['fname'];?> <?=$purchase['lname'];?></p></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$purchase['address'];?> <?=$purchase['district'];?> <?=$purchase['amphur'];?> <?=$purchase['province'];?> <?=$purchase['postcode'];?>"><?=$purchase['address'];?> <?=$purchase['district'];?> <?=$purchase['amphur'];?> <?=$purchase['province'];?> <?=$purchase['postcode'];?></p></td>
                                <td class="fit"><a href="tel:<?=$purchase['phone'];?>"><?=$purchase['phone'];?></a></td>
                                <td class="fit text-end"><?=number_format($purchase['totalPrice']);?> บาท</td>
                                <td class="fit"><?=$badge[$purchase['status']];?></td>
                                <td class="fit"><?=$purchase['tracking'];?></td>
                                <td class="fit text-center"><?=date("d M Y", strtotime($purchase['added']));?></td>
                                <td class="fit text-center"><?=time_ago("th", $purchase['updates']);?></td>
                                <td class="fit">
                                    <a href="./order-details.php?id=<?=$purchase['id'];?>" class="btn btn-outline-dark btn-tooltip" data-bs-title="ดูรายการสินค้า"><i class="fa-solid fa-list"></i></a>

                                    <?php
                                        if ($purchase['status'] == 2) {
                                    ?>

                                    <button class="btn btn-success btn-tooltip btn-confirm" data-id="<?=$purchase['id'];?>" data-status="3" data-bs-title="ยืนยันการชำระเงิน"><i class="fa-solid fa-check"></i></button>

                                    <?php
                                        } elseif ($purchase['status'] == 3) {
                                    ?>

                                    <button type="button" class="btn btn-outline-warning btn-tooltip btn-packing" data-id="<?=$purchase['id'];?>" data-status="4" data-bs-title="กำลังเตรียมสินค้า"><i class="fa-solid fa-box-open"></i></button>
                                    <button type="button" class="btn btn-outline-primary btn-tooltip btn-shipping" data-id="<?=$purchase['id'];?>" data-status="5" data-bs-title="แจ้งเลขขนส่ง"><i class="fa-solid fa-truck-fast"></i></button>

                                    <?php
                                        } elseif ($purchase['status'] == 4) {
                                    ?>

                                    <button type="button" class="btn btn-outline-primary btn-tooltip btn-shipping" data-id="<?=$purchase['id'];?>" data-status="5" data-bs-title="แจ้งเลขขนส่ง"><i class="fa-solid fa-truck-fast"></i></button>

                                    <?php
                                        } elseif ($purchase['status'] == 7) {
                                    ?>

                                    <a href="./order-review.php?id=<?=$purchase['review'];?>" class="btn btn-warning btn-tooltip" data-bs-title="ดูรีวิวคำสั่งซื้อ"><i class="fa-solid fa-message"></i></a>

                                    <?php
                                        }
                                    ?>

                                </td>
                            </tr>

                        <?php
                                }
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#DataTables').DataTable( {
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 
                    }
                ],
                order: [
                    [
                        1, 'asc'
                    ]
                ]
            } );
        }, false);

        $("#Export").click(function() {
            const ReportStartDate = $("#ReportStartDate").val();
            const ReportEndDate = $("#ReportEndDate").val();

            Swal.fire({
                title: 'กำลังดำเนินการ...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post(
                "./generate-orders.php", 
                {
                    "ReportStartDate": ReportStartDate, 
                    "ReportEndDate": ReportEndDate, 
                }, 
                function(response) {
                    const data = JSON.parse(response);

                    if (data.response == "success") {
                        Swal.fire({
                            title: 'สร้างรายงานสำเร็จ',
                            icon: 'success',
                            showCancelButton: false,
                            showDenyButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ดาวน์โหลด'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `./report/${data.file}`; // Replace with your link
                            }
                        })
                    } else {
                        Swal.fire(
                            'สร้างรายงานไม่สำเร็จ',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(data)
                    }
                }
            )
        });

        $(".btn-confirm").click(function() {
            const id = $(this).data("id");
            const status = $(this).data("status");

            purchase_status(id, status, 'ยืนยันการชำระเงินคำสั่งซื้อ');
        });

        $(".btn-packing").click(function() {
            const id = $(this).data("id");
            const status = $(this).data("status");

            purchase_status(id, status, 'ยืนยันรับ Order และเตรียมสินค้า');
        });

        $(".btn-shipping").click(function() {
            const id = $(this).data("id");
            const status = $(this).data("status");
            
            Swal.fire({
                title: "กรุณากรอกเลข Tracking",
                input: "text",
                inputAttributes: {
                    autocapitalize: "off"
                },
                showCancelButton: true,
                cancelButtonText: "ยกเลิก", 
                confirmButtonText: "ยืนยันเลขขนส่ง",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังดำเนินการ...',
                        showDenyButton: false,
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    const headers = {
                        'Content-Type': 'application/json'
                    };

                    const ConfirmData = {
                        "id": id, 
                        "status": status
                    };

                    const StatusRequestOptions = {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(ConfirmData)
                    };

                    const tracking = {
                        "id": id, 
                        "tracking": result.value
                    }

                    console.log(tracking);

                    const TrackingRequestOptions = {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(tracking)
                    };

                    fetch("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/update-tracking", TrackingRequestOptions)
                    .then(response => response.json())
                    .then(
                        obj => {
                            if (obj.responseCode === "000") {
                                fetch("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/internal-update-purchase-status", StatusRequestOptions)
                                .then(response => response.json())
                                .then(
                                    obj => {
                                        if (obj.responseCode === "000") {
                                            Swal.fire(
                                                `ยืนยันเลขขนส่งนี้สำเร็จ!`,
                                                ``,
                                                'success'
                                            ).then(function() {
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire(
                                                `ยืนยันเลขขนส่งนี้ไม่สำเร็จ!`,
                                                `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                'error'
                                            );
                                        }
                                    }
                                )
                                .catch(
                                    error => {
                                        console.error('Error:', error);
                                    }
                                );
                            } else {
                                Swal.fire(
                                    `ยืนยันเลขขนส่งนี้ไม่สำเร็จ!`,
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );
                            }
                        }
                    )
                    .catch(
                        error => {
                            console.error('Error:', error);
                        }
                    );
                }
            });
        });

        function purchase_status(id, status, action) {
            Swal.fire({
                title: `ต้องการ${action}นี้ใช่ไหม?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5733',
                cancelButtonColor: '#000',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังดำเนินการ...',
                        showDenyButton: false,
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const ConfirmData = {
                        "id": id, 
                        "status": status
                    };

                    const headers = {
                        'Content-Type': 'application/json'
                    };

                    const requestOptions = {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(ConfirmData)
                    };

                    fetch("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/internal-update-purchase-status", requestOptions)
                    .then(response => response.json())
                    .then(
                        obj => {
                            if (obj.responseCode === "000") {
                                Swal.fire(
                                    `ยืนยัน${action}นี้สำเร็จ!`,
                                    ``,
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    `ยืนยัน${action}นี้ไม่สำเร็จ!`,
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );
                            }
                        }
                    )
                    .catch(
                        error => {
                            console.error('Error:', error);
                        }
                    );
                }
            });
        }
    </script>

</body>

</html>