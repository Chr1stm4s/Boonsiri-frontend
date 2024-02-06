<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "about";
        
        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section>
        <div class="container">
            <div class="row header-about py-5">
                <div class="col text-center py-5">
                    <h1 class="mb-0 f-shadow text-white">เกี่ยวกับบุญศิริ</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">เกี่ยวกับเรา</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-5 mx-auto">
                    <img src="https://img.freepik.com/free-photo/close-up-japanese-street-food_23-2149287814.jpg?w=1380&t=st=1690377343~exp=1690377943~hmac=2b75354dde517fa26946c84b9eb732ac3eb32373e7ca03187cd99a12e389eda0" alt="เกี่ยวกับบุญศิริ" class="w-100 rounded-4">
                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <h2 class="fs-1">เกี่ยวกับบุญศิริ</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus eaque, odio magni ipsam a praesentium eveniet omnis qui? Dolorum molestiae recusandae, alias quam sint quisquam! At fugit exercitationem distinctio ipsam.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus eaque, odio magni ipsam a praesentium eveniet omnis qui? Dolorum molestiae recusandae, alias quam sint quisquam! At fugit exercitationem distinctio ipsam.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-info bg-opacity-10">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-5 mx-auto">
                    <h2 class="fs-1">ประวัติความเป็นมาบุญศิริ</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus eaque, odio magni ipsam a praesentium eveniet omnis qui? Dolorum molestiae recusandae, alias quam sint quisquam! At fugit exercitationem distinctio ipsam.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus eaque, odio magni ipsam a praesentium eveniet omnis qui? Dolorum molestiae recusandae, alias quam sint quisquam! At fugit exercitationem distinctio ipsam.</p>
                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <img src="https://img.freepik.com/free-photo/raw-fish-market_1398-2423.jpg?w=1380&t=st=1690377448~exp=1690378048~hmac=6dc4ac052de56fd818e3265ecdd24a7766e3733ebea3141cae09c87d1f41c71e" alt="เกี่ยวกับบุญศิริ" class="w-100 rounded-4">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-10 col-md-4 mx-auto">
                    <img src="https://img.freepik.com/free-photo/fresh-prawns_1398-806.jpg?w=1380&t=st=1690377607~exp=1690378207~hmac=727af0c0d4be537da33cfe68581b6a457ed03f5704171e51cb922f57d3624fde" alt="" class="w-100 rounded-4">
                </div>
            </div>
            <div class="row">
                <div class="col col-md-7 mx-auto text-center">
                    <h3 class="fs-1">ทำไมต้องบุญศิริ</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus eaque, odio magni ipsam a praesentium eveniet omnis qui? Dolorum molestiae recusandae, alias quam sint quisquam! At fugit exercitationem distinctio ipsam.</p>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga tempora magni, sit eos minus voluptates doloremque, iure illum minima quia doloribus odit. Dolorum nobis aspernatur aliquid perferendis at omnis quisquam?</p>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./lead-form.php"; ?>
    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>