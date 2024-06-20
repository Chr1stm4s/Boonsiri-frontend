<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "all-products";
        
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
                            <li class="breadcrumb-item active" aria-current="page">สินค้าทั้งหมด</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3 mb-4 mb-lg-0">
                    <div id="CardFilter">
                        <button class="btn btn-theme-2 w-100 mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="true" aria-controls="collapseCategory">
                            หมวดหมู่สินค้า &nbsp;<i class="fa-solid fa-chevron-up" id="CollapseCategoryIcon"></i>
                        </button>
                        <div class="collapse show" id="collapseCategory">
                            <div class="card shadow">
                                <div class="card-body">
                                    <ul class="product-category-list">

                                        <li class="active fw-bold"><i class="fa-solid fa-caret-right"></i>&nbsp; สินค้าทั้งหมดของบุญศิริ</li>

                                        <?php
                                            $CategoryMainRequest = [
                                                "whsCode" => (@$_SESSION['whsCode']) ? $_SESSION['whsCode'] : "SSK"
                                            ];

                                            $CategoryMain = connect_api("{$API_URL}category/list-category", $CategoryMainRequest);

                                            foreach ($CategoryMain['categories'] as $CategoryList) {
                                        ?>

                                        <li><a href="<?=rootURL();?>หมวดหมู่สินค้าบุญศิริ/<?=($CategoryList['url']) ? $CategoryList['url'] : str_replace(" ", "-", $CategoryList['title']);?>/<?=$CategoryList['id'];?>/" class="text-decoration-none d-block"><i class="fa-solid fa-caret-right"></i>&nbsp; <?=$CategoryList['itemCode'];?></a></li>

                                        <?php
                                            }
                                        ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col p-0">
                    <div class="row mx-0 mb-4">
                        <div class="col-12 col-md mt-auto mb-4 mb-md-auto text-center text-md-start">
                            <h1 class="fs-3 mb-0">สินค้าทั้งหมด</h1>
                        </div>
                        <div class="col-12 col-md-auto my-auto">
                            <form action="<?=rootURL();?>ค้นหาสินค้าบุญศิริ/" method="GET">
                                <div class="input-group">
                                    <input type="search" class="form-control form-sm" name="search" id="InputSearch" placeholder="ค้นหาสินค้า" required aria-required="true">
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
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script>
        const collapseCategory = document.getElementById('collapseCategory')

        collapseCategory.addEventListener('hidden.bs.collapse', event => {
            $("#CollapseCategoryIcon").removeClass("fa-chevron-up");
            $("#CollapseCategoryIcon").addClass("fa-chevron-down");
        });

        collapseCategory.addEventListener('shown.bs.collapse', event => {
            $("#CollapseCategoryIcon").removeClass("fa-chevron-down");
            $("#CollapseCategoryIcon").addClass("fa-chevron-up");
        });

        $("#ProductList").on("click", "#ButtonPrev", function() {
            const CurrentPage = $("#PageNumber").val();
            const page = CurrentPage - 1;

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(0, page, 12, itemSize);
        });

        $("#ProductList").on("click", "#ButtonNext", function() {
            const CurrentPage = $("#PageNumber").val();
            const page = parseInt(CurrentPage) + 1;

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(0, page, 12, itemSize);
        });

        $("#ProductList").on("change", "#PageNumber", function() {
            const page = $(this).val();

            const itemSize = $(".btn-item-size.active").data("item-size");

            fetchAndDisplayProducts(0, page, 12, itemSize);
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

        fetchAndDisplayProducts(0, 1, 12);
    </script>

</body>

</html>