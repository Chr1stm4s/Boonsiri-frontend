<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "promotions";

        require_once "./head.php";

        $id = $_GET['id'];
        $category = $_GET['category'];

        $PromotionAPIURL = "$API_Link/v1/promotion/get-promotion";

        $PromotionAPIDataRequest = [
            'id' => $id, 
        ];

        $PromotionDataAPI = connect_api($PromotionAPIURL, $PromotionAPIDataRequest);

        if ($PromotionDataAPI['responseCode'] == 000) {
            $PromotionData = $PromotionDataAPI['promotion'];
        } else {
            var_dump($PromotionDataAPI);

            echo "get-promotion";

            exit();
        }

        $ProductAPIDataRequest = [
            'categoryId' => $category, 
            'whsCode' => "", 
            'orderByColumn' => "", 
            'orderBy' => "", 
            'pageNo' => 0, 
            'pageSize' => 0, 
        ];

        $APIURL = "$API_Link/v1/product/get-product-by-category-id-all";

        function calculateDiscount($type, $discount, $price) {
            if ($type == 0) {
                return $price - $discount;
            } elseif ($type == 1) {
                return $price - (($discount / 100) * $price);
            } else {
                return $price;
            }
        }
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
                <div class="col-auto my-auto">
                    <a href="./promotion-apply-category.php?id=<?=$id;?>" class="btn fs-1"><i class="fa-regular fa-square-caret-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0"><?=$PromotionData['title'];?></h1>
                </div>
                <div class="col-auto my-auto">
                    <button type="button" class="btn btn-primary" disabled id="ApplyPromotion" data-type="itemCode">บันทึก</button>
                    <!-- <button type="button" class="btn btn-primary" id="ApplyPromotion" data-type="itemCode">บันทึกเป็น itemCode</button> -->
                </div>
                <!-- <div class="col-auto my-auto">
                    <button type="button" class="btn btn-primary" id="ApplyPromotion" data-type="id">บันทึกเป็น ID</button>
                </div> -->
            </div>
            <input type="hidden" name="type" value="<?=$PromotionData['type'];?>" id="ApplyType">
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit"><input type="checkbox" id="ButtonApplyAll"></th>
                                <th>itemCode</th>
                                <th>ชื่อสินค้า</th>
                                <th class="fit">ราคาก่อนลด</th>
                                <th class="fit">ราคาหลังลด</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php                        
                            $DataAPI = connect_api($APIURL, $ProductAPIDataRequest);
                            
                            if ($DataAPI['responseCode'] == 000) {
                                foreach ($DataAPI["product"] as $DataList) {
                                    $disableCheckbox = (calculateDiscount($PromotionData['type'], $PromotionData['discount'], $DataList['price']) <= 0) ? "disabled" : "";

                        ?>

                            <tr>
                                <th><input type="checkbox" name="apply[]" <?=$disableCheckbox;?> class="checkbox-promotion" value="<?=$DataList['itemCode'];?>" <?=($DataList['promotionId'] == $id) ? "checked" : ""; ?>></th>
                                <td><?=$DataList['itemCode'];?></td>
                                <td><?=$DataList['title'];?></td>
                                <td class="text-end"><?=(@$DataList['price']) ? number_format($DataList['price'])." บาท" : "-"; ?></td>
                                <td class="text-end"><?=(@$DataList['price']) ? calculateDiscount($PromotionData['type'], $PromotionData['discount'], $DataList['price'])." บาท" : "-"; ?></td>
                            </tr>

                        <?php
                                }
                            } else {
                        ?>

                            <tr>
                                <td colspan="5"><?=var_dump($ProductAPIDataRequest);?></td>
                            </tr>
                            <tr>
                                <td colspan="5"><?=var_dump($DataAPI);?></td>
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
    
    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function() {
            $('#DataTables').DataTable( {
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: 0 
                    }
                ], 
                order: [
                    [
                        1, 
                        'asc'
                    ]
                ], 
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "แสดงทั้งหมด"]
                ],
                iDisplayLength: 10, 
                drawCallback: function () {
                    var table = this.api();

                    function updateButtonApplyAll() {
                        if ($('.checkbox-promotion:checked').length == $('.checkbox-promotion').length) {
                            $("#ButtonApplyAll").prop('checked', true);
                        } else {
                            $("#ButtonApplyAll").prop('checked', false);
                        }
                    }

                    // Event handler for page change
                    table.on('draw', function() {
                        updateButtonApplyAll();
                    });

                    // Event handlers for pagination buttons
                    $('.paginate_button.next:not(.disabled)', table.table().container()).on('click', updateButtonApplyAll);
                    $('.paginate_button:not(.next, .previous)', table.table().container()).on('click', updateButtonApplyAll);
                    $('.paginate_button.previous:not(.disabled)', table.table().container()).on('click', updateButtonApplyAll);

                    // Event handlers for length change and search
                    table.on('length.dt', function() {
                        updateButtonApplyAll();
                    });
                    table.on('search.dt', function() {
                        updateButtonApplyAll();
                    });
                }
            });
            
            $(document).on('click', '#ButtonApplyAll', function() {
                $("#ApplyPromotion").prop("disabled", false);

                if($(this).is(':checked')) {
                    $('.checkbox-promotion').prop('checked', true);
                } else {
                    $('.checkbox-promotion').prop('checked', false);
                }
            });

            $('#DataTables').on("change", '.checkbox-promotion', function() {
                const checkedValues = $(this).val();

                if (!$(this).is(":checked")) {
                    $.ajax({
                        type: 'POST',
                        url: './update/promotion-remove.php', 
                        data: { 
                            checkboxValues: checkedValues, 
                            promotionId: 0, 
                        },
                        success: function(response) {
                            Swal.close();

                            if(response == 'success') {
                                console.log("removed");
                            } else {
                                Swal.fire(
                                    'ใช้งานโปรโมชั่นไม่สำเร็จ!',
                                    'กรุณาติดต่อเจ้าหน้าที่',
                                    'error'
                                );

                                console.log(checkedValues)
                                console.log(response)
                            }
                        }
                    });
                } else {
                    const promotionId = <?=$id;?>;

                    $.ajax({
                        type: 'POST',
                        url: './update/promotion-apply-single.php', 
                        data: { 
                            checkboxValues: checkedValues, 
                            promotionId: promotionId, 
                        },
                        success: function(response) {
                            Swal.close();

                            if(response == 'success') {
                                console.log("added");
                            } else {
                                Swal.fire(
                                    'ใช้งานโปรโมชั่นไม่สำเร็จ!',
                                    'กรุณาติดต่อเจ้าหน้าที่',
                                    'error'
                                );

                                console.log(checkedValues)
                                console.log(response)
                            }
                        }
                    });
                }
            });

            console.log($('.checkbox-promotion').length);

            if ($('.checkbox-promotion:checked').length == $('.checkbox-promotion').length) {
                $("#ButtonApplyAll").prop('checked', true);
            }
            
            // Handle button click
            $('#ApplyPromotion').on("click", function(e) {
                e.preventDefault();

                var checkedValues = [];

                $('.checkbox-promotion:checked').each(function() {
                    checkedValues.push($(this).val());
                });

                if (checkedValues.length > 0) {
                    var promotionId = <?=$id;?>;
                } else {
                    var promotionId = 0;

                    $('.checkbox-promotion').each(function() {
                        checkedValues.push($(this).val());
                    });
                }

                Swal.fire({
                    title: 'ต้องการใช้งานโปรโมชั่นกับสินค้าเหล่านี้ใช่ไหม?',
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
                        
                        $.ajax({
                            type: 'POST',
                            url: './update/promotion-apply.php', 
                            data: { 
                                checkboxValues: checkedValues, 
                                promotionId: promotionId, 
                            },
                            success: function(response) {
                                Swal.close();

                                if(response == 'success') {
                                    Swal.fire(
                                        'ใช้งานโปรโมชั่นนี้เรียบร้อย!',
                                        'ระบบจะทำการรีเฟรชหน้าใหม่',
                                        'success'
                                    ).then(function() {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'ใช้งานโปรโมชั่นไม่สำเร็จ!',
                                        'กรุณาติดต่อเจ้าหน้าที่',
                                        'error'
                                    );

                                    console.log(response)
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>