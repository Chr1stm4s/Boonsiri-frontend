<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "member-profile";
        
        require_once "../head.php";

        $ListAddressAPIRequest = [
            'customerId' => $_SESSION['id'],
        ];

        $ListAddressResponse = connect_api("{$API_Link}api/v1/address/list-address-profile", $ListAddressAPIRequest);

        if ($ListAddressResponse['responseCode'] == 000) {

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
                            <li class="breadcrumb-item">สมาชิก</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-3 my-3 text-center">
                    <a href="<?=rootURL();?>ข้อมูลสมาชิก/" class="text-decoration-none text-dark">
                        <img src="<?=rootURL();?>images/member-info.png" alt="ข้อมูลสมาชิก" class="w-100 member-icon-nav mb-3">
                        ข้อมูลสมาชิก
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3 text-center">
                    <a href="<?=rootURL();?>ที่อยู่จัดส่ง/" class="text-decoration-none text-dark">
                        <img src="<?=rootURL();?>images/member-address.png" alt="ที่อยู่จัดส่ง" class="w-100 member-icon-nav mb-3">
                        ที่อยู่จัดส่ง
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3 text-center">
                    <a href="<?=rootURL();?>ตั้งค่าบัญชี/" class="text-decoration-none text-dark">
                        <img src="<?=rootURL();?>images/member-settings.png" alt="ตั้งค่าบัญชี" class="w-100 member-icon-nav mb-3">
                        ตั้งค่าบัญชี
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3 text-center">
                    <a href="<?=rootURL();?>คำสั่งซื้อ/" class="text-decoration-none text-dark">
                        <img src="<?=rootURL();?>images/member-orders.png" alt="คำสั่งซื้อ" class="w-100 member-icon-nav mb-3">
                        คำสั่งซื้อ
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

</body>

</html>