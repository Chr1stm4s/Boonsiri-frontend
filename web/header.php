<?php
    $WhsCode = (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK";

    if (@$_SESSION['cart']) {
        // Request body
        $HeaderCartDataAPI = [
            'customerId' => $_SESSION['id'],
            'whsCode' => $WhsCode
        ];

        $HeaderCartData = connect_api("{$API_URL}cart/list-cart", $HeaderCartDataAPI);

        $_SESSION['cart'] = count($HeaderCartData['cartModels']);

        $HeaderCartCount = $_SESSION['cart'];
    } else {
        $HeaderCartCount = 0;
    }

    if (@$_SESSION['categories']) {
        $CategoryList = $_SESSION['categories'];
    } else {
        $CategoryMainRequest = [
            "whsCode" => $WhsCode
        ];
        
        $CategoryList = connect_api("{$API_URL}category/list-category", $CategoryMainRequest);

        $_SESSION['categories'] = $CategoryList;
    }
?>

<section class="bg-header py-2">
    <div class="container-fluid">
        <div class="row">
            <div class="my-auto col-12 col-md d-flex">
                <marquee behavior="sliding" direction="left" class="my-auto text-white">คิดถึงบุญศิริ คิดถึงแหล่งอาหารปลอดภัย รอยยิ้มสดใส ส่งทันใจ คู่ค้าโตไปด้วยกัน</marquee>
            </div>
            <!-- <div class="my-auto col-12 col-md-auto">
                <div class="row mx-0">
                    <div class="my-auto col col-md-auto border-end border-white border-2">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle dropdown-notification text-white fw-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-bell"></i>&nbsp;การแจ้งเตือน
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Notification #1</a></li>
                                <li><a class="dropdown-item" href="#">Notification #2</a></li>
                                <li><a class="dropdown-item" href="#">Notification #3</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="my-auto col text-center">
                        <button class="py-0 btn switch-language border-0 active" data-lang="th">
                            <img src="<?=rootURL();?>images/thailand.png" alt="ภาษาไทย">
                            ไทย
                        </button>
                        <button class="py-0 btn switch-language border-0" data-lang="en">
                            <img src="<?=rootURL();?>images/english.png" alt="English">
                            ENG
                        </button>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</section>

<nav class="navbar navbar-expand-lg py-0 sticky-top shadow" id="HeaderMenu">
    <div class="container-fluid">
        <div class="row w-100 mx-0">
            <div class="col-12 col-lg-auto me-auto d-flex">
                <a class="navbar-brand" href="<?= rootURL(); ?>">
                    <img src="<?= rootURL(); ?>images/logo.png" alt="<?= $title; ?>" id="HeaderMenuLogo">
                </a>
                <a class="navbar-brand d-block d-md-none my-auto" href="<?= rootURL(); ?>">
                    <i class="fa-solid fa-house-chimney-window fa-2x text-white"></i>
                </a>
                <button class="navbar-toggler ms-auto my-auto" type="button" data-bs-toggle="collapse" data-bs-target="#HeaderNavbar" aria-controls="HeaderNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="col-12 col-lg-auto my-auto ms-auto">
                <div class="collapse navbar-collapse" id="HeaderNavbar">
                    <ul class="navbar-nav fs-5">
                        <li class="nav-item">
                            <a class="nav-link <?=($page == "home") ? "active" : ""; ?>" <?=($page == "home") ? 'aria-current="page"' : ""; ?> href="<?=rootURL();?>">หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=($page == "about") ? "active" : ""; ?>" <?=($page == "home") ? 'aria-current="page"' : ""; ?> href="<?=rootURL();?>เกี่ยวกับบุญศิริ/">เกี่ยวกับบุญศิริ</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link <?=($page == "products" || $page == "product") ? "active" : ""; ?> dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" <?=($page == "home" || $page == "product") ? 'aria-current="page"' : ""; ?>>
                                สินค้าบุญศิริ
                                <i class="fa-solid fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item btn-hyper-link" href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/">หมวดหมู่สินค้าทั้งหมด</a></li>
            
                                <?php
                                    foreach ($CategoryList['categories'] as $HeaderCategoryList) {
                                ?>

                                <li><a class="dropdown-item btn-hyper-link" href="<?=rootURL();?>หมวดหมู่สินค้าบุญศิริ/<?=($HeaderCategoryList['url']) ? $HeaderCategoryList['url'] : str_replace(" ", "-", $HeaderCategoryList['title']);?>/<?=$HeaderCategoryList['id'];?>/"><?=$HeaderCategoryList['title'];?></a></li>

                                <?php
                                    }
                                ?>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=($page == "jobs") ? "active" : ""; ?>" <?=($page == "jobs") ? 'aria-current="page"' : ""; ?> href="<?=rootURL();?>ร่วมงานกับเรา/">ร่วมงานกับเรา</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=($page == "articles" || $page == "article") ? "active" : ""; ?>" <?=($page == "articles" || $page == "article") ? 'aria-current="page"' : ""; ?> href="<?=rootURL();?>ข่าวสารและกิจกรรม/">ข่าวสารและกิจกรรม</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?=($page == "contact") ? "active" : ""; ?>" <?=($page == "contact") ? 'aria-current="page"' : ""; ?> href="<?=rootURL();?>ติดต่อเรา/">ติดต่อเรา</a>
                        </li>
                    </ul>
                </div>
            </div>
                
            <?php
                if (@$_SESSION['id'] != null) {
            ?>
            
            <div class="col col-lg-auto ms-auto my-auto d-none d-lg-block">
                <div class="dropdown">
                    <button class="btn text-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        สวัสดี คุณ <?=$_SESSION['fname'];?> !
                    </button>
                    <ul class="dropdown-menu rounded-0 w-100">
                        <li><a class="dropdown-item" href="<?=rootURL();?>ข้อมูลสมาชิก/">ข้อมูลสมาชิก</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>ที่อยู่จัดส่ง/">ที่อยู่จัดส่ง</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>ตั้งค่าบัญชี/">ตั้งค่าบัญชี</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>คำสั่งซื้อ/">คำสั่งซื้อ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>action/logout/">ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-auto my-auto px-0 d-none d-lg-block">
                <button class="btn text-white shoping-bag-icon p-0 btn-tooltip" id="AddressProfileButton" data-bs-title="เลือกที่อยู่จัดส่งสินค้า" data-bs-toggle="modal" data-bs-target="#SelectAddressProfileModal">
                    <i class="fa-solid fa-house-user fs-4"></i>
                </button>
            </div>
            <div class="col-auto my-auto d-none d-lg-block">
                <a href="<?=rootURL();?>ตะกร้าสินค้า/" class="btn position-relative shoping-bag-icon p-0 text-warning btn-tooltip" data-bs-title="รายการสินค้าที่สั่งซื้อ">
                    <i class="fa-solid fa-bag-shopping fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span id="CartAmount"><?=$HeaderCartCount;?></span>
                        <span class="visually-hidden">items in shopping bag</span>
                    </span>
                </a>
            </div>

            <?php
                } else {
            ?>

            <div class="col-12 col-lg-auto ms-auto mt-3 mt-lg-auto mb-0 mb-lg-auto d-none d-lg-block">
                <button type="button" class="btn btn-theme-3 rounded-0 px-3 py-2 w-100 shadow rounded-pill" data-bs-toggle="modal" data-bs-target="#ModalMemberRequired"><i class="fa-regular fa-user"></i> &nbsp; สมัครสมาชิก / เข้าสู่ระบบ</button>
            </div>
                
            <?php
                }
            ?>

        </div>
    </div>
</nav>

<?php
    if ($page != "cart") {
?>

<div class="mobile-menu d-block d-lg-none shadow">
    <div class="row mx-0">
        
            <?php
                if (isset($_SESSION['id']) != null) {
            ?>
            
            <div class="col-2 text-center h-100 px-0 bg-theme-5 py-3">
                <button class="btn shoping-bag-icon p-0 btn-tooltip" id="AddressProfileButton" data-bs-title="เลือกที่อยู่จัดส่งสินค้า" data-bs-toggle="modal" data-bs-target="#SelectAddressProfileModal">
                    <i class="fa-solid fa-truck-fast fs-4 text-white"></i>
                </button>
            </div>
            <div class="col px-0 text-center my-auto">
                <div class="dropdown-center">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>&nbsp;บัญชีของฉัน
                    </button>
                    <ul class="dropdown-menu rounded-0 w-100">
                        <li><a class="dropdown-item" href="<?=rootURL();?>ข้อมูลสมาชิก/">ข้อมูลสมาชิก</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>ที่อยู่จัดส่ง/">ที่อยู่จัดส่ง</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>ตั้งค่าบัญชี/">ตั้งค่าบัญชี</a></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>คำสั่งซื้อ/">คำสั่งซื้อ</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?=rootURL();?>action/logout/">ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-2 text-center h-100 px-0 bg-theme-5 py-3">
                <a href="<?=rootURL();?>ตะกร้าสินค้า/" class="btn position-relative shoping-bag-icon p-0 text-white btn-tooltip" data-bs-title="รายการสินค้าที่สั่งซื้อ">
                    <i class="fa-solid fa-cart-shopping fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <span id="CartAmountMobile"><?=$HeaderCartCount;?></span>
                        <span class="visually-hidden">items in shopping cart</span>
                    </span>
                </a>
            </div>

            <?php
                } else {
            ?>

            <div class="col px-0">
                <button type="button" class="btn btn-theme-1 rounded-0 px-3 py-3 w-100 shadow" data-bs-toggle="modal" data-bs-target="#ModalMemberRequired"><i class="fa-regular fa-user"></i> &nbsp; สมัครสมาชิก / เข้าสู่ระบบ</button>
            </div>
                
            <?php
                }
            ?>

    </div>
</div>

<?php
    }
?>