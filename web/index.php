<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "home";
        
        require_once "./head.php";
    ?>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body class="bg-light">
    
    <?php require_once "./header.php"; ?>

    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md my-2 pe-md-2">
                    <div id="carouselHomeHeaderIndicators" class="carousel slide">
                        <div class="carousel-indicators">

                        <?php
                            $BannerAPIURL = "https://www.ecmapi.boonsiri.co.th/api/v1/banner/list-banner";
                            
                            $BannerAPIRequest = [
                                'location' => 1, 
                            ];

                            $BannerAPIData = connect_api($BannerAPIURL, $BannerAPIRequest);
                            
                            $count = 0;

                            foreach ($BannerAPIData['banners'] as $banners) {
                        ?>

                            <button type="button" data-bs-target="#carouselHomeHeaderIndicators" data-bs-slide-to="<?=$count;?>" class="<?=($count == 0) ? 'active' : ''; ?>" aria-current="<?=($count == 0) ? 'true' : ''; ?>" aria-label="Slide <?=$count+1;?>"></button>

                        <?php
                                $count++;
                            }
                        ?>

                        </div>
                        <div class="carousel-inner">

                        <?php
                            $count = 0;

                            foreach ($BannerAPIData['banners'] as $banners) {
                        ?>

                            <div class="carousel-item <?=($count == 0) ? 'active' : ''; ?>">
                                <a href="<?=$banners['url'];?>">
                                    <img src="<?=rootURL();?>slideshows/home/header-1/<?=$banners['image'];?>" class="d-block w-100" alt="<?=$banners['altText'];?>">
                                </a>
                            </div>

                        <?php
                                $count++;
                            }
                        ?>
                        
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselHomeHeaderIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselHomeHeaderIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-12 col-md-4 my-2 ps-md-2">
                    <div id="carouselHomeHeaderIndicators2" class="carousel slide mb-3">
                        <div class="carousel-inner">

                        <?php
                            $BannerAPIRequest = [
                                'location' => 2, 
                            ];

                            $count = 0;

                            $BannerAPIData = connect_api($BannerAPIURL, $BannerAPIRequest);

                            foreach ($BannerAPIData['banners'] as $banners) {
                        ?>

                            <div class="carousel-item <?=($count == 0) ? 'active' : ''; ?>">
                                <a href="<?=$banners['url'];?>">
                                    <img src="<?=rootURL();?>slideshows/home/header-2/<?=$banners['image'];?>" class="d-block w-100 slidessss" alt="<?=$banners['altText'];?>">
                                </a>
                            </div>

                        <?php
                                $count++;
                            }
                        ?>
                        
                        </div>
                    </div>
                    <div id="carouselHomeHeaderIndicators3" class="carousel slide">
                        <div class="carousel-inner">

                        <?php
                            $BannerAPIRequest = [
                                'location' => 3, 
                            ];

                            $count = 0;

                            $BannerAPIData = connect_api($BannerAPIURL, $BannerAPIRequest);

                            foreach ($BannerAPIData['banners'] as $banners) {
                        ?>

                            <div class="carousel-item <?=($count == 0) ? 'active' : ''; ?>">
                                <a href="<?=$banners['url'];?>">
                                    <img src="<?=rootURL();?>slideshows/home/header-3/<?=$banners['image'];?>" class="d-block w-100 slidessss" alt="<?=$banners['altText'];?>">
                                </a>
                            </div>

                        <?php
                                $count++;
                            }
                        ?>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 home-category">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h3 class="mb-0 fs-1">หมวดหมู่สินค้า</h3>
                </div>
            </div>
            <div class="row">
            
            <?php
                $categoryRequest = [
                    "whsCode" => @$_SESSION['whsCode']
                ];

                $CategoryMain = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/category/list-category", $categoryRequest);

                foreach ($CategoryMain['categories'] as $CategoryList) {
                    $image = ($CategoryList['image'] && file_exists("products/category/".$CategoryList['image'])) ? rootURL()."products/category/".$CategoryList['image'] : rootURL()."images/logo.png";
            ?>

                <div class="col-3 col-md-2 col-lg-1 my-3 text-center">
                    <a href="<?=rootURL();?>หมวดหมู่สินค้าบุญศิริ/<?=($CategoryList['url']) ? $CategoryList['url'] : str_replace(" ", "-", $CategoryList['title']);?>/<?=$CategoryList['id'];?>/" class="text-decoration-none text-dark">
                        <img src="<?=$image;?>" alt="<?=$CategoryList['title'];?>" class="w-100 mb-2">
                        <p class="mb-0"><?=$CategoryList['title'];?></p>
                    </a>
                </div>

            <?php
                }
            ?>

            </div>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="row home-products-recommended g-3 g-md-4">

            <?php
            
                $FeaturedAPIRequest = [
                    'location' => 1, 
                ];

                $FeaturedAPIData = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/featured/list-featured", $FeaturedAPIRequest);

                foreach ($FeaturedAPIData['featureds'] as $featured) {
            ?>

                <div class="col-6 col-md-4">
                    <a href="<?=$featured['url'];?>" class="text-decoration-none text-theme-4">
                        <div class="card">
                            <img src="<?=rootURL();?>featured/<?=$featured['image'];?>" alt="<?=$featured['altText'];?>" class="card-img-top">
                        </div>
                    </a>    
                </div>

            <?php
                }
            ?>
            
            </div>
        </div>
    </section>

    <section class="py-5 home-products-promotion">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h3 class="fs-1 mb-0">สินค้าลดราคา</h3>
                </div>
                <div class="col-auto my-auto">
                    <a href="<?=rootURL();?>สินค้าลดราคา/" class="btn btn-theme-1 px-3">ดูทั้งหมด</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col">
                    
                    <?php
                        $requestData = [
                            "promotionId" => 0, 
                            "whsCode" => "SSK", 
                            "orderByColumn" => "", 
                            "orderBy" => "", 
                            "pageNo" => 1, 
                            "pageSize" => 8, 
                        ];

                        $HomeProductsPromotion = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/product/get-product-by-promotion-id", $requestData);

                        if ($HomeProductsPromotion['responseCode'] == 000) {
                    ?>

                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">

                            <?php
                                foreach ($HomeProductsPromotion['product'] as $HomeProductsPromotion) {
                                    $thumbnail = (file_exists("products/".$HomeProductsPromotion['thumbnail'])) ? rootURL()."products/".$HomeProductsPromotion['thumbnail'] : rootURL()."images/logo.png";
                                    $placeholder = (file_exists("products/".$HomeProductsPromotion['thumbnail'])) ? "" : "thumbnail-placeholder";
                            ?>

                            <!-- Slides -->
                            <div class="swiper-slide">
                                <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$HomeProductsPromotion['id'];?>/<?=str_replace(" ", "-", $HomeProductsPromotion['title']);?>/" class="text-decoration-none">
                                    <div class="card h-100">
                                        <img src="<?=$thumbnail;?>" alt="<?=$HomeProductsPromotion['title'];?>" class="card-img-top <?=$placeholder;?>" loading="lazy">
                                        <div class="card-body">
                                            <h5 class="card-title text-dark mb-0"><?=$HomeProductsPromotion['title'];?></h5>
                                        </div>
                                        <div class="card-footer bg-white border-0 p-2">

                                        <?php
                                            if ($HomeProductsPromotion['preOrder'] == 1) {
                                        ?>

                                            <p class="card-text text-theme-5 fw-bold mb-0 price-preorder">สินค้าชั่งน้ำหนัก</p>

                                        <?php
                                            } else {
                                                if ($HomeProductsPromotion['promotionId'] != 0) {
                                        ?>

                                            <p class="card-text mb-0">
                                                <small class="text-decoration-line-through text-secondary"><?=number_format($HomeProductsPromotion['price']);?> บาท</small> 
                                                &nbsp;
                                                <span class="text-danger price-discount"><?=number_format($HomeProductsPromotion['lastPrice']);?></span> บาท
                                            </p>

                                            <?php
                                                } else {
                                            ?>

                                            <p class="card-text text-theme-5 mb-0"><?=number_format($HomeProductsPromotion['price']);?> บาท</p>

                                        <?php
                                                }
                                            }
                                        ?>

                                        </div>
                                    </div>
                                </a>
                            </div>

                            <?php
                                }
                            ?>

                        </div>

                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>

                    <?php
                        } else {
                    ?>

                    <div class="card shadow h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0 fs-1">ไม่พบข้อมูล</h5>
                        </div>
                    </div>           

                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <section class="py-5 home-feature">
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <h3 class="fs-1 mb-0">ซื้อสินค้าบุญศิริดียังไง?</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card w-100">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-1.svg" alt="บริการจัดส่งทันที" class="rounded-circle mb-4">
                                    <h5>บริการจัดส่งทันที</h5>
                                    <p class="fw-light mb-0">
                                        บริการจัดส่งสินค้า ทั้งแบบชั่วโมงถัดไปหรือวันถัดไป
                                    </p>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-2.svg" alt="ใส่ใจทุกขั้นตอน" class="rounded-circle mb-4">
                                    <h5>ใส่ใจทุกขั้นตอน</h5>
                                    <p class="fw-light mb-0">
                                        เพราะเราใส่ใจกับทุกรายละเอียดตั้งแต่การเลือกจนถึงการส่งสินค้าถึงมือคุณ
                                    </p>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-3.svg" alt="รับประกันความสดใหม่" class="rounded-circle mb-4">
                                    <h5>รับประกันความสดใหม่</h5>
                                    <p class="fw-light mb-0">
                                        เพราะเราคัดสรรสินค้าที่ดีและมีคุณภาพสูงที่สุดให้กับคุณ
                                    </p>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-4.svg" alt="สินค้าที่คุณสั่งซื้อเป็นประจำ" class="rounded-circle mb-4">
                                    <h5>สินค้าที่คุณสั่งซื้อเป็นประจำ</h5>
                                    <p class="fw-light mb-0">
                                        ง่ายและสะดวกรวดเร็วกว่าเดิม เพื่อให้คุณประหยัดเวลายิ่งขึ้น
                                    </p>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-5.svg" alt="สิทธิประโยชน์จากสมาชิกบุญศิริ" class="rounded-circle mb-4">
                                    <h5>สิทธิประโยชน์จากสมาชิกบุญศิริ</h5>
                                    <p class="fw-light mb-0">
                                        เพื่อให้คุณสะสมแต้มและรับสิทธิประโยชน์มากมายที่ครอบคลุมไลฟ์สไตล์ของคุณ
                                    </p>
                                </div>
                                <div class="col-4 col-md-3 col-lg-2 text-center my-2">
                                    <img src="<?=rootURL();?>images/feature-6.svg" alt="ช็อปสะดวกได้ทุกที่ ทุกเวลา" class="rounded-circle mb-4">
                                    <h5>ช็อปสะดวกได้ทุกที่ ทุกเวลา</h5>
                                    <p class="fw-light mb-0">
                                        สั่งซื้อสินค้าได้ทุกที่ ทุกเวลา ผ่านทางเว็บไซต์และแอปพลิเคชั่น
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col text-center">
                    <h5 class="fs-1 text-theme-5 mb-0">ข้อมูลและข่าวสาร</h5>
                </div>
            </div>
            <div class="row">
                    
                <?php
                    $requestData = [
                        "categoryId" => 0, 
                        "orderByColumn" => "", 
                        "orderBy" => "", 
                        "pageNo" => 1, 
                        "pageSize" => 4, 
                    ];

                    $HomeArticles = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article/list-article", $requestData);

                    if ($HomeArticles['responseCode'] == 000) {
                        foreach ($HomeArticles['articleCategories'] as $HomeArticlesData) {
                ?>

                <div class="col-6 col-md-4 col-lg-3 my-3">
                    <a href="<?=rootURL();?>ข่าวสารและกิจกรรม/<?=$HomeArticlesData['id'];?>/<?=str_replace(" ", "-", $HomeArticlesData['title']);?>/" class="text-decoration-none">
                        <div class="card h-100">
                            <img src="<?=rootURL();?>articles/<?=$HomeArticlesData['id'];?>/<?=$HomeArticlesData['thumbnail'];?>" alt="<?=$HomeArticlesData['title'];?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-overflow overflow-2"><?=$HomeArticlesData['title'];?></h5>
                                <p class="card-text text-overflow overflow-3"><?=$HomeArticlesData['intro'];?></p>
                            </div>
                        </div>
                    </a>
                </div>

                <?php
                        }
                    } else {
                ?>

                <div class="col text-center">
                    <p class="fs-1 mb-0">ไม่มีข้อมูล</p>
                </div>

                <?php
                    }
                ?>

            </div>
        </div>
    </section>

    <?php require_once "./lead-form.php"; ?>
    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            slidesPerView: 6,
            centeredSlides: false,
            spaceBetween: 20,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 3,
                    spaceBetween: 5,
                },
                1280: {
                    slidesPerView: 4,
                },
                1600: {
                    slidesPerView: 6,
                },
            },
        });
    </script>

</body>

</html>