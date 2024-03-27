<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "orders";

        require_once "./head.php";

        $id = $_GET['id'];

        $RequestDataAPI = [
            "id" => $id
        ];

        $ResponseDataAPI = connect_api("https://ecmapi.boonsiri.co.th/api/v1/promotion/get-promotion", $RequestDataAPI);

        $Promotion = $ResponseDataAPI['promotion'];
    ?>

    <style>
        .product-thumbnail {
            height: 50px;
            cursor: pointer;
        }
    </style>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Promotion : <?=$Promotion['title'];?></h1>
                </div>
                <!-- <div class="col-auto">
                    <input type="date" class="form-control" id="ReportStartDate">
                </div>
                <div class="col-auto px-0">
                    <input type="date" class="form-control" id="ReportEndDate">
                </div> -->
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" id="Export">Export</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th>รูปภาพ</th>
                                <th>SKU</th>
                                <th>ชื่อสินค้า</th>
                                <th class="fit">จำนวนที่สั่งซื้อ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiRequest = [
                                "promotionId" => $id, 
                                "purchaseStatus" => 6
                            ];

                            $apiUrl = "https://ecmapi.boonsiri.co.th/api/v1/promotion/list-product-promotion";
                            
                            $data = connect_api($apiUrl, $apiRequest);

                            if ($data['responseCode'] == 000) {
                                $i = 1;

                                foreach ($data['promotions'] as $item) {
                                    $image = ($item['thumbnail'] && file_exists("../products/".$item['thumbnail'])) ? "../products/".$item['thumbnail'] : "../images/logo.png";
                                    // $quantity = ($item['uomCode']) ? $item['uomCode'] : "ชิ้น";
                        ?>

                            <tr>
                                <th class="text-end"><?=$i;?></th>
                                <td class="fit text-center">
                                    <img src='<?=$image;?>' class='product-thumbnail' data-bs-toggle='modal' data-bs-target='#ThumbnailModal' data-bs-id='<?=$item['id'];?>' data-bs-img='<?=$image;?>' data-bs-title='<?=$item['title'];?>'>
                                </td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$item['itemCode'];?>"><?=$item['itemCode'];?></p></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$item['productTitle'];?>"><?=$item['productTitle'];?></p></td>
                                <td class="fit text-center"><?=$item['amount'];?> <?//=$quantity;?></td>
                            </tr>

                        <?php
                                    $i++;
                                }
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="ThumbnailModal" tabindex="-1" aria-labelledby="ThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" class="w-100 mb-4 image-preview" id="ThumbnailModalPreview">
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#DataTables').DataTable( {
                // columnDefs: [
                //     { 
                //         orderable: false, 
                //         targets: -1 
                //     }
                // ],
                order: [
                    [
                        0, 'asc'
                    ]
                ]
            } );
        }, false);

        const ThumbnailModal = document.getElementById('ThumbnailModal');

        if (ThumbnailModal) {
            ThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const img = button.getAttribute('data-bs-img')

                const ThumbnailModalPreview = ThumbnailModal.querySelector('#ThumbnailModalPreview')
                ThumbnailModalPreview.src = img
            })
        }

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
                "./generate-promotions.php", 
                {
                    "id": <?=$id;?>, 
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
    </script>

</body>

</html>