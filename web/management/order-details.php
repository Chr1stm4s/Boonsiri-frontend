<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "orders";

        require_once "./head.php";

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

        $BackBTN = (@$_GET['customer']) ? "./customer-purchase.php?id=".$_GET['customer'] : "./orders.php";
    ?>

    <style>
        #PreviewThumbnailModal .btn-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
        }
    </style>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="<?=$BackBTN;?>" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">Orders - <?=$OrderData['orderNo'];?></h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover table-striped mb-0" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th class="fit text-center">ภาพสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th class="text-center">จำนวน</th>
                                <th class="fit">ราคาต่อชิ้น</th>
                                <th class="fit">ค่าจัดส่ง</th>
                                <th class="fit">ราคารวมทั้งหมด</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $count = 1;

                            foreach ($OrderData['listItem'] as $items) {
                                $thumbnail = (file_exists("../products/".$items['image'])) ? rootURL()."products/".$items['image'] : rootURL()."images/logo.png";
                                $placeholder = (file_exists("../products/".$items['image'])) ? "" : "thumbnail-placeholder";
                                $quantity = ($items['uomCode']) ? $items['uomCode'] : "ชิ้น";
                        ?>

                            <tr>
                                <th class="text-end"><?=$count;?></th>
                                <td class="text-center">
                                    <img src="<?=$thumbnail;?>" alt="" class="rounded-3" height="40" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                </td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$items['title'];?>"><?=$items['title'];?></p></td>
                                <td class="fit text-end"><?=$items['amount'];?> <?=$quantity;?></td>
                                <td class="fit text-end"><?=number_format($items['productPrice']);?> บาท</td>
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
                                <td class="fit text-end"><?=number_format($items['lastPrice'] + $items['lastShippingPrice']);?> บาท</td>
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

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');
        }, false);
    </script>

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