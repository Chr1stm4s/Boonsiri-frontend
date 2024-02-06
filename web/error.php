<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "error";
        
        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>
    
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-5 mx-auto text-center">
                    <h1 class="mb-4">ขออภัยในความไม่สะดวก</h1>
                    <h5 class="mb-0">ไม่พบหน้าที่คุณค้าหา</h5>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-11 col-md-7 col-lg-5 mx-auto">
                    <img src="<?=rootURL();?>images/thank-you.svg" alt="ขออภัยในความไม่สะดวก" class="w-100">
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 col-lg-2 ms-auto">
                    <a href="<?=rootURL();?>คำสั่งซื้อ/" class="btn btn-lg btn-theme-2 w-100"><i class="fa-solid fa-file-lines"></i> ดูรายการสั่งซื้อ</a>
                </div>
                <div class="col-6 col-md-3 col-lg-2 me-auto">
                    <a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="btn btn-lg btn-theme-4 w-100">เลือกสินค้าต่อ <i class="fa-solid fa-cart-plus"></i></a>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>