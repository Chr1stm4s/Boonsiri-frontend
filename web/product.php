<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "product";
        
        require_once "./head.php";

        $thumbnail = (file_exists("products/".$ProductData['thumbnail'])) ? rootURL()."products/".$ProductData['thumbnail'] : rootURL()."images/logo.png";
        $quantity = ($ProductData['uomCode']) ? $ProductData['uomCode'] : "ชิ้น";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="#" class="text-theme-1 product-link" data-url="<?=rootURL();?>สินค้าทั้งหมดของบุญศิริ/">สินค้าทั้งหมดของบุญศิริ</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="text-theme-1 btn-hyper-link" data-url="">หมวดหมู่สินค้าทั้งหมด</a></li>

                        <?php
                            $BreadcrumbData = [
                                "id" => $ProductData['categoryId'],
                            ];

                            $Breadcrumb = connect_api("{$API_URL}category/breadcrumb", $BreadcrumbData);


                            foreach ($Breadcrumb['items'] as $key => $CategoryList) {
                                $BreadcrumbURL = ($key == 1) ? rootURL()."สินค้าบุญศิริ/".$CategoryList['itemCode']."/".$CategoryList['categoryId']."/" : rootURL()."หมวดหมู่สินค้าบุญศิริ/".$CategoryList['itemCode']."/".$CategoryList['categoryId']."/";
                        ?>

                            <li class="breadcrumb-item"><a href="<?=$BreadcrumbURL;?>" class="text-theme-1 btn-hyper-link" data-url=""><?=$CategoryList['itemCode'];?></a></li>

                        <?php
                            }
                        ?>

                            <li class="breadcrumb-item active" aria-current="page"><?=$ProductData['title'];?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 position-relative">

                <?php
                    $ProductImageAPIURL = "{$API_URL}product/list-product-image";

                    $ProductImageAPIDataRequest = [
                        'itemCode' => $ProductData['itemCode'], 
                    ];
                    
                    $ProductImageAPIDataResponse = connect_api($ProductImageAPIURL, $ProductImageAPIDataRequest);
                    
                    if ($ProductImageAPIDataResponse['responseCode'] == "000") {
                        $i = 1;
                ?>

                    <div id="carouselProductImageIndicators" class="carousel slide mb-4 mb-md-0">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselProductImageIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>

                        <?php
                            foreach ($ProductImageAPIDataResponse['productImages'] as $ProductImage) {
                        ?>

                            <button type="button" data-bs-target="#carouselProductImageIndicators" data-bs-slide-to="<?=$i;?>" aria-label="Slide <?=$i+1;?>"></button>

                        <?php
                                $i++;
                            }
                        ?>

                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item position-relative active">
                                <img src="<?=rootURL();?>images/watermark.png" alt="บุญศิริ โฟรเซ่น" class="watermark">
                                <img src="<?=$thumbnail;?>" class="d-block w-100" alt="<?=$ProductData['title'];?>">
                            </div>

                        <?php
                            foreach ($ProductImageAPIDataResponse['productImages'] as $ProductImage) {
                        ?>

                            <div class="carousel-item position-relative">
                                <img src="<?=rootURL();?>images/watermark.png" alt="บุญศิริ โฟรเซ่น" class="watermark">
                                <img src="<?=rootURL();?>products/gallery/<?=str_replace("/", "", $ProductData['itemCode']);?>/<?=$ProductImage['image'];?>" class="d-block w-100" alt="<?=$ProductData['title'];?>">
                            </div>
                            
                        <?php
                            }
                        ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductImageIndicators" data-bs-slide="prev">
                            <i class="fa-solid fa-caret-left fa-2x text-theme-1 f-shadow"></i>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProductImageIndicators" data-bs-slide="next">
                            <i class="fa-solid fa-caret-right fa-2x text-theme-1 f-shadow"></i>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                <?php
                    } else {
                ?>

                    <img src="<?=rootURL();?>images/watermark.png" alt="บุญศิริ โฟรเซ่น" class="watermark">
                    <img src="<?=$thumbnail;?>" alt="<?=$ProductData['title'];?>" class="w-100">

                <?php
                    }
                ?>

                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <input type="hidden" name="product_name" id="product_name" value="<?=$ProductData['title'];?>">
                    <input type="hidden" name="product_uom_code" id="product_uom_code" value="<?=$ProductData['uomCode'];?>">

                    <h1 class="fs-5"><?=$ProductData['title'];?></h1>
                    <small>SKU: <?=$ProductData['itemCode'];?></small>

                    <?php
                        
                        if ($ProductData['promotionType'] !== null && ($ProductData['promotionType'] == 0 || $ProductData['promotionType'] == 1)) {
                            if ($ProductData['discount'] == 0) {
                    ?>

                    <p class="my-4 fs-3">
                        <span class="text-danger fw-bold"><?=number_format($ProductData['lastPrice']);?> บาท </span>
                    </p>

                    <?php
                            } else {
                    ?>

                    <p class="my-4 fs-3">
                        <span class="text-danger"><?=number_format($ProductData['lastPrice']);?> บาท </span>
                        &nbsp; 
                        <small class="text-decoration-line-through fs-6">
                            <?=number_format($ProductData['price']);?> บาท
                        </small>
                        <br>
                        <span class="bdage text-bg-danger py-1 px-2 save-text fw-bold">ประหยัด <?=number_format($ProductData['discount']);?> บาท</span>
                    </p>

                    <?php
                            }
                        } else {
                    ?>

                        <p class="text-theme-4 fs-3 fw-bold"><?=number_format($ProductData['price']);?> บาท</p>

                    <?php
                        }
                    ?>

                    <p class="my-4">
                        <b>รายละเอียดสินค้า</b>
                        <br>
                        <?=$ProductData['description'];?>
                    </p>

                    <div class="row">
                        <div class="col col-lg-5">
                            <div class="input-group">
                                <button class="btn btn-outline-secondary btn-sm btn-amount-adjust rounded-0" type="button" data-action="decrease">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <input type="number" class="form-control form-control-sm input-amount-adjust rounded-0 text-end" placeholder="1" id="amount" inputmode="numeric" data-action="custom" value="1">
                                <label class="input-group-text" for="amount"><?=$quantity;?></label>
                                <button class="btn btn-outline-secondary btn-sm btn-amount-adjust rounded-0" type="button" data-action="increase">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto ps-1">

                        <?php
                            if ($ProductData['preOrder'] === 1) {
                        ?>

                            <button type="button" class="btn btn-info pre-order px-4 rounded-0" data-id="<?=$id;?>"><i class="fa-solid fa-weight-hanging"></i>&nbsp; ติดต่อแอดมินเพื่อสรุปยอด</button>
                            
                        <?php
                            } else {
                        ?>

                            <button type="button" class="btn btn-theme-4 add-to-cart px-4 rounded-0" data-id="<?=$id;?>"><i class="fa-solid fa-cart-plus"></i>&nbsp; หยิบใส่ตะกร้า</button>

                        <?php
                            }
                        ?>

                        </div>
                    </div>

                    <?php
                        if ($ProductData['preOrder'] === 1) {
                    ?>

                    <div class="row mt-4">
                        <div class="col">
                            <h5>วิธีการสั่งซื้อสินค้าชั่งน้ำหนัก</h5>
                            <ol>
                                <li>ทำการเลือกจำนวนชิ้นที่ต้องการซื้อ</li>
                                <li>กดปุ่ม "ติดต่อแอดมินเพื่อสรุปยอด" เพื่อแจ้งคำสั่งซื้อ</li>
                                <li>ระบบจะแสดงสรุปยอดที่รวมทั้งน้ำหนัก และราคา</li>
                                <li>ลูกค้าตรวจสอบรายการสรุปยอดที่แสดง</li>
                                <li>ลูกค้ายืนยันการสั่งซื้อ และดำเนินขั้นตอนต่อไป</li>
                            </ol>
                        </div>
                    </div>
  
                    <?php
                        }
                    ?>
                    
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-auto mx-auto">
                    <h5 class="fs-2">สินค้าอื่นที่น่าสนใจ</h5>
                </div>
            </div>
            <div class="row g-4">

                <?php
                    $APIURL = "{$API_URL}product/get-product-by-category-id";

                    $APIDataRequest = [
                        'categoryId' => $ProductData['categoryId'], 
                        'itemSize' => $ProductData['itemSize'], 
                        'whsCode' => @$_SESSION['whsCode'], 
                        'orderByColumn' => '',  
                        'orderBy' => '', 
                        'pageNo' => 1, 
                        'pageSize' => 6
                    ];

                    $ResponseKey = 'product';

                    $APIDataResponse = connect_api($APIURL, $APIDataRequest);

                    if ($APIDataResponse['responseCode'] == "000") {
                        if (count($APIDataResponse[$ResponseKey]) > 1) {
                            foreach ($APIDataResponse[$ResponseKey] as $FeaturedProducts) {
                                if (file_exists("products/".$FeaturedProducts['thumbnail'])) {
                                    $thumbnail = rootURL()."products/".$FeaturedProducts['thumbnail'];
                                    $placeholder = "";
                                } else {
                                    $thumbnail = rootURL()."images/logo.png";
                                    $placeholder = "thumbnail-placeholder";
                                }

                                if ($FeaturedProducts['id'] != $id) {
                ?>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card products-card">
                        <a href="javascript:void(0);" class="text-decoration-none product-link" data-url="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$FeaturedProducts['id'];?>/<?=str_replace(" ", "-", $FeaturedProducts['title']);?>/">

                            <?php
                                if ($FeaturedProducts['preOrder'] == 1) {
                            ?>

                            <button type="button" class="btn btn-warning btn-weight btn-tooltip" title="สินค้าชั่งน้ำหนัก" data-bs-title="สินค้าชั่งน้ำหนัก"><i class="fa-solid fa-weight-scale"></i></button>

                            <?php
                                }
                            ?>

                            <img src="<?=rootURL();?>images/watermark.png" alt="บุญศิริ โฟรเซ่น" class="watermark">
                            <img src="<?=$thumbnail;?>" alt="<?=$FeaturedProducts['title'];?>" class="card-img-top <?=$placeholder;?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title text-dark"><?=$FeaturedProducts['title'];?></h5>
                            
                            <?php
                                if ($FeaturedProducts['promotionType'] !== null && ($FeaturedProducts['promotionType'] == 0 || $FeaturedProducts['promotionType'] == 1)) {
                                    if ($FeaturedProducts['discount'] == 0) {
                            ?>

                            <p class="card-text text-theme-4 discount-text mb-0 text-end">
                                <span class="fs-3 fw-bold text-danger"><?=number_format($FeaturedProducts['lastPrice']);?> บาท</span>
                            </p>

                                <?php
                                    } else {
                                ?>

                            <p class="card-text text-theme-4 discount-text mb-0 text-end">
                                <span class="text-decoration-line-through"><?=number_format($FeaturedProducts['price']);?> บาท</span> 
                                &nbsp;
                                <br class="d-block d-lg-none"> 
                                <span class="fs-3 fw-bold text-danger"><?=number_format($FeaturedProducts['lastPrice']);?> บาท</span>
                                <br>
                                <span class="bdage text-bg-danger py-1 px-2 save-text fw-bold">ประหยัด <?=number_format($FeaturedProducts['discount']);?> บาท</span>
                            </p>

                            <?php
                                    }
                                } else {
                            ?>

                            <p class="fs-3 card-text text-theme-4 mb-0 text-end"><?=number_format($FeaturedProducts['price']);?> บาท</p>

                            <?php
                                }
                            ?>
                            
                        </div>
                        <div class="card-footer p-0">
                            
                            <?php
                                if ($FeaturedProducts['preOrder'] === 1) {
                            ?>

                            <button type="button" class="btn rounded-top-0 w-100 btn-info pre-order px-4" data-id="<?=$FeaturedProducts['id'];?>" data-amount="1"><i class="fa-solid fa-weight-hanging"></i>&nbsp; ส่งชั่งน้ำหนัก</button>
                            
                            <?php
                                } else {
                            ?>

                            <button type="button" class="btn rounded-top-0 w-100 btn-theme-4 add-to-cart px-4" data-id="<?=$FeaturedProducts['id'];?>" data-amount="1"><i class="fa-solid fa-cart-plus"></i>&nbsp; หยิบใส่ตะกร้า</button>

                            <?php
                                }
                            ?>
                        
                        </div>
                    </div>
                </div>

                <?php
                                }
                            }
                        } else {
                ?>

                <div class="col text-center">
                    <h5 class="mb-0">ยังไม่มีสินค้าใกล้เคียง</h5>
                </div>
            
                <?php
                        }
                    } else {
                ?>

                <div class="col text-center">
                    <h5 class="mb-0">ไม่พบข้อมูล</h5>
                </div>

                <?php
                    }
                ?>
            
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <?php require_once "cart-js.php"; ?>

    <script>
        $(".btn-amount-adjust").on("click", function() {
            const action = $(this).data("action");
            const amount = $(".input-amount-adjust").val();

            AdjustItemAmount(action, amount);
        });

        function AdjustItemAmount(action, amount) {
            if (action == "decrease" && amount > 1) {
                var newAmount = parseInt(amount) - 1;
            } else {
                var newAmount = parseInt(amount) + 1;
            }

            $(".input-amount-adjust").val(newAmount);
        }
    </script>

</body>

</html>