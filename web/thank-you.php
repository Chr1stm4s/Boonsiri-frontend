<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "thank-you";
        
        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ขอบคุณสำหรับคำสั่งซื้อ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7 col-lg-5 mx-auto text-center">
                    <h1 class="mb-4">ขอบคุณสำหรับคำสั่งซื้อ</h1>
                    <h5 class="mb-0">ระบบกำลังตรวจสอบข้อมูลการชำระเงิน และจะแจ้งเตือนกลับไปทาง SMS เมื่อการชำระเงินเสร็จสมบูรณ์</h5>
                </div>
            </div>
            <div class="row my-5">
                <div class="col-11 col-md-7 col-lg-5 mx-auto">
                    <img src="<?=rootURL();?>images/thank-you.png" alt="ขอบคุณสำหรับคำสั่งซื้อ" class="w-100">
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