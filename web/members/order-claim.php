<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "claim";
        
        require_once "../head.php";

        $id = $_GET['id'];

        $APIRequest = [
            'id' => $id,
        ];

        $Response = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/purchase/get-purchase", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $OrderData = $Response['purchase'];
        } else {
            exit();
        }
    ?>

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
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>คำสั่งซื้อ/" class="text-theme-1">คำสั่งซื้อ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">รายการสินค้า</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row my-4">
                <div class="col-auto my-auto">
                    <a href="<?=rootURL();?>คำสั่งซื้อ/" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0">รายการสินค้า - #<?=$id;?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="fit">ลำดับ</th>
                                    <th class="fit text-center">ภาพสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="fit">ค่าจัดส่ง</th>
                                    <th class="text-center">ราคา</th>
                                    <th class="fit text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $count = 1;

                                foreach ($OrderData['listItem'] as $items) {
                                    $thumbnail = (file_exists("products/".$items['image'])) ? rootURL()."products/".$items['image'] : rootURL()."images/logo.png";
                                    $placeholder = (file_exists("products/".$items['image'])) ? "" : "thumbnail-placeholder";
                            ?>

                                <tr>
                                    <th class="text-end"><?=$count;?></th>
                                    <td class="text-center">
                                        <img src="<?=$thumbnail;?>" alt="" class="product-thumbnail rounded-3" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                    </td>
                                    <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$items['title'];?>"><?=$items['title'];?></p></td>
                                    <td class="fit text-end"><?=$items['amount'];?> ชิ้น</td>
                                    <td class="fit text-end">

                                    <?php
                                        if ($items['shippingPrice']) {
                                    ?>

                                        <?=number_format($items['shippingPrice']);?> บาท

                                    <?php
                                        } else {
                                    ?>

                                        ส่งฟรี

                                    <?php
                                        }
                                    ?>

                                    </td>
                                    <td class="fit text-end"><?=number_format($items['productPrice']);?> บาท</td>
                                    <td class="text-center fit">
                                        <!-- <button type="button" class="btn btn-dark rounded-0 btn-tooltip btn-video"><i class="fa-solid fa-heart-crack"></i></button> -->

                                        <?php
                                            if ($items['caseId'] == 0) {
                                        ?>

                                        <button type="button" class="btn btn-danger rounded-0 btn-tooltip btn-claim" data-bs-id="<?=$items['id'];?>" data-bs-title="แจ้งเคลมสินค้า" data-bs-toggle="modal" data-bs-target="#ClaimModal"><i class="fa-solid fa-heart-crack"></i></button>

                                        <?php
                                            } else {
                                        ?>

                                        <button type="button" class="btn btn-outline-primary rounded-0 btn-tooltip btn-chat" data-id="<?=$items['caseId'];?>" data-bs-title="สถานะการเคลม"><i class="fa-solid fa-message"></i></button>

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
                        <p class="response"></p>
                    </div>
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

    <form id="SubmitClaimForm" enctype="multipart/form-data">
        <div class="modal fade" id="ClaimModal" tabindex="-1" aria-labelledby="ClaimModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ClaimModalLabel">แจ้งเคลมสินค้า</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="purchaseId" id="purchaseId" value="<?=$id;?>">
                        <input type="hidden" name="itemId" id="itemId">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">เหตุผลที่เคลม:</label>
                            <input type="text" class="form-control" id="title" name="title" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">รายละเอียดการเคลม:</label>
                            <textarea class="form-control" id="description" name="description" required aria-required="true"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">รูปสินค้าที่มีปัญหา</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="claim[]" id="image" multiple required aria-required="true" accept="image/*">
                                <label class="input-group-text" for="image">Upload</label>
                            </div>
                        </div>
                        <div class="gallery"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">แจ้มเคลม</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

    <script>
        $(".btn-video").click(function() {
            $.post(
                "<?=rootURL();?>video.php",
                "", 
                function(response) {
                    $(".response").text(response);
                }
            )
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

        const ClaimModal = document.getElementById('ClaimModal')
        if (ClaimModal) {
            ClaimModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const itemId = ClaimModal.querySelector('#itemId')

                itemId.value = id
            })
        }

        $(".btn-chat").on("click", function() {
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
            
            window.location.replace(`<?=rootURL();?>สถานะการเคลม/${id}/`);
        });

        $('#SubmitClaimForm').on("submit", function(e) {
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
                url: '<?=rootURL();?>action/send-claim/',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'ขอบคุณสำหรับการแจ้ง!',
                            'เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด',
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

                    console.log(response)
                }
            });
        });
    </script>

</body>

</html>