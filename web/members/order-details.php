<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "orders";
        
        require_once "../head.php";

        $id = $_GET['id'];

        $APIRequest = [
            'id' => $id,
        ];

        $Response = connect_api("https://ecmapi.boonsiri.co.th/api/v1/purchase/get-purchase", $APIRequest);

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
                                    <th class="fit text-center">ราคาต่อหน่วย</th>
                                    <th class="fit text-center">ราคาทั้งหมด</th>
                                    <th class="fit">เครื่องมือ</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $count = 1;

                                foreach ($OrderData['listItem'] as $items) {
                                    $thumbnail = (file_exists("products/".$items['image'])) ? rootURL()."products/".$items['image'] : rootURL()."images/logo.png";
                                    $placeholder = (file_exists("products/".$items['image'])) ? "" : "thumbnail-placeholder";
                                    $quantity = ($items['uomCode']) ? $items['uomCode'] : "ชิ้น";
                            ?>

                                <tr>
                                    <th class="text-end"><?=$count;?></th>
                                    <td class="text-center">
                                        <img src="<?=$thumbnail;?>" alt="" class="product-thumbnail rounded-3" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                    </td>
                                    <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$items['title'];?>"><?=$items['title'];?></p></td>
                                    <td class="fit text-end"><?=$items['amount'];?> <?=$quantity;?></td>
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

                                    <?php
                                        if (($items['discountType'] !== null) && ($items['discountType'] == 0 || $items['discountType'] == 1)) {
                                    ?>

                                    <td class="fit text-end">
                                        <p class="mb-0" id="EachPrice<?=$items['id'];?>">
                                            <small class="text-decoration-line-through text-muted">
                                                <?=number_format($items['productPrice']);?> บาท
                                            </small>
                                            <br class="d-none d-md-block">
                                            <?=number_format($items['eachLastPrice']);?> บาท
                                        </p>
                                    </td>
                                    <td class="fit text-end">
                                        <p class="mb-0 w-100 text-theme-4" id="LastPrice<?=$items['id'];?>">
                                            <small class="text-decoration-line-through text-muted">
                                                <?=number_format($items['productPrice'] * $items['amount']);?> บาท
                                            </small>
                                            <br class="d-none d-md-block">
                                            <?=number_format($items['lastPrice']);?> บาท 
                                        </p>
                                    </td>

                                    <?php
                                        } else {
                                    ?>

                                    <td class="fit text-end">
                                        <p class="mb-0 text-dark" id="EachPrice<?=$items['id'];?>">
                                            <?=number_format($items['productPrice']);?> บาท
                                        </p>
                                    </td>
                                    <td class="fit text-end">
                                        <p class="mb-0 text-dark w-100" id="LastPrice<?=$items['id'];?>"><?=number_format($items['lastPrice']);?> บาท</p>
                                    </td>

                                    <?php
                                        }
                                    ?>

                                    <td class="fit text-center">
                                        <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$items['productId'];?>/<?=str_replace(" ", "-", $items['title']);?>/" class="btn btn-primary rounded-0 btn-edit btn-tooltip" data-bs-title="ดูรายละเอียดสินค้า"><i class="fa-solid fa-eye"></i></a>
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

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

    <script>
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