<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "products";
        
        require_once "./head.php";

        $CategoryID = $_GET['id'];

        $CategoryAPIDataRequest = [
            'categoryId' => $CategoryID, 
            "whsCode" => (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK"
        ];

        $CategorySub = connect_api("{$API_URL}category/get-category-by-id", $CategoryAPIDataRequest);

        if ($CategorySub['responseCode'] == 000) {
            $CategoryData = $CategorySub['product'][0];
        } else {
            echo $CategorySub['responseCode'];

            exit();
        }

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
                                    "id" => $CategoryID,
                                ];

                                $Breadcrumb = connect_api("{$API_URL}category/breadcrumb", $BreadcrumbData);


                                foreach ($Breadcrumb['items'] as $key => $CategoryList) {
                                    if ($CategoryList['categoryId'] != $CategoryID) {
                            ?>

                                <li class="breadcrumb-item"><a href="<?=rootURL();?>หมวดหมู่สินค้าบุญศิริ/<?=$CategoryList['itemCode'];?>/<?=$CategoryList['categoryId'];?>/" class="text-theme-1 btn-hyper-link"><?=$CategoryList['itemCode'];?></a></li>

                            <?php
                                    }
                                }
                            ?>

                            <li class="breadcrumb-item active" aria-current="page"><?=$CategoryData['itemCode'];?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mx-0 mb-4">
                <div class="col-auto col-lg my-auto">
                    <h1 class="fs-3 mb-0"><?=$CategoryData['title'];?></h1>
                </div>
                <div class="col col-lg-auto my-auto">
                    <form action="<?=rootURL();?>ค้นหาสินค้าบุญศิริ/" method="GET">
                        <input type="hidden" name="categoryId" value="<?=$CategoryID;?>">
                        <div class="input-group">
                            <input type="search" class="form-control form-sm" name="search" id="InputSearch" placeholder="ค้นหาสินค้า">
                            <button type="submit" class="btn btn-outline-dark" id="ButtonSearch"><i class="fa-solid fa-magnifying-glass"></i> &nbsp;ค้นหา</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
            
            <?php
                foreach ($CategoryData['subCategory'] as $CategoryList) {
                    $image = ($CategoryList['image'] && file_exists("products/category/".$CategoryList['image'])) ? rootURL()."products/category/".$CategoryList['image'] : rootURL()."images/logo.png";
            ?>

                <div class="col-4 col-md-3 col-lg-2 my-3 text-center">
                    <a href="#" class="text-decoration-none text-dark product-link" data-url="<?=rootURL();?>สินค้าบุญศิริ/<?=($CategoryList['url']) ? $CategoryList['url'] : str_replace(" ", "-", $CategoryList['title']);?>/<?=$CategoryList['id'];?>/">
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