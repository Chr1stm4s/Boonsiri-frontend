<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "jobs";
        
        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section>
        <div class="container my-auto">
            <div class="row header-jobs py-5">
                <div class="col text-center py-5">
                    <h1 class="mb-0 f-shadow text-white">ร่วมงานกับเรา</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ร่วมงานกับเรา</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">

            <?php
                $JobsAPIData = connect_api("{$API_Link}api/v1/job/list-job");

                if ($JobsAPIData['responseCode'] == "000") {
                    foreach ($JobsAPIData['jobCategories'] as $job) {
            ?>

                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row mx-0">
                                <div class="col-12 col-md">
                                    <h5>ตำแหน่ง <?=$job['title'];?></h5>
                                    <p class="mb-4 mb-md-0 text-overflow overflow-3">
                                        <b>รายละเอียดงาน : </b>
                                        <?=$job['description'];?>
                                    </p>
                                </div>
                                <div class="col-12 col-md-auto ms-auto">
                                    <a href="<?=rootURL();?>ร่วมงานกับเรา/<?=str_replace(" ", "-", $job['title']);?>/<?=$job['id'];?>/" class="btn btn-info px-4">รายละเอียดงาน</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
                    }
                } else {
            ?>

                <div class="col text-center">
                    <h4 class="fs-1 mb-0">ยังไม่มีตำแหน่งงานที่เปิดรับ</h4>
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

</body>

</html>