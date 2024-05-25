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
                <div class="col-auto my-auto">
                    <a href="./orders.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">Pre-orders</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับคำสั่งซื้อ</th>
                                <th class="fit text-center">ภาพสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>ชื่อผู้สั่งซื้อ</th>
                                <th class="fit">เบอร์ติดต่อ</th>
                                <th class="fit text-center">สาขา</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-end">ราคา</th>
                                <th class="fit text-center">จำนวน</th>
                                <th class="fit">วันที่สั่งซื้อ</th>
                                <th class="fit">แก้ไขล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "$API_Link/v1/preorder/list-preorder";
                            
                            $data = connect_api($apiUrl);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['preOrders'] as $preOrder) {
                                    $ProductDataAPIRequest = [
                                        "id" => $preOrder['customerId']
                                    ]; 

                                    $ProductDataAPIResponse = connect_api("$API_Link/v1/customer/get-customer-by-id", $ProductDataAPIRequest);

                                    if ($ProductDataAPIResponse['responseCode'] == "000") {
                                        $customer = $ProductDataAPIResponse['point'];

                                        if ($preOrder['status'] == 1) {
                                            $status = '<span class="badge text-bg-light w-100">รอแอดมินสรุปยอด</span>';
                                        } elseif ($preOrder['status'] == 2) {
                                            $status = '<span class="badge text-bg-success w-100">สรุปยอดแล้ว</span>';
                                        } else {
                                            $status = '<span class="badge text-bg-secondary w-100">รอแอดมินสรุปยอด</span>';
                                        }
                                    }

                                    $thumbnail = (file_exists("products/".$preOrder['image'])) ? rootURL()."products/".$preOrder['image'] : rootURL()."images/logo.png";
                                    $quantity = ($preOrder['uomCode']) ? $preOrder['uomCode'] : "ชิ้น";
                        ?>

                            <tr>
                                <th class="text-end"><?=$i;?></th>
                                <td class="text-center">
                                    <img src="<?=$thumbnail;?>" alt="" class="rounded-3" height="40" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                </td>
                                <th><?=$preOrder['title'];?></th>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$customer['fname'];?> <?=$customer['lname'];?>"><?=$customer['fname'];?> <?=$customer['lname'];?></p></td>
                                <td class="fit"><a href="tel:<?=$customer['phone'];?>"><?=$customer['phone'];?></a></td>
                                <td class="text-center"><?=$preOrder['whsCode'];?></td>
                                <td class="fit text-end"><?=$status;?></td>
                                <td class="fit text-end"><?=number_format($preOrder['price']);?> บาท</td>
                                <td class="fit text-center"><?=$preOrder['amount'];?> <?=$quantity;?></td>
                                <td class="fit text-center"><?=date("d M Y", strtotime($preOrder['added']));?></td>
                                <td class="fit text-center"><?=time_ago("th", $preOrder['updates']);?></td>
                                <td class="fit">
                                    <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$preOrder['productId'];?>/<?=str_replace(" ", "-", $preOrder['title']);?>/" class="btn btn-primary rounded-0 btn-edit btn-tooltip" data-bs-title="ดูรายละเอียดสินค้า"><i class="fa-solid fa-eye"></i></a>
                                    <button class="btn btn-success rounded-0 btn-tooltip btn-pre-order" data-bs-toggle="modal" data-bs-target="#CreatePurchaseModal" data-bs-id="<?=$preOrder['id'];?>" data-bs-title="สร้างคำสั่งซื้อ"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                                </td>
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

    <form method="post" id="CreatePurchaseModalForm">
        <div class="modal fade" id="CreatePurchaseModal" tabindex="-1" aria-labelledby="CreatePurchaseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CreatePurchaseModalLabel">สร้างคำสั่งซื้อ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="preOrderId" id="preOrderId">
                        <div class="mb-3">
                            <label for="orderNo" class="col-form-label">เลขที่คำสั่งซื้อ:</label>
                            <input type="text" name="orderNo" class="form-control" id="orderNo" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="col-form-label">ราคาสินค้า (ต่อชิ้น):</label>
                            <input type="number" name="productPrice" class="form-control" id="productPrice" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="shippingPrice" class="col-form-label">ค่าขนส่ง:</label>
                            <input type="number" name="shippingPrice" class="form-control" id="shippingPrice" required aria-required="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="CreatePurchase">สร้างคำสั่งซื้อ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $.fn.dataTable.ext.type.order['date-euro-pre'] = function (date) {
                var parts = date.split(' ');
                var day = parseInt(parts[0], 10);
                var month = monthToNumber(parts[1]);
                var year = parseInt(parts[2], 10);
                
                return year * 10000 + month * 100 + day;
            };

            function monthToNumber(month) {
                var months = {
                    'Jan': 1, 'Feb': 2, 'Mar': 3, 'Apr': 4, 'May': 5, 'Jun': 6,
                    'Jul': 7, 'Aug': 8, 'Sep': 9, 'Oct': 10, 'Nov': 11, 'Dec': 12
                };
                return months[month];
            }
            
            $('#DataTables').DataTable( {
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 
                    }, 
                    {
                        targets: 9,
                        type: "date-euro"
                    }
                ],
                order: [
                    [
                        9, 'asc'
                    ]
                ]
            } );
        }, false);

        const CreatePurchaseModal = document.getElementById('CreatePurchaseModal')
        if (CreatePurchaseModal) {
            CreatePurchaseModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalBodyInput = CreatePurchaseModal.querySelector('#preOrderId')

                modalBodyInput.value = id
            })
        }

        $('#CreatePurchase').click(function () {
            var unindexed_array = $("#CreatePurchaseModalForm").serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

            const url = '$API_Link/v1/preorder/insert-purchase';

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
                                Swal.fire(
                                    'สร้างคำสั่งซื้อสำเร็จ',
                                    '',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else if (response.responseCode == "A07") {
                                Swal.fire(
                                    'สินค้าในระบบไม่เพียงพอ!',
                                    'กรุณาตรวจสอบสินค้าที่ API ก่อน',
                                    'info'
                                );
                            } else {
                                Swal.fire(
                                    'ล้มเหลว!',
                                    response.responseDesc,
                                    'error'
                                );

                                console.log(response.responseCode)
                                console.log(response.responseDesc)
                            }
                        }, 
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>