<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "articles";
        
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
                            <li class="breadcrumb-item active" aria-current="page">ข่าวสารและกิจกรรม</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-auto">
                    <h1 class="border-bottom border-2 border-info">บทความแนะนำล่าสุด</h1>
                </div>
            </div>

            <?php
                $APIRequest = [
                    'categoryId' => 0, 
                    "orderByColumn" => "id",
                    "orderBy" => "DESC",
                    "pageNo" => 1,
                    "pageSize" => 1
                ];

                $Response = connect_api("{$API_Link}api/v1/article/list-article", $APIRequest);

                if ($Response['responseCode'] == 000) {
                    $FeaturedArticle = $Response['articleCategories'][0];
            ?>

            <div class="row">
                <div class="col">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <img src="<?=rootURL();?>articles/<?=$FeaturedArticle['id'];?>/<?=$FeaturedArticle['thumbnail'];?>" alt="<?=$FeaturedArticle['title'];?>" class="w-100">
                                </div>
                                <div class="col-12 col-md-5 mx-auto py-4">
                                    <h3><?=$FeaturedArticle['title'];?></h3>
                                    <span class="badge bg-theme-2"><?=$FeaturedArticle['categoryId'];?></span>
                                    <br>
                                    <br>
                                    <p class="mb-4"><?=$FeaturedArticle['intro'];?></p>
                                    <a href="<?=rootURL();?>ข่าวสารและกิจกรรม/<?=$FeaturedArticle['id'];?>/<?=str_replace(" ", "-", $FeaturedArticle['title']);?>/" class="btn btn-theme-4 px-4">อ่านต่อ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                } else {
            ?>

            <div class="row">
                <div class="col text-center">
                    <h3 class="mb-0">ไม่มีข้อมูล</h3>
                </div>
            </div>

            <?php
                }
            ?>

        </div>
    </section>

    <hr>

    <?php
        $CategoryResponse = connect_api("{$API_Link}api/v1/article-category/list-article-category");

        if ($CategoryResponse['responseCode'] == 000) {
            foreach ($CategoryResponse['articleCategories'] as $Category) {
    ?>


    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-auto">
                    <h2 class="fs-1 border-bottom border-2 border-info"><?=$Category['title'];?></h2>
                </div>
            </div>
            <div class="row g-4">

            <?php
                $APIRequest = [
                    'categoryId' => $Category['id'], 
                    "orderByColumn" => "id",
                    "orderBy" => "DESC",
                    "pageNo" => 0,
                    "pageSize" => 0
                ];

                $ArticleResponse = connect_api("{$API_Link}api/v1/article/list-article", $APIRequest);

                if ($ArticleResponse['responseCode'] == 000) {
                    foreach ($ArticleResponse['articleCategories'] as $Articles) {
            ?>

                <div class="col-6 col-md-3">
                    <div class="card articles-list">
                        <img src="<?=rootURL();?>articles/<?=$Articles['id'];?>/<?=$Articles['thumbnail'];?>" alt="<?=$Articles['title'];?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?=$Articles['title'];?></h5>
                            <p class="card-text text-overflow overflow-4"><?=$Articles['intro'];?></p>
                        </div>
                        <div class="card-footer">
                            <a href="<?=rootURL();?>ข่าวสารและกิจกรรม/<?=$Articles['id'];?>/<?=str_replace(" ", "-", $Articles['title']);?>/" class="btn btn-theme-4 w-100">อ่านต่อ</a>
                        </div>
                    </div>
                </div>

            <?php
                    }
                } else {
            ?>

                <div class="col text-center">
                    <h3 class="mb-0">ไม่มีข้อมูล</h3>
                </div>

            <?php
                }
            ?>

            </div>
        </div>
    </section>

    <hr>

    <?php
            }
        } else {
    ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-auto">
                    <h2 class="fs-1 border-bottom border-2 border-info">ไม่มีข้อมูล</h2>
                </div>
            </div>
        </div>
    </section>

    <?php
        }
    ?>

    <?php require_once "./lead-form.php"; ?>
    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>