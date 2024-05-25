<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "category";

        require_once "./head.php";

        $api = $_GET['api'];
        $location = $_GET['location'];
        $size = $_GET['size'];

        $APIRequest = [
            "banner" => [
                'url' => '$API_Link/v1/banner/list-banner', 
                'key' => 'banners', 
                'path' => 'slideshows/home/header-'.$location.'/', 
                'title' => 'Header Home', 
                'update' => '$API_Link/v1/banner/update-banner', 
                'request' => [
                    "location" => $location
                ]
            ], 
            "featured" => [
                'url' => '$API_Link/v1/featured/list-featured', 
                'key' => 'featureds', 
                'path' => 'featured/', 
                'title' => 'Home Featured Section', 
                'update' => '$API_Link/v1/featured/update-featured', 
                'request' => [
                    "location" => $location
                ]
            ], 
        ];
        
        $data = connect_api($APIRequest[$api]['url'], $APIRequest[$api]['request']);

        $resolution = [
            "header" => '1200x585', 
            "header-x" => '840x404', 
            "featured" => '1000x600'
        ]
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Banners - <?=$APIRequest[$api]['title'];?></h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#BannerModal">เพิ่มภาพ</button>
                </div>
            </div>
            
            <div class="row">

            <?php
                if ($data['responseCode'] == 000) {
                    foreach ($data[$APIRequest[$api]['key']] as $banner) {
            ?>

                <div class="col-12 col-xs-6 col-sm-4 col-md-3 col-lg-2 my-3" data-id="<?=$banner['id'];?>" id="BannerID<?=$banner['id'];?>">
                    <form action="#" method="post" class="alt-text-form h-100">
                        <div class="card h-100 shadow position-relative">
                            <input type="hidden" name="id" value="<?=$banner['id'];?>">
                            <input type="hidden" name="APIURL" value="<?=$APIRequest[$api]['update'];?>">
                            <img src="<?=rootURL().$APIRequest[$api]['path'].$banner['image'];?>" alt="" class="card-img-top">
                            <div class="card-body d-flex flex-column">
                                <div class="form-floating mb-3 mt-auto">
                                    <input type="url" name="url" class="form-control" placeholder="URL" value="<?=$banner['url'];?>">
                                    <label for="floatingInput">URL</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" name="altText" class="form-control" placeholder="คำอธิบายภาพ" value="<?=$banner['altText'];?>">
                                    <label for="floatingInput">คำอธิบายภาพ</label>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-success btn-save w-100">บันทึก</button>
                                    </div>
                                    <div class="col-auto ps-0">
                                        <button type="button" class="btn btn-danger btn-delete btn-tooltip" data-bs-id="<?=$banner['id'];?>" data-bs-title="ลบภาพ" ><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            <?php
                    }
                } elseif ($data['responseCode'] ==  "A03") {
            ?>

                <div class="col text-center">
                    <h5 class="mb-0">ยังไม่มีภาพ Banner</h5>
                </div>

            <?php
                } else {
                    var_dump($APIRequest);
                    var_dump($data);
                }
            ?>

            </div>
        </div>
    </section>

    <form id="BannerModalForm">
        <div class="modal fade" id="BannerModal" tabindex="-1" aria-labelledby="BannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="BannerModalLabel">เพิ่มภาพ Banners</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="api" id="api" value="<?=$api;?>">
                        <input type="hidden" name="location" id="location" value="<?=$location;?>">
                        <img src="" alt="" class="w-100 mb-3" id="BannerImagePreview">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="image[]" id="InputBannerImagePreview" required aria-required="true" multiple>
                            <label class="input-group-text" for="InputBannerImagePreview">เลือกภาพ</label>
                        </div>
                        <small class="text-muted">ขนาดภาพที่แนะนำ <?=$resolution[$size];?> pixel</small>
                        <div class="my-3">
                            <label for="url" class="col-form-label">ลิ้งค์</label>
                            <input type="url" class="form-control" id="url" name="url" placeholder="URL">
                        </div>
                        <div class="my-3">
                            <label for="altText" class="col-form-label">คำอธิบายภาพ</label>
                            <input type="text" class="form-control" id="altText" name="altText" placeholder="คำอธิบายภาพ" required aria-required="true">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            InputBannerImagePreview.onchange = evt => {
            const [file] = InputBannerImagePreview.files
                if (file) {
                    BannerImagePreview.src = URL.createObjectURL(file)
                }
            }
        }, false);

        $(".btn-delete").click(function() {
            const id = $(this).data("bs-id");
            const api = "<?=$api;?>";
            const url = (api == "banner") ? "$API_Link/v1/banner/delete-banner" : "$API_Link/v1/featured/delete-featured";
            
            Swal.fire({
                title: `ต้องการลบภาพนี้ใช่ไหม?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FF5733',
                cancelButtonColor: '#000',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'กำลังดำเนินการ...',
                        showDenyButton: false,
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const ConfirmData = {
                        "id": id, 
                    };

                    const headers = {
                        'Content-Type': 'application/json'
                    };

                    const requestOptions = {
                        method: 'POST',
                        headers: headers,
                        body: JSON.stringify(ConfirmData)
                    };

                    fetch(url, requestOptions)
                    .then(response => response.json())
                    .then(
                        obj => {
                            if (obj.responseCode === "000") {
                                Swal.fire(
                                    `ยืนยันลบภาพนี้สำเร็จ!`,
                                    ``,
                                    'success'
                                ).then(function() {
                                    $(`#BannerID${id}`).remove();
                                });
                            } else {
                                Swal.fire(
                                    `ยืนยันลบภาพนี้ไม่สำเร็จ!`,
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );
                            }
                        }
                    )
                    .catch(
                        error => {
                            console.error('Error:', error);
                        }
                    );
                }
            });
        });

        $('.alt-text-form').submit(function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);

            Swal.fire({
                title: 'กำลังส่งข้อมูล...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: './update/banners.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'บันทึกข้อมูลล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'ส่งข้อมูลล้มเหลว!',
                        'กรุณาติดต่อเจ้าหน้าที่',
                        'error'
                    );

                    console.log(e)
                }
            });
        });

        $('#BannerModalForm').submit(function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);

            Swal.fire({
                title: 'กำลังส่งข้อมูล...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: './insert/banners.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'บันทึกข้อมูลล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'ส่งข้อมูลล้มเหลว!',
                        'กรุณาติดต่อเจ้าหน้าที่',
                        'error'
                    );

                    console.log(e)
                }
            });
        });
    </script>

</body>

</html>