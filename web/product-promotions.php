<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "promotions";
        
        require_once "./head.php";

        $WhsCode = (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK";
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
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>สินค้าทั้งหมดของบุญศิริ/" class="text-theme-1">สินค้าทั้งหมดของบุญศิริ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">สินค้าลดราคา</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col p-0">

                    <?php
                        $APIURL = "{$API_URL}product/get-product-by-promotion-id";

                        $pageNo = 1;
                        $pageSize = 12;

                        $ProductAPIDataRequest = [
                            "promotionId" => 0, 
                            "whsCode" => $WhsCode, 
                            'orderByColumn' => "id",  
                            'orderBy' => "DESC", 
                            "pageNo" => 0, 
                            "pageSize" => 0, 
                            "isFrontEnd" => 1, 
                        ];

                        $PromotionAPIDataResponse = connect_api($APIURL, $ProductAPIDataRequest);

                        if ($PromotionAPIDataResponse['responseCode'] == "000") {
                    ?>

                    <div class="row mx-0 g-0">
                        
                        <?php
                            foreach ($PromotionAPIDataResponse['product'] as $product) {
                                $thumbnail = (file_exists("products/".$product['thumbnail'])) ? rootURL()."products/".$product['thumbnail'] : rootURL()."images/logo.png";
                                $placeholder = (file_exists("products/".$product['thumbnail'])) ? "" : "thumbnail-placeholder";
                        ?>

                        <div class="col-6 col-md-4 col-lg-3 p-1 p-md-2">
                            <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$product['id'];?>/<?=str_replace(" ", "-", $product['title']);?>/" class="text-decoration-none">
                                <div class="card products-card">

                                    <?php
                                        if ($product['preOrder'] == 1) {
                                    ?>

                                        <button type="button" class="btn btn-warning btn-weight btn-tooltip" title="สินค้าชั่งน้ำหนัก" data-bs-title="สินค้าชั่งน้ำหนัก"><i class="fa-solid fa-weight-scale"></i></button>

                                    <?php
                                        }
                                    ?>

                                    <img src="<?=rootURL();?>images/watermark.png" alt="บุญศิริ โฟรเซ่น" class="watermark">
                                    <img src="<?=$thumbnail;?>" alt="<?=$product['title'];?>" class="card-img-top <?=$placeholder;?>">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark"><?=$product['title'];?></h5>
                                    </div>
                                    <div class="card-footer bg-white border-0 text-end">

                                    <?php
                                        if ($product['promotionType'] !== null && ($product['promotionType'] == 0 || $product['promotionType'] == 1)) {
                                    ?>

                                        <p class="card-text discount-text">
                                            <span class="text-decoration-line-through"><?=number_format($product['price']);?> บาท</span> 
                                            &nbsp;
                                            <br class="d-block d-lg-none"> 
                                            <span class="fs-3 fw-bold text-danger"><?=number_format($product['lastPrice']);?> บาท</span>
                                            <br>
                                            <span class="bdage text-bg-danger py-1 px-2 save-text fw-bold">ประหยัด <?=number_format($product['discount']);?> บาท</span>
                                        </p>

                                    <?php
                                        } else {
                                    ?>

                                        <p class="card-text fs-3 fw-bold"><?=number_format($product['price']);?> บาท</p>

                                    <?php
                                        }
                                    ?>

                                    </div>
                                    <div class="card-footer p-0 p-md-2">
                                        <button class="btn btn-theme-4 btn-sm w-100 btn-product-details"><i class="fa-solid fa-list-check"></i> &nbsp; ดูรายละเอียดสินค้า</button>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php
                            }
                        ?>

                    </div>

                    <?php
                        } else {
                    ?>

                    <h3 class="mb-0 text-center">ยังไม่มีสินค้าลดราคา</h3>

                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>