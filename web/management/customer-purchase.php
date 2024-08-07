<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "customers";

        require_once "./head.php";

        $id = $_GET['id'];
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./customers.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">Customer - purchase</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th class="fit">เลขคำสั่งซื้อ</th>
                                <th>ชื่อผู้รับ</th>
                                <th class="fit">เบอร์โทรศัพท์</th>
                                <th class="fit text-center">สถานะคำสั่งซื้อ</th>
                                <th class="fit text-center">ยอดรวม</th>
                                <th class="text-center">วันที่สั่งซื้อ</th>
                                <th class="fit">เครื่องมือ</th>
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
                                '<span class="badge text-bg-info w-100">รีวิวสำเร็จ</span>',
                                '<span class="badge text-bg-danger w-100">ยกเลิกคำสั่งซื้อ</span>',
                                '<span class="badge text-bg-dark w-100">เคลมแล้ว</span>',
                                '<span class="badge text-bg-success w-100">เสร็จสมบูรณ์</span>',
                                '<span class="badge text-bg-secondary w-100">เกินกำหนดชำระ</span>', 
                                '<span class="badge text-bg-danger w-100">มีสินค้าแจ้งเคลม</span>'
                            );

                            $APIRequest = [
                                'customerId' => $id,
                            ];

                            $Response = connect_api("{$API_URL}purchase/list-purchase", $APIRequest);

                            if ($Response['responseCode'] == 000 && $Response['purchases']) {
                                foreach ($Response['purchases'] as $OrderData) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$OrderData['orderNo'];?></th>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="คุณ <?=$OrderData['fname'];?> <?=$OrderData['lname'];?>">คุณ <?=$OrderData['fname'];?> <?=$OrderData['lname'];?></p></td>
                                <td><?=$OrderData['phone'];?></td>
                                <td class="fit"><?=$badge[$OrderData['status']];?></td>
                                <td class="fit text-end"><?=number_format($OrderData['totalPrice']);?> บาท</td>
                                <td class="fit text-center"><p class="mb-0 btn-tooltip w-100" data-bs-title="<?=date("d M Y", strtotime($OrderData['added']));?>"><?=date("d M", strtotime($OrderData['added']));?> <?=date("Y", strtotime($OrderData['added'])) + 543;?></p></td>
                                <td class="fit">
                                    <a href="./order-details.php?id=<?=$OrderData['id'];?>&customer=<?=$id;?>" class="btn btn-outline-dark btn-tooltip" data-bs-title="ดูรายการสินค้า"><i class="fa-solid fa-list"></i></a>

                                    <?php
                                        if ($OrderData['status'] == 2) {
                                    ?>

                                    <button class="btn btn-success btn-tooltip btn-confirm" data-id="<?=$OrderData['id'];?>" data-status="3" data-bs-title="ยืนยันการชำระเงิน"><i class="fa-solid fa-check"></i></button>

                                    <?php
                                        } elseif ($OrderData['status'] == 3) {
                                    ?>

                                    <button type="button" class="btn btn-outline-warning btn-tooltip btn-packing" data-id="<?=$OrderData['id'];?>" data-status="4" data-bs-title="กำลังเตรียมสินค้า"><i class="fa-solid fa-box-open"></i></button>
                                    <button type="button" class="btn btn-outline-primary btn-tooltip btn-shipping" data-id="<?=$OrderData['id'];?>" data-status="5" data-bs-title="แจ้งเลขขนส่ง"><i class="fa-solid fa-truck-fast"></i></button>

                                    <?php
                                        } elseif ($OrderData['status'] == 4) {
                                    ?>

                                    <button type="button" class="btn btn-outline-primary btn-tooltip btn-shipping" data-id="<?=$OrderData['id'];?>" data-status="5" data-bs-title="แจ้งเลขขนส่ง"><i class="fa-solid fa-truck-fast"></i></button>

                                    <?php
                                        } elseif ($OrderData['status'] == 7) {
                                    ?>

                                    <a href="./order-review.php?id=<?=$OrderData['review'];?>" class="btn btn-warning btn-tooltip" data-bs-title="ดูรีวิวคำสั่งซื้อ"><i class="fa-solid fa-message"></i></a>

                                    <?php
                                        }
                                    ?>

                                </td>
                            </tr>

                        <?php
                                }
                            } else {
                        ?>

                            <tr>
                                <td class="text-center" colspan="7">ยังไม่มีคำสั่งซื้อ</td>
                            </tr>

                        <?php
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="POST" id="CustomerModalForm">
        <div class="modal fade" id="CustomerModal" tabindex="-1" aria-labelledby="CustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CustomerModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="EditModalInputID">
                        <div class="row">
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ">
                                    <label for="fname">ชื่อ</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล">
                                    <label for="lname">นามสกุล</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID">
                                    <label for="line">LINE ID</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์">
                                    <label for="phone">เบอร์โทรศัพท์</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน">
                                    <label for="password">รหัสผ่าน</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="ยืนยันรหัสผ่าน">
                                    <label for="cpassword">ยืนยันรหัสผ่าน</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            const CustomerModal = document.getElementById('CustomerModal')
            if (CustomerModal) {
                CustomerModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const fname = button.getAttribute('data-bs-fname')
                    const lname = button.getAttribute('data-bs-lname')
                    const email = button.getAttribute('data-bs-email')
                    const phone = button.getAttribute('data-bs-phone')
                    const line = button.getAttribute('data-bs-line')

                    // Update the modal's content.
                    const modalTitle = CustomerModal.querySelector('.modal-title')
                    const modalBodyInputID = CustomerModal.querySelector('#EditModalInputID')
                    const modalBodyInputFname = CustomerModal.querySelector('#fname')
                    const modalBodyInputLname = CustomerModal.querySelector('#lname')
                    const modalBodyInputEmail = CustomerModal.querySelector('#email')
                    const modalBodyInputPhone = CustomerModal.querySelector('#phone')
                    const modalBodyInputLine = CustomerModal.querySelector('#line')

                    if (id == 0) {
                        modalTitle.textContent = `เพิ่มบัญชีผู้ใช้งาน`
                        modalBodyInputID.value = 0
                        modalBodyInputFname.value = ""
                        modalBodyInputLname.value = ""
                        modalBodyInputEmail.value = ""
                        modalBodyInputPhone.value = ""
                        modalBodyInputLine.value = ""
                    } else {
                        modalTitle.textContent = `แก้ไขข้อมูลบัญชีผู้ใช้งาน ${fname} ${lname}`
                        modalBodyInputID.value = id
                        modalBodyInputFname.value = fname
                        modalBodyInputLname.value = lname
                        modalBodyInputEmail.value = email
                        modalBodyInputPhone.value = phone
                        modalBodyInputLine.value = line
                    }
                });
            }

            $('#CustomerModalForm').on("submit", function () {
                var unindexed_array = $(this).serializeArray();
                var indexed_array = {};

                $.map(unindexed_array, function(n, i){
                    indexed_array[n['name']] = n['value'];
                });

                const InputID = $("#EditModalInputID").val();
                const url = (InputID == 0) ? '<?=$API_URL;?>customer/add-customer' : '<?=$API_URL;?>customer/edit-customer';

                Swal.fire({
                    title: 'กำลังดำเนินการ...',
                    showDenyButton: false,
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: JSON.stringify(indexed_array),
                            contentType: "application/json", 
                            success: function(response) {
                                if (response.responseCode == "000") {
                                    location.reload();
                                } else {
                                    Swal.fire(
                                        'ล้มเหลว!',
                                        response.responseDesc,
                                        'error'
                                    )

                                    console.log(response.responseCode)
                                    console.log(response.responseDesc)
                                }
                            }
                        });
                    }
                });
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

                        fetch("<?=$API_URL;?>purchase/update-tracking", TrackingRequestOptions)
                        .then(response => response.json())
                        .then(
                            obj => {
                                if (obj.responseCode === "000") {
                                    fetch("<?=$API_URL;?>purchase/internal-update-purchase-status", StatusRequestOptions)
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

                        fetch("<?=$API_URL;?>purchase/internal-update-purchase-status", requestOptions)
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
        }, false);
    </script>

</body>

</html>