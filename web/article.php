<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "article";
        
        require_once "./head.php";

        $id = $_GET['id'];

        $APIRequest = [
            'id' => $id, 
        ];

        $Response = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article/get-article", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $Article = $Response['article'];
        } else {
            redirect(rootURL());
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>ข่าวสารและกิจกรรม/" class="text-theme-1">ข่าวสารและกิจกรรม</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$Article['title'];?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-11 col-md-6 mx-auto">
                    <img src="<?=rootURL();?>articles/<?=$Article['id'];?>/<?=$Article['thumbnail'];?>" alt="<?=$Article['title'];?>" class="w-100 rounded-4">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <h1 class="mb-0"><?=$Article['title'];?></h1>
                </div>
                <div class="col-auto ps-0 my-auto">
                    <a href="#" class="text-primary"><i class="fa-2x fa-brands fa-square-facebook"></i></a>
                </div>
                <div class="col-auto ps-0 my-auto">
                    <a href="#" class="text-success"><i class="fa-2x fa-brands fa-line"></i></a>
                </div>
                <div class="col-auto ps-0 my-auto">
                    <a href="#" class="text-warning"><i class="fa-2x fa-solid fa-link"></i></a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h4 class="fw-bold">สารบัญ</h4>
                    <ul class="mb-0">

                    <?php
                        $ArticleHeaderAPIRequest = [
                            'articleId' => $id, 
                        ];

                        $ArticleHeaderResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article-detail/list-article-detail", $ArticleHeaderAPIRequest);

                        if ($ArticleHeaderResponse['responseCode'] == 000) {
                            foreach ($ArticleHeaderResponse['articleDetails'] as $ArticleHeader) {
                    ?>

                        <li class="index-list"><a href="#Section<?=$ArticleHeader['id'];?>"><?=$ArticleHeader['header'];?></a></li>

                    <?php
                            }
                        } else {
                    ?>

                        <li class="index-list">ไม่มีข้อมูล</li>
                    
                    <?php
                        }
                    ?>
                    
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </section>

    <?php
        if ($ArticleHeaderResponse['responseCode'] == 000) {
            foreach ($ArticleHeaderResponse['articleDetails'] as $ArticleDetails) {
                if ($ArticleDetails['type'] == 1) {
    ?>

    <section class="article-details py-5" id="Section<?=$ArticleDetails['id'];?>">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h5 class="fw-bold"><?=$ArticleDetails['header'];?></h5>
                    <?=$ArticleDetails['content'];?>
                </div>
            </div>
        </div>
    </section>

    <?php
                } elseif ($ArticleDetails['type'] == 2) {
    ?>

    <section class="article-details py-5" id="Section<?=$ArticleDetails['id'];?>">
        <div class="container">
            <div class="row">
                <div class="col">
                    <img src="<?=rootURL();?>articles/<?=$id;?>/<?=$ArticleDetails['content'];?>" alt="<?=$ArticleDetails['header'];?>" class="w-100">
                </div>
            </div>
        </div>
    </section>

    <?php
                }
            }
        } else {
    ?>

    <section class="article-details py-5" id="Section">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h5 class="mb-0">ไม่มีข้อมูล</h5>
                </div>
            </div>
        </div>
    </section>

    <?php
        }
    ?>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card bg-theme-3 shadow border-0">
                        <div class="card-body p-3 p-md-5">
                            <div class="row mb-4">
                                <div class="col-auto">
                                    <h2 class="fs-1 border-bottom border-2 border-info">ข่าวสารและกิจกรรมอื่นๆ ที่น่าสนใจ</h2>
                                </div>
                            </div>
                            <div class="row g-4">

                            <?php
                                $APIRequest = [
                                    'categoryId' => $Article['categoryId'], 
                                    "orderByColumn" => "id",
                                    "orderBy" => "DESC",
                                    "pageNo" => 1,
                                    "pageSize" => 12
                                ];

                                $RelateArticleResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article/list-article", $APIRequest);

                                if ($RelateArticleResponse['responseCode'] == 000) {
                                    foreach ($RelateArticleResponse['articleCategories'] as $RelateArticles) {
                            ?>

                                <div class="col-6 col-md-3">
                                    <div class="card articles-list border-0">
                                        <img src="<?=rootURL();?>articles/<?=$RelateArticles['id'];?>/<?=$RelateArticles['thumbnail'];?>" alt="<?=$RelateArticles['title'];?>" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title text-overflow"><?=$RelateArticles['title'];?></h5>
                                            <p class="card-text text-overflow overflow-3"><?=$RelateArticles['intro'];?></p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="<?=rootURL();?>ข่าวสารและกิจกรรม/<?=$RelateArticles['id'];?>/<?=str_replace(" ", "-", $RelateArticles['title']);?>/" class="btn btn-theme-4 w-100">อ่านต่อ</a>
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./lead-form.php"; ?>
    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>