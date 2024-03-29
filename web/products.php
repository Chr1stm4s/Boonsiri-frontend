<!doctype html>
<html lang="en">

<head>

    <?php
        $page = "products";
        
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
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>สินค้าทั้งหมดของบุญศิริ/" class="text-theme-1">สินค้าทั้งหมดของบุญศิริ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">หมวดหมู่สินค้าทั้งหมด</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
            
            <?php
                $categoryRequest = [
                    "whsCode" => (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK"
                ];

                $CategoryMain = connect_api("https://ecmapi.boonsiri.co.th/api/v1/category/list-category", $categoryRequest);

                foreach ($CategoryMain['categories'] as $CategoryList) {
                    $image = ($CategoryList['image'] && file_exists("products/category/".$CategoryList['image'])) ? rootURL()."products/category/".$CategoryList['image'] : rootURL()."images/logo.png";
            ?>

                <div class="col-4 col-md-3 col-lg-2 my-3 text-center">
                    <a href="<?=rootURL();?>หมวดหมู่สินค้าบุญศิริ/<?=($CategoryList['url']) ? $CategoryList['url'] : str_replace(" ", "-", $CategoryList['title']);?>/<?=$CategoryList['id'];?>/" class="text-decoration-none text-dark">
                        <img src="<?=$image;?>" alt="<?=$CategoryList['title'];?>" class="w-100">
                        <p class="mb-0"><?=$CategoryList['title'];?></p>
                    </a>
                </div>

            <?php
                }
            ?>

            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>