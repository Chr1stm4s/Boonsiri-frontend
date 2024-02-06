<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "claims";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Claims</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">เลขเคลม</th>
                                <th class="fit">เลขคำสั่งซื้อ</th>
                                <th class="fit">ชื่อผู้เคลม</th>
                                <th class="fit">เบอร์โทรศัพท์</th>
                                <th>หัวข้อ</th>
                                <th>รายละเอียด</th>
                                <th class="fit">สถานะ</th>
                                <th class="fit">วันที่เวลาที่ส่งเคลม</th>
                                <th class="px-4 fit">ปรับปรุงล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $customers = [];
                            $status = array(
                                '<span class="badge text-bg-light w-100">เปิดเคส</span>', 
                                '<span class="badge text-bg-warning w-100">รอเจ้าหน้าที่ตอบกลับ</span>',
                                '<span class="badge text-bg-primary w-100">รอลูกค้าตอบกลับ</span>',
                                '<span class="badge text-bg-success w-100">เสร็จสิ้น</span>'
                            );

                            $customersData = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/customer/list-customer");

                            foreach ($customersData['customers'] as $customer) {
                                $customers[$customer['id']] = [
                                    "name" => $customer['fname']." ".$customer['lname'], 
                                    "phone" => $customer['phone']
                                ];
                            }
                            
                            $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/case/list-case";
                            
                            $data = connect_api($apiUrl);

                            if ($data['responseCode'] == 000) {
                                foreach ($data['cases'] as $cases) {

                                    $CaseStatusRequest = [
                                        "id" => $cases['id']
                                    ];

                                    $CaseStatusAPI = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/case/get-case", $CaseStatusRequest);
                        ?>

                            <tr>
                                <th class="text-end"><?=$cases['id'];?></th>
                                <td class="fit"><?=$cases['orderNo'];?></td>
                                <td class="fit"><?=$customers[$cases['customerId']]["name"];?></td>
                                <td class="fit"><a href="tel:<?=$customers[$cases['customerId']]["phone"];?>"><?=$customers[$cases['customerId']]["phone"];?></a></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=strip_tags($cases['caseTitle']);?>"><?=strip_tags($cases['caseTitle']);?></p></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=strip_tags($cases['caseDescription']);?>"><?=strip_tags($cases['caseDescription']);?></p></td>
                                <td class="fit"><?=$status[$CaseStatusAPI['case']['status']];?></td>
                                <td class="fit"><?=date("d M Y H:i", strtotime($cases['added']));?></td>
                                <td class="fit"><?=time_ago("th", $cases['updates']);?></td>
                                <td class="fit">
                                    <a href="./claims-details.php?id=<?=$cases['id'];?>" class="btn btn-outline-primary btn-tooltip btn-chat" data-id="<?=$cases['id'];?>" data-bs-title="อัพเดตสถานะการเคลม"><i class="fa-solid fa-message"></i></a>

                                    <?php
                                        if ($CaseStatusAPI['case']['status'] != 3) {
                                    ?>

                                    <button class="btn btn-outline-success btn-done" data-id="<?=$cases['id'];?>" data-purchase="<?=$cases['purchaseId'];?>"><i class="fa-solid fa-check"></i></button>

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
            let table = new DataTable('#DataTables');

            $(".btn-done").on("click", function() {
                const id = $(this).data("id");
                const purchase = $(this).data("purchase");

                Swal.fire({
                    title: 'ต้องการปิดเคสนี้ใช่ไหม?',
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

                        $.post(
                            "./insert/case-message.php", 
                            {
                                "caseId": id,
                                "message": "เคสปิดแล้ว ขอบคุณที่ไว้วางใจบุญศิริ",
                                "status": 3, 
                                "purchaseId": purchase
                            }, function(response){
                                Swal.close();

                                if (response == "success") {
                                    Swal.fire(
                                        'ส่งข้อความสำเร็จ!',
                                        'เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด',
                                        'success'
                                    ).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'ส่งข้อมูลล้มเหลว!',
                                        'กรุณาติดต่อเจ้าหน้าที่',
                                        'error'
                                    );

                                    console.log(response)
                                }
                            }
                        );
                    }
                });
            });
        }, false);
    </script>

</body>

</html>