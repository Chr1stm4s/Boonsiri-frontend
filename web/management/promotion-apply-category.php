<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "category";

        $id = $_GET['id'];

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./promotions.php" class="btn fs-1"><i class="fa-regular fa-square-caret-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0">เลือกหมวดหมู่</h1>
                </div>
            </div>
            
            <div class="row">

            <?php
                $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/category/list-category";
                
                $data = connect_api($apiUrl);

                if ($data['responseCode'] == 000) {
                    foreach ($data['categories'] as $category) {
                        $image = ($category['image'] && file_exists("../products/category/".$category['image'])) ? "../products/category/".$category['image'] : "../images/logo.png";
            ?>

                <div class="col-12 col-xs-6 col-sm-4 col-md-3 col-lg-2 my-3">
                    <a href="./promotion-apply-products.php?id=<?=$id;?>&category=<?=$category['id'];?>" class="text-decoration-none">
                        <div class="card h-100 shadow position-relative">
                            <img src="<?=$image;?>" alt="" class="card-img-top p-4">
                            <div class="card-body">
                                <h5 class="card-title mb-0"><?=$category['title'];?></h5>
                            </div>
                        </div>
                    </a>
                </div>

            <?php
                    }
                }
            ?>

            </div>
        </div>
    </section>

    <?php require_once "./js.php"; ?>

</body>

</html>