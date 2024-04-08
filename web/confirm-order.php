<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "order";
        
        require_once "./head.php";

        $id = $_GET['id'];

        $request = [
            'id' => $id
        ];

        $data = connect_api("https://ecmapi.boonsiri.co.th/api/v1/purchase/get-purchase", $request);

        if ($data['responseCode'] != 000) {
            redirect(rootURL());
        } elseif ($data['purchase']['status'] != 1) {
            redirect(rootURL());
        }

        $PurchaseData = $data['purchase'];
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ยืนยันคำสั่งซื้อ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md">
                    <div class="card border-0">
                        <div class="card-body">
                            <h3 class="card-title ">รายการสินค้าในตะกร้า</h3>
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th class="fit">ลำดับ</th>
                                            <th class="fit text-center">ภาพสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th class="text-center">จำนวน</th>
                                            <th class="fit">ราคาสินค้าต่อหน่วย</th>
                                            <th class="fit">ราคาสินค้าทั้งหมด</th>
                                            <th class="fit">ค่าจัดส่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $count = 1;

                                        foreach ($PurchaseData['listItem'] as $cart) {
                                            $thumbnail = (file_exists("products/".$cart['image'])) ? rootURL()."products/".$cart['image'] : rootURL()."images/logo.png";
                                            $placeholder = (file_exists("products/".$cart['image'])) ? "" : "thumbnail-placeholder";
                                    ?>

                                        <tr>
                                            <th class="text-end"><?=$count;?></th>
                                            <td class="text-center">
                                                <img src="<?=$thumbnail;?>" alt="" class="product-thumbnail rounded-3" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                            </td>
                                            <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$cart['title'];?>"><?=$cart['title'];?></p></td>
                                            <td class="fit text-end"><?=$cart['amount'];?> <?=(@$cart['uomCode']) ? $cart['uomCode'] : "ชิ้น"; ?></td>
                                            <td class="fit text-end"><?=number_format($cart['eachLastPrice']);?> บาท</td>
                                            <td class="fit text-end"><?=number_format($cart['lastPrice']);?> บาท</td>
                                            <td class="fit text-end">
                                                
                                                <?php
                                                    if ($cart['shippingPrice']) {
                                                ?>

                                                <?=number_format($cart['shippingPrice']);?> บาท

                                                <?php
                                                    } else {
                                                ?>

                                                ส่งฟรี

                                                <?php
                                                    }
                                                ?>

                                            </td>
                                        </tr>

                                    <?php
                                            $count++;
                                        }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 col-lg-5 ms-auto">
                    <div class="card h-100 border-0">
                        <div class="card-body">
                            <h3 class="card-title ">ข้อมูลจัดส่ง</h3>
                            <table class="table table-hover table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="py-0 fit text-end">ชื่อผู้รับสินค้า : </th>
                                        <td class="py-0"><?=$PurchaseData['addressProfileFname'];?> <?=$PurchaseData['addressProfileLname'];?></td>
                                    </tr>
                                    <tr>
                                        <th class="py-0 fit text-end align-top" >ที่อยู่จัดส่ง : </th>
                                        <td class="py-0"><?=$PurchaseData['addressMain'];?> <?=$PurchaseData['addressSub'];?> <?=$PurchaseData['addressProfileDistrictName'];?> <?=$PurchaseData['addressProfileAmphurName'];?></td>
                                    </tr>
                                    <tr>
                                        <th class="py-0 fit text-end">จังหวัด : </th>
                                        <td class="py-0"><?=$PurchaseData['addressProfileProvinceName'];?></td>
                                    </tr>
                                    <tr>
                                        <th class="py-0 fit text-end">รหัสไปรษณีย์ : </th>
                                        <td class="py-0"><?=$PurchaseData['addressProfilePostcode'];?></td>
                                    </tr>
                                    <tr>
                                        <th class="py-0 fit text-end">เบอร์โทรศัพท์ : </th>
                                        <td class="py-0"><?=$PurchaseData['addressProfilePhone'];?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer bg-white">
                            <table class="table table-hover table-borderless mb-0 text-end">
                                <tbody>
                                    <tr>
                                        <th class="py-0">รวมส่วนลดค่าจัดส่ง</th>
                                        <td class="py-0"><?=number_format($PurchaseData['totalDiscountShipping']);?> บาท</td>
                                    </tr>
                                    <tr>
                                        <th class="py-0">รวมค่าจัดส่ง</th>
                                        <td class="py-0"><?=number_format($PurchaseData['totalShippingPrice']);?> บาท</td>
                                    </tr>
                                    <tr>
                                        <th class="py-0">รวมส่วนลดจากโปรโมชั่น</th>
                                        <td class="py-0"><?=number_format($PurchaseData['totalDiscount']);?> บาท</td>
                                    </tr>
                                    <tr class="fs-5">
                                        <th class="py-0">ราคาทั้งหมด</th>
                                        <td class="py-0"><?=number_format($PurchaseData['lastTotalPrice']);?> บาท</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-12 col-md mb-4 mb-md-0">
                    <h5 class="text-danger">*โปรดอ่านก่อนยืนยันคำสั่งซื้อ และชำระค่าสินค้า*</h5>
                    <p class="fw-bold">เงื่อนไขการจัดส่ง</p>
                    <ol>
                        <li>กรณียืนยันคำสั่งซื้อและชำระเงิน ภายใน 8.30 น. สินค้าจะถูกจัดส่งไม่เกิน 1-2 วัน นับจากวันชำระเงิน</li>
                        <li>กรณียืนยันคำสั่งซื้อและชำระเงิน หลังจาก 8.30 น. สินค้าจะถูกจัดส่งไม่เกิน 2-3 วัน นับจากวันชำระเงิน</li>
                    </ol>
                    <small>หลังจากยืนยันคำสั่งซื้อและชำระเงินเรียบร้อย ลูกค้าสามารถติดตามสถานะการจัดส่งได้จาก เมนู <a href="<?=rootURL();?>คำสั่งซื้อ/">"คำสั่งซื้อ"</a> > "สถานะคำสั่งซื้อ"<br>หากต้องการสอบถามเพิ่มเติม ติดต่อ call center : <a href="tel:094-698-5555">094-698-5555</a></small>
                </div>
                <div class="col-12 col-md-auto text-center text-md-end">
                    <button type="button" class="btn btn-theme-2 rounded-0 px-3" id="MakePayment">ชำระเงิน <i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="PreviewThumbnailModal" tabindex="-1" aria-labelledby="PreviewThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" class="w-100" id="PreviewThumbnailModalIMG">
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script>
        $("#MakePayment").click(function() {
            Swal.fire({
                title: 'กำลังดำเนินการ...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();

                    $.ajax({
                        type: "POST",  
                        url: "<?=rootURL();?>action/create-payment/", 
                        data: {
                            id: <?=$id;?>
                        }, 
                        success: function(response) {  
                            if (response == "success") {
                                window.location.replace("<?=rootURL();?>ชำระเงิน/<?=$id;?>/");
                            } else {
                                Swal.fire(
                                    'ดำเนินการไม่สำเร็จ!',
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );

                                console.log(response);
                            }
                        }
                    });
                }
            });
        });

        const PreviewThumbnailModal = document.getElementById('PreviewThumbnailModal')
        if (PreviewThumbnailModal) {
            PreviewThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const img = button.getAttribute('data-bs-img')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const PreviewThumbnailModalIMG = PreviewThumbnailModal.querySelector('#PreviewThumbnailModalIMG')

                PreviewThumbnailModalIMG.src = img
            })
        }
    </script>

</body>

</html>