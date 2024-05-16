<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "promotions";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Promotions</h1>
                </div>
                <div class="col-auto">
                    <form action="#" method="POST" id="FormAddPromotion">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="ชื่อโปรโมชั่น" name="title" required aria-required="true">
                            <select name="type" id="type" class="form-control" required aria-required="true">
                                <option disabled selected>เลือกประเภทส่วนลด</option>
                                <option value="0">ลดราคาสินค้าเป็นยอด</option>
                                <option value="1">ลดราคาสินค้าเป็น %</option>
                                <option value="2">ลดค่าส่งเป็นยอด</option>
                                <option value="3">ส่งฟรี</option>
                            </select>
                            <input type="number" class="form-control" placeholder="มูลค่าส่วนลด" name="discount" required aria-required="true">
                            <input type="date" class="form-control" placeholder="วันที่เริ่มโปรโมชั่น" name="startDate" required aria-required="true">
                            <input type="date" class="form-control" placeholder="วันสิ้นสุดโปรโมชั่น" name="endDate" required aria-required="true">
                            <button class="btn btn-primary" type="submit">เพิ่มโปรโมชั่น</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th>ชื่อโปรโมชั่น</th>
                                <th class="px-4 fit">ประเภทส่วนลด</th>
                                <th class="px-4 fit">มูลค่าส่วนลด</th>
                                <th class="px-4 fit">สถานะ</th>
                                <th class="px-4 fit">วันที่เริ่มโปรโมชั่น</th>
                                <th class="px-4 fit">วันที่สิ้นสุดโปรโมชั่น</th>
                                <th class="fit">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            function checkDateRangeStatus($startDate, $endDate) {
                                $today = date("Y-m-d");
                                $inputStartDate = date("Y-m-d", strtotime($startDate));
                                $inputEndDate = date("Y-m-d", strtotime($endDate));
                            
                                if ($inputStartDate <= $today && $today <= $inputEndDate) {
                                    echo '<span class="w-100 badge text-bg-primary">กำลังใช้งาน</span>';
                                } elseif ($today < $inputStartDate) {
                                    echo '<span class="w-100 badge text-bg-warning">เร็วๆ นี้</span>';
                                } else {
                                    echo '<span class="w-100 badge text-bg-secondary">สิ้นสุด</span>';
                                }
                            }                           
                        
                            $apiUrl = "https://ecmapi.boonsiri.co.th/api/v1/promotion/list-promotion";
                            
                            $data = connect_api($apiUrl);

                            if ($data['responseCode'] == 000) {
                                foreach ($data['promotions'] as $promotion) {
                                    if ($promotion['type'] == 0) {
                                        $promotionTitle = '<span class="w-100 badge text-bg-success">ลดค่าสินค้า</span>';
                                        $PromotionType = number_format($promotion['discount'])." บาท";
                                    } elseif ($promotion['type'] == 1) {
                                        $promotionTitle = '<span class="w-100 badge text-bg-success">ลดค่าสินค้า</span>';
                                        $PromotionType = number_format($promotion['discount'])."%";
                                    } elseif ($promotion['type'] == 2) {
                                        $promotionTitle = '<span class="w-100 badge text-bg-warning">ลดค่าขนส่ง</span>';
                                        $PromotionType = number_format($promotion['discount'])." บาท";
                                    } else {
                                        $promotionTitle = '<span class="w-100 badge text-bg-warning">ลดค่าขนส่ง</span>';
                                        $PromotionType = "ส่งฟรี";
                                    }
                        ?>


                            <tr>
                                <th class="text-end"><?=$promotion['id'];?></th>
                                <td><?=$promotion['title'];?></td>
                                <td class="fit text-center"><?=$promotionTitle;?></td>
                                <td class="fit text-end"><?=$PromotionType;?></td>
                                <td class="fit"><?=checkDateRangeStatus($promotion['startDate'], $promotion['endDate']);?></td>
                                <td class="text-center"><?=date("d M Y", strtotime($promotion['startDate']));?></td>
                                <td class="text-center"><?=date("d M Y", strtotime($promotion['endDate']));?></td>
                                <td class="fit">
                                    <a class="btn btn-warning btn-tooltip" href="./promotion-apply-category.php?id=<?=$promotion['id'];?>" data-bs-title="ใช้งานโปรโมชั่น"><i class="fa-solid fa-tags"></i></a>
                                    <a class="btn btn-primary btn-tooltip" href="./promotion-products.php?id=<?=$promotion['id'];?>" data-bs-title="สินค้าโปรโมชั่น"><i class="fa-solid fa-list-check"></i></a>
                                    <button class="btn btn-info btn-tooltip" type="button" data-bs-toggle="modal" data-bs-target="#EditSheduleModal" data-bs-id="<?=$promotion['id'];?>" data-bs-start="<?=$promotion['startDate'];?>" data-bs-end="<?=$promotion['endDate'];?>" data-bs-title="แก้ไขกำหนดการ"><i class="fa-solid fa-calendar-days"></i></button>
                                    <a class="btn btn-outline-dark btn-tooltip" href="./promotion-orders.php?id=<?=$promotion['id'];?>" data-bs-title="คำสั่งซื้อ"><i class="fa-solid fa-cart-plus"></i></a>
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

    <div class="modal fade" id="EditSheduleModal" tabindex="-1" aria-labelledby="EditSheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditSheduleModalLabel">แก้ไขกำหนดการ Promotion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="FormEditPromotion">
                        <div class="input-group">
                            <input type="hidden" class="form-control" id="id" name="id" required aria-required="true">
                            <input type="date" class="form-control" id="startDate" placeholder="วันที่เริ่มโปรโมชั่น" name="startDate" required aria-required="true">
                            <input type="date" class="form-control" id="endDate" placeholder="วันสิ้นสุดโปรโมชั่น" name="endDate" required aria-required="true">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="SubmitEdit">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        $('#DataTables').DataTable({
            order: [
                [
                    4, 'DESC'
                ]
            ], 
            columnDefs: [
                { 
                    orderable: false, 
                    targets: 6
                }
            ],
        });

        const EditSheduleModal = document.getElementById('EditSheduleModal')
        if (EditSheduleModal) {
            EditSheduleModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const start = button.getAttribute('data-bs-start')
                const end = button.getAttribute('data-bs-end')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalBodyInputId = EditSheduleModal.querySelector('.modal-body #id')
                const modalBodyInputStartDate = EditSheduleModal.querySelector('.modal-body #startDate')
                const modalBodyInputEndDate = EditSheduleModal.querySelector('.modal-body #endDate')

                modalBodyInputId.value = id
                modalBodyInputStartDate.value = start
                modalBodyInputEndDate.value = end
            })
        }

        $("#SubmitEdit").click(function() {
            $("#FormEditPromotion").submit();
        });

        $("#FormEditPromotion").submit(function(e) {
            e.preventDefault(e);

            var unindexed_array = $(this).serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

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

            $.ajax({
                url: 'https://ecmapi.boonsiri.co.th/api/v1/promotion/update-promotion',
                type: 'POST',
                data: JSON.stringify(indexed_array),
                contentType: "application/json", 
                success: function(response) {
                    if (response.responseCode == "000") {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ!',
                            ``,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'บันทึกข้อมูลไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );
                    }
                }
            });
        });

        $("#FormAddPromotion").submit(function(e) {
            e.preventDefault(e);

            var unindexed_array = $(this).serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

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

            $.ajax({
                url: 'https://ecmapi.boonsiri.co.th/api/v1/promotion/insert-promotion',
                type: 'POST',
                data: JSON.stringify(indexed_array),
                contentType: "application/json", 
                success: function(response) {
                    if (response.responseCode == "000") {
                        Swal.fire(
                            'เพิ่มข้อมูลสำเร็จ!',
                            ``,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'เพิ่มข้อมูลไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );
                    }
                }
            });
        });
    </script>

</body>

</html>