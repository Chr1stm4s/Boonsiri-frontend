<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "products";
        
        require_once "./head.php";

        $CategoryID = $_GET['title'];
        $WhsCode = (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK";

        $CategoryAPIDataRequest = [
            "whsCode" => $WhsCode, 
            'categoryId' => $CategoryID
        ];

        $CategoryMain = connect_api("$API_Link/v1/category/get-category-by-id", $CategoryAPIDataRequest);

        if ($CategoryMain['responseCode'] == 000) {
            $CategoryData = $CategoryMain['product'][0];
        } else {
            echo $CategoryMain['responseCode'];

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
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>สินค้าทั้งหมดของบุญศิริ/" class="text-theme-1 btn-hyper-link" >สินค้าทั้งหมดของบุญศิริ</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="text-theme-1 btn-hyper-link" >หมวดหมู่สินค้าทั้งหมด</a></li>

                            <?php
                                $BreadcrumbData = [
                                    "id" => $CategoryID,
                                ];

                                $Breadcrumb = connect_api("$API_Link/v1/category/breadcrumb", $BreadcrumbData);


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
            <div class="row">
                <div class="col p-0">

                    <?php
                        $APIURL = "$API_Link/v1/product/get-product-by-category-id";

                        $pageNo = 1;
                        $pageSize = 12;

                        $ProductAPIDataRequest = [
                            'categoryId' => $CategoryID, 
                            'whsCode' => $WhsCode, 
                            'orderByColumn' => "id",  
                            'orderBy' => "DESC", 
                            'pageNo' => 0, 
                            'pageSize' => 0
                        ];

                        $ResponseKey = 'product';

                        $TotalPage = 1;

                        $CategoryAPIDataResponse = connect_api($APIURL, $ProductAPIDataRequest);

                        if ($CategoryAPIDataResponse['responseCode'] == 000) {
                            $TotalPage = $CategoryAPIDataResponse['totalPage'];
                    ?>

                    <div class="row mx-0 mb-4" id="ItemSizeList">
                        <div class="col">

                            <button type="button" class="btn btn-item-size m-1 ms-0 active" data-item-size="">ทั้งหมด</button>

                            <?php
                                foreach ($CategoryAPIDataResponse['itemSize'] as $itemSize) {
                                    if ($itemSize != "") {
                            ?>

                            <button type="button" class="btn btn-item-size m-1 ms-0" data-item-size="<?=$itemSize;?>"><?=$itemSize;?></button>

                            <?php
                                    }
                                }
                            ?>

                        </div>
                    </div>

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

                    <div class="row mx-0 g-0" id="ProductList">
                        <div class="col py-5 text-center">
                            <i class="fa-solid fa-spinner fa-pulse fa-2x my-5"></i>
                        </div>
                    </div>

                    <?php
                        } else {
                    ?>

                    <h3 class="mb-0 text-center">ไม่พบข้อมูลสินค้า</h3>

                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script>
        $("#ItemSizeList").on("click", ".btn-item-size", function() {
            $(".btn-item-size").removeClass("active");

            const itemSize = $(this).data("item-size");

            fetchAndDisplayProducts(<?=$CategoryID;?>, 1, 12, itemSize);

            $(this).addClass("active");
        });

        $("#ProductList").on("click", "#ButtonPrev", function() {
            const CurrentPage = $("#PageNumber").val();
            const page = CurrentPage - 1;

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(<?=$CategoryID;?>, page, 12, itemSize);
        });

        $("#ProductList").on("click", "#ButtonNext", function() {
            const CurrentPage = $("#PageNumber").val();
            const page = parseInt(CurrentPage) + 1;
            const lastPage = <?=$TotalPage;?>

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(<?=$CategoryID;?>, page, 12, itemSize);
        });

        $("#ProductList").on("change", "#PageNumber", function() {
            const page = $(this).val();
            const lastPage = <?=$TotalPage;?>

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(<?=$CategoryID;?>, page, 12, itemSize);
        });

        function fetchAndDisplayProducts(categoryId, pageNo, pageSize, itemSize = '', orderByColumn = '', orderBy = '') {
            $("#ProductList").html(`<div class="col py-5 text-center"> <i class="fa-solid fa-spinner fa-pulse fa-2x my-5"></i> </div>`);
            
            var data = {
                categoryId: categoryId,
                itemSize: itemSize, 
                pageNo: pageNo, 
                pageSize: pageSize,
                orderByColumn: orderByColumn,
                orderBy: orderBy,
            };

            $.post(
                '<?=rootURL();?>fetch-products/', 
                data, 
                function(response) {
                    $('#ProductList').html(response);

                    $('html, body').animate({
                        scrollTop: $("#ProductList").offset().top - 230
                    }, 500);
                }
            );
        }

        fetchAndDisplayProducts(<?=$CategoryID;?>, 1, 12);
    </script>

</body>

</html>