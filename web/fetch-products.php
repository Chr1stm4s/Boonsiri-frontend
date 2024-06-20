<?php
    require_once "./functions.php";

    $orderByColumn = $_POST['orderByColumn'];
    $orderBy = $_POST['orderBy'];
    $itemSize = ($_POST['itemSize']) ? $_POST['itemSize'] : "";
    $pageNo = $_POST['pageNo'];
    $pageSize = $_POST['pageSize'];
    $categoryId = $_POST['categoryId'];
    $WhsCode = (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK";
    
    if ($categoryId == 0) {
        $APIURL = "{$API_URL}product/list-product";

        $ProductAPIDataRequest = [
            'whsCode' => $WhsCode, 
            'orderByColumn' => $orderByColumn, 
            'itemSize' => $itemSize, 
            'orderBy' => $orderBy, 
            'pageNo' => $pageNo, 
            'pageSize' => $pageSize 
        ];

        $ResponseKey = 'products';
    } else {
        $APIURL = "{$API_URL}product/get-product-by-category-id";

        $ProductAPIDataRequest = [
            'categoryId' => $categoryId, 
            'whsCode' => $WhsCode, 
            'orderByColumn' => $orderByColumn, 
            'itemSize' => $itemSize, 
            'orderBy' => $orderBy, 
            'pageNo' => $pageNo, 
            'pageSize' => $pageSize 
        ];

        $ResponseKey = 'product';
    }

    $ProductAPIDataResponse = connect_api($APIURL, $ProductAPIDataRequest);
    
    if ($ProductAPIDataResponse['responseCode'] == 000) {
        foreach ($ProductAPIDataResponse[$ResponseKey] as $product) {
            $thumbnail = (file_exists("products/".$product['thumbnail'])) ? rootURL()."products/".$product['thumbnail'] : rootURL()."images/logo.png";
            $placeholder = (file_exists("products/".$product['thumbnail'])) ? "" : "thumbnail-placeholder";
?>

<div class="col-6 col-md-4 col-lg-3 p-1 p-md-2">
    <a href="javascript:void(0);" class="text-decoration-none product-link" data-url="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$product['id'];?>/<?=str_replace(" ", "-", $product['title']);?>/">
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
                <button class="btn btn-theme-4 btn-sm w-100 btn-product-details product-link" data-url="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$product['id'];?>/<?=str_replace(" ", "-", $product['title']);?>/"><i class="fa-solid fa-list-check"></i> &nbsp; ดูรายละเอียดสินค้า</button>
            </div>
        </div>
    </a>
</div>

<?php
        }

        $TotalPage = $ProductAPIDataResponse['totalPage'];
?>

<div class="col-12">
    <div class="row mt-3 mx-0">
        <div class="col-auto mx-auto">
            <div class="input-group pagination">
                <button class="btn <?=($pageNo == 1) ? "btn-light" : "btn-theme-4"; ?>" type="button" id="ButtonPrev" <?=($pageNo == 1) ? "disabled" : ""; ?>><i class="fa-solid fa-angles-left"></i> &nbsp;ก่อนหน้า</button>
                <label class="input-group-text">หน้า</label>

                <?php
                    if ($TotalPage <= 1) {
                ?>

                <select class="form-select" id="PageNumber">
                    <option value="1" disabled selected>1</option>
                </select>

                <label class="input-group-text">ของ 1</label>
                <button class="btn btn-light" type="button" id="ButtonNext" disabled>ถัดไป &nbsp;<i class="fa-solid fa-angles-right"></i></button>
                    
                <?php
                    } else {
                ?>

                <select class="form-select" id="PageNumber" <?=($TotalPage == 1) ? "disabled" : ""; ?>>

                    <?php
                        for ($i=1; $i <= $TotalPage; $i++) { 
                    ?>

                    <option <?php if($i == $pageNo) { echo 'selected'; } ?> value="<?=$i;?>"><?=$i;?></option>
                
                    <?php
                        }
                    ?>

                </select>

                <label class="input-group-text">ของ <?=$TotalPage;?></label>
                <button class="btn btn-theme-4" type="button" id="ButtonNext" <?=($TotalPage == $pageNo) ? "disabled" : ""; ?>>ถัดไป &nbsp;<i class="fa-solid fa-angles-right"></i></button>

                <?php
                    }
                ?>

            </div>
        </div>
    </div>
</div>

<?php
    } else {
?>

<div class="col text-center py-5">
    <h3 class="my-5">ไม่พบข้อมูลสินค้า</h3>
</div>

<?php
    }
?>