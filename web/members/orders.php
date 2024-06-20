<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "member";
        
        require_once "../head.php";
    ?>

    <style>
        .img-review {
            height: 60px;
            padding: 0.5rem;
        }

        .rating {
            display: flex;
            flex-direction: row-reverse;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 30px;
            color: #aaa;
            cursor: pointer;
        }

        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #ffcc00;
        }

        .rating input:checked ~ label:hover,
        .rating input:checked ~ label:hover ~ label {
            color: #ccc;
        }
    </style>

</head>

<body>
    
    <?php require_once "../header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>สมาชิก/" class="text-theme-1">สมาชิก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">คำสั่งซื้อ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row my-4">
                <div class="col-12 col-lg my-auto text-center text-lg-start mb-4 mb-lg-0">
                    <h1 class="mb-0">รายการคำสั่งซื้อ</h1>
                </div>
                <div class="col-auto mx-auto">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item mx-1" role="presentation">
                            <button class="nav-link active" id="pills-purchase-tab" data-bs-toggle="pill" data-bs-target="#pills-purchase" type="button" role="tab" aria-controls="pills-purchase" aria-selected="true">คำสั่งซื้อปกติ</button>
                        </li>
                        <li class="nav-item mx-1" role="presentation">
                            <button class="nav-link" id="pills-pre-order-tab" data-bs-toggle="pill" data-bs-target="#pills-pre-order" type="button" role="tab" aria-controls="pills-pre-order" aria-selected="false">คำสั่งซื้อ Pre-order</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-purchase" role="tabpanel" aria-labelledby="pills-purchase-tab" tabindex="0">
                            <div class="table-responsive">
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
                                            '<span class="badge text-bg-danger w-100">มีสินค้าแจ้งเคลม</span>', 
                                            '<span class="badge text-bg-dark w-100">เคลมแล้ว</span>', 
                                            '<span class="badge text-bg-success w-100">เสร็จสมบูรณ์</span>', 
                                            '<span class="badge text-bg-secondary w-100">เกินกำหนดชำระ</span>'
                                        );

                                        $APIRequest = [
                                            'customerId' => $_SESSION['id'],
                                        ];

                                        $Response = connect_api("{$API_URL}purchase/list-purchase", $APIRequest);

                                        if ($Response['responseCode'] == 000 && $Response['purchases']) {
                                            foreach ($Response['purchases'] as $OrderData) {
                                    ?>

                                        <tr>
                                            <th class="text-end"><?=($OrderData['shippingType'] == 2) ? '<i class="fa-solid fa-shop p-2 rounded-2 bg-theme-2 text-white btn-tooltip" data-bs-title="รับสินค้าเองที่ร้าน"></i>' : ""; ?><?=$OrderData['orderNo'];?></th>
                                            <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="คุณ <?=$OrderData['fname'];?> <?=$OrderData['lname'];?>">คุณ <?=$OrderData['fname'];?> <?=$OrderData['lname'];?></p></td>
                                            <td><?=$OrderData['phone'];?></td>
                                            <td class="fit"><?=$badge[$OrderData['status']];?></td>
                                            <td class="fit text-end"><?=number_format($OrderData['totalPrice']);?> บาท</td>
                                            <td class="fit text-center"><p class="mb-0 btn-tooltip w-100" data-bs-title="<?=date("d M Y", strtotime($OrderData['added']));?>"><?=date("d M", strtotime($OrderData['added']));?> <?=date("Y", strtotime($OrderData['added'])) + 543;?></p></td>
                                            <td class="fit">
                                                <button type="button" class="btn btn-light rounded-0 border-dark btn-details btn-tooltip" data-bs-title="ดูรายเอียดคำสั่งซื้อ" data-id="<?=$OrderData['id'];?>"><i class="fa-solid fa-list-check"></i></button>

                                                <?php
                                                    if ($OrderData['status'] == 1) {
                                                ?>

                                                <button type="button" class="btn btn-primary rounded-0 btn-edit btn-tooltip btn-payment" data-id="<?=$OrderData['id'];?>" data-bs-title="ชำระเงิน"><i class="fa-regular fa-credit-card"></i></button>

                                                <?php
                                                    } elseif ($OrderData['status'] == 3 && $OrderData['shippingType'] == 2) {
                                                ?>
                
                                                <button type="button" class="btn btn-success rounded-0 btn-tooltip btn-received" data-id="<?=$OrderData['id'];?>" data-bs-title="ยืนยันรับสินค้า"><i class="fa-solid fa-check"></i></button>
                
                                                <?php
                                                    } elseif ($OrderData['status'] == 5) {
                                                ?>
            
                                                <button type="button" class="btn btn-success rounded-0 btn-tooltip btn-received" data-id="<?=$OrderData['id'];?>" data-bs-title="ยืนยันรับสินค้า"><i class="fa-solid fa-check"></i></button>
                                                <button type="button" class="btn btn-outline-primary rounded-0 btn-tooltip" data-id="<?=$OrderData['id'];?>" data-bs-title="ดูเลขขนส่งสินค้า" data-bs-toggle="modal" data-bs-target="#TrackingModal" data-bs-tracking="<?=$OrderData['tracking'];?>"><i class="fa-solid fa-truck-fast"></i></button>
            
                                                <?php
                                                    } elseif ($OrderData['status'] == 6) {
                                                ?>
    
                                                <button type="button" class="btn btn-warning rounded-0 btn-tooltip" data-bs-id="<?=$OrderData['id'];?>" data-bs-title="รีวิวคำสั่งซื้อ" data-bs-toggle="modal" data-bs-target="#ReviewModal"><i class="fa-solid fa-message"></i></button>
                                                <button type="button" class="btn btn-danger rounded-0 btn-tooltip btn-claim" data-id="<?=$OrderData['id'];?>" data-bs-title="แจ้งเคลมสินค้า"><i class="fa-solid fa-heart-crack"></i></button>

                                                <?php
                                                    } elseif ($OrderData['status'] == 8) {
                                                ?>
    
                                                <button type="button" class="btn btn-danger rounded-0 btn-tooltip btn-claim" data-id="<?=$OrderData['id'];?>" data-bs-title="แจ้งเคลมสินค้า"><i class="fa-solid fa-heart-crack"></i></button>

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
                        <div class="tab-pane fade" id="pills-pre-order" role="tabpanel" aria-labelledby="pills-pre-order-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th class="fit">ลำดับ</th>
                                            <th>ชื่อสินค้า</th>
                                            <th class="text-center">ราคา</th>
                                            <th class="fit text-center">จำนวน</th>
                                            <th class="text-center">วันที่สั่งซื้อ</th>
                                            <th class="fit">อัพเดตล่าสุด</th>
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
                                            '<span class="badge text-bg-danger w-100">มีสินค้าแจ้งเคลม</span>', 
                                            '<span class="badge text-bg-dark w-100">เคลมแล้ว</span>', 
                                            '<span class="badge text-bg-success w-100">เสร็จสมบูรณ์</span>', 
                                            '<span class="badge text-bg-secondary w-100">เกินกำหนดชำระ</span>'
                                        );

                                        $APIRequest = [
                                            'customerId' => $_SESSION['id'],
                                        ];

                                        $Response = connect_api("{$API_URL}preorder/list-preorder", $APIRequest);

                                        $id = 1;

                                        if ($Response['responseCode'] == 000 && $Response['preOrders']) {
                                            foreach ($Response['preOrders'] as $OrderData) {
                                                $quantity = ($OrderData['uomCode']) ? $OrderData['uomCode'] : "ชิ้น";
                                    ?>

                                        <tr>
                                            <th class="text-end"><?=$id;?></th>
                                            <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$OrderData['title'];?>"><?=$OrderData['title'];?></p></td>
                                            <td class="fit text-end"><?=number_format($OrderData['price']);?> บาท</td>
                                            <td class="fit text-center"><?=$OrderData['amount'];?> <?=$quantity;?></td>
                                            <td class="fit text-center"><p class="mb-0 btn-tooltip" data-bs-title="<?=date("d M Y", strtotime($OrderData['added']));?>"><?=date("d M", strtotime($OrderData['added']));?> <?=date("Y", strtotime($OrderData['added'])) + 543;?></p></td>
                                            <td class="fit text-center"><?=time_ago("TH", $OrderData['updates']);?></td>
                                            <td class="fit text-center">
                                                <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$OrderData['productId'];?>/<?=str_replace(" ", "-", $OrderData['title']);?>/" class="btn btn-primary rounded-0 btn-edit btn-tooltip" data-bs-title="ดูรายละเอียดสินค้า"><i class="fa-solid fa-eye"></i></a>
                                            </td>
                                        </tr>

                                    <?php
                                                $id++;
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
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="TrackingModal" tabindex="-1" aria-labelledby="TrackingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="TrackingModalLabel">เลขติดตามการจัดส่ง</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="เลขติดตามการจัดส่ง" aria-label="เลขติดตามการจัดส่ง" id="trackingInput" aria-describedby="trackingInputCopy">
                        <button class="btn btn-outline-secondary" type="button" id="trackingInputCopy"><i class="fa-solid fa-copy"></i> &nbsp;คัดลอก</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <form id="SubmitReviewForm" enctype="multipart/form-data">
        <div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ReviewModalLabel">New message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="purchaseId" id="purchaseId">
                        <label for="quality" class="col-form-label">คุณภาพสินค้า:</label>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <div class="rating">
                                    <input type="radio" id="QualityStar5" name="quality" value="5"><label for="QualityStar5"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="QualityStar4" name="quality" value="4"><label for="QualityStar4"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="QualityStar3" name="quality" value="3"><label for="QualityStar3"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="QualityStar2" name="quality" value="2"><label for="QualityStar2"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="QualityStar1" name="quality" value="1"><label for="QualityStar1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                        </div>
                        <label for="quality" class="col-form-label">บริการผู้ขาย:</label>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <div class="rating">
                                    <input type="radio" id="ServicesStar5" name="services" value="5"><label for="ServicesStar5"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="ServicesStar4" name="services" value="4"><label for="ServicesStar4"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="ServicesStar3" name="services" value="3"><label for="ServicesStar3"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="ServicesStar2" name="services" value="2"><label for="ServicesStar2"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="ServicesStar1" name="services" value="1"><label for="ServicesStar1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                        </div>
                        <label for="quality" class="col-form-label">บริการผู้ส่ง:</label>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <div class="rating">
                                    <input type="radio" id="DeliveryStar5" name="delivery" value="5"><label for="DeliveryStar5"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="DeliveryStar4" name="delivery" value="4"><label for="DeliveryStar4"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="DeliveryStar3" name="delivery" value="3"><label for="DeliveryStar3"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="DeliveryStar2" name="delivery" value="2"><label for="DeliveryStar2"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="DeliveryStar1" name="delivery" value="1"><label for="DeliveryStar1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="col-form-label">ข้อความ:</label>
                            <textarea class="form-control" id="message" name="message" required aria-required="true"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">อัปโหลดรูปภาพ</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="review[]" id="image" multiple accept="image/*">
                                <label class="input-group-text" for="image">เลือกรูปภาพ</label>
                            </div>
                        </div>
                        <div class="gallery mb-4"></div>
                        <div class="mb-3">
                            <label for="video" class="form-label">อัปโหลดวิดีโอ (รองรับเฉพาะ .MP4 ไม่เกิน 30 วินาที)</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="video" id="video" accept="video/mp4">
                                <label class="input-group-text" for="video">เลือกวิดีโอ</label>
                            </div>
                        </div>
                        <p class="my-3 text-danger">หากรีวิวคำสั่งซื้อแล้ว จะไม่สามารถกดเคลมสินค้าได้ กรุณาตรวจสอบสินค้าก่อนรีวิวคำสั่งซื้อ</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">ส่งรีวิว</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

    <script>
        $("#PreOrder").hide();

        $("#trackingInputCopy").click(function(){
            var copyText = $("#trackingInput");
            copyText.select();
            document.execCommand("copy");

            Swal.fire(
                'คัดลอกสำเร็จ!',
                '',
                'success'
            );
        });

        $(".btn-received").click(function() {
            const id = $(this).data("id");

            Swal.fire({
                title: `คุณได้รับสินค้าแล้วใช่ไหม?`,
                icon: 'info',
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
                        "status": 6
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
                                    `ยืนยันรับสินค้านี้สำเร็จ!`,
                                    ``,
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    `ยืนยันรับสินค้านี้ไม่สำเร็จ!`,
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

        $(".btn-claim").on("click", function() {
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

            const id = $(this).data("id");
            
            window.location.replace(`<?=rootURL();?>แจ้งเคลมสินค้า/${id}/`);
        });

        $(".btn-payment").on("click", function() {
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

            const id = $(this).data("id");
            
            window.location.replace(`<?=rootURL();?>ชำระเงิน/${id}/`);
        });

        $(".btn-details").on("click", function() {
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

            const id = $(this).data("id");
            
            window.location.replace(`<?=rootURL();?>รายเอียดคำสั่งซื้อ/${id}/`);
        });

        $(".purchase-type").click(function() {
            $(".purchase-type").removeClass("btn-primary");
        });

        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {
                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img class="img-review">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };

            $('#image').on('change', function() {
                imagesPreview(this, 'div.gallery');
            });
        });

        const ReviewModal = document.getElementById('ReviewModal')
        if (ReviewModal) {
            ReviewModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalTitle = ReviewModal.querySelector('.modal-title')
                const modalPurchaseId = ReviewModal.querySelector('#purchaseId')

                modalTitle.textContent = `รีวิวคำสั่งซื้อเลขที่ #${id}`
                modalPurchaseId.value = id
            });
        }

        const TrackingModal = document.getElementById('TrackingModal')
        if (TrackingModal) {
            TrackingModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const tracking = button.getAttribute('data-bs-tracking')
                
                const modalTrackingId = TrackingModal.querySelector('#trackingInput')

                modalTrackingId.value = tracking
            });
        }

        $('#SubmitReviewForm').on("submit", function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);

            Swal.fire({
                title: 'กำลังส่งรีวิว...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: '<?=rootURL();?>action/send-review/',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'ขอบคุณสำหรับการรีวิว!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else if (response == "sending") {
                        Swal.fire(
                            'ไม่สามารถส่งข้อมูลได้!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    } else if (response == "upload") {
                        Swal.fire(
                            'ไม่สามารถส่งไฟล์ได้!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    } else {
                        Swal.fire(
                            'ส่งข้อมูลล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'ส่งข้อมูลล้มเหลว!',
                        'กรุณาติดต่อเจ้าหน้าที่',
                        'error'
                    );

                    console.log(e)
                }
            });
        });
    </script>

</body>

</html>