<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "meta";

        require_once "./head.php";

        $id = $_GET['id'];

        $Request = [
            "id" => $id
        ];

        $Result = connect_api("{$API_URL}page/get-page", $Request);

        if ($Result['responseCode'] == "000") {
            $Meta = $Result['page'];

            $PageName = [
                1 => "หน้าแรก", 
                2 => "เกี่ยวกับเรา", 
                3 => "รับสมัครงาน", 
                4 => "บทความ", 
                5 => "ติดต่อเรา", 
                6 => "สินค้าทั้งหมด", 
                7 => "Privacy Policy", 
                8 => "ลงชื่อเข้าใช้งาน", 
                9 => "โปรโมชั่น", 
                10 => "หมวดหมู่สินค้าทั้งหมด", 
                11 => "สมัครสมาชิก", 
             ];

            $title = $PageName[$id];
        } else {
            echo var_dump($Result);
        }
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <form id="MetaForm">
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col my-auto">
                    <h1 class="mb-0">Meta Data - <?=$title;?></h1>
                </div>
                <div class="col-auto my-auto">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-6">
                    <input type="hidden" name="id" id="id" value="<?=$id;?>">
                    <input type="hidden" name="type" id="type" value="0">
                    <img src="../meta/<?=$Meta['cover'];?>" alt="<?=$Meta['title'];?>" class="w-100 mb-3" id="MetaImagePreview">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" name="cover" id="InputMetaImagePreview" required aria-required="true" multiple>
                        <label class="input-group-text" for="InputMetaImagePreview">เลือกภาพ</label>
                    </div>
                    <small class="text-muted">ขนาดภาพที่แนะนำ 1200x630 pixel</small>
                </div>
                <div class="col-6">
                    <div>
                        <label for="title" class="col-form-label">Title</label>
                        <input type="title" class="form-control" id="title" name="title" placeholder="Title" value="<?=$Meta['title'];?>">
                    </div>
                    <div class="my-3">
                        <label for="metaTitle" class="col-form-label">Meta Title</label>
                        <input type="metaTitle" class="form-control" id="metaTitle" name="metaTitle" placeholder="Meta Title" value="<?=$Meta['metaTitle'];?>">
                    </div>
                    <div class="my-3">
                        <label for="metaDescription" class="col-form-label">Meta Description</label>
                        <input type="metaDescription" class="form-control" id="metaDescription" name="metaDescription" placeholder="Meta Description" value="<?=$Meta['metaDescription'];?>">
                    </div>
                    <div>
                        <label for="keywords" class="col-form-label">Keywords</label>
                        <input type="keywords" class="form-control" id="keywords" name="keywords" placeholder="Keywords" value="<?=$Meta['keywords'];?>">
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            InputMetaImagePreview.onchange = evt => {
            const [file] = InputMetaImagePreview.files
                if (file) {
                    MetaImagePreview.src = URL.createObjectURL(file)
                }
            }
        }, false);

        $('#MetaForm').submit(function(e) {
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
                url: './update/meta.php',
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