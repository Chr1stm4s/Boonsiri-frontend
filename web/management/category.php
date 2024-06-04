<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "category";

        require_once "./head.php";

        if (@$_GET['id']) {
            $id = $_GET['id'];

            $apiUrl = "{$API_Link}api/v1/category/get-category-by-id";
            $dataAPI = [
                "categoryId" => $_GET['id'], 
                "whsCode" => ""
            ];

            $data = connect_api($apiUrl, $dataAPI);
    
            if ($data['responseCode'] != 000) {
                exit();
            }

            $key = $data['product'][0]['subCategory'];
            $title = 'Category - ' . $data['product'][0]['title'];

            $backButton = '<div class="col-auto my-auto"> <a href="./category.php" class="text-decoration-none text-dark"> <i class="fa-solid fa-caret-left fs-1"></i> </a> </div>';
        } else {
            $id = null;

            $apiUrl = "{$API_Link}api/v1/category/list-category";
            $dataAPI = null;

            $data = connect_api($apiUrl, $dataAPI);
    
            if ($data['responseCode'] != 000) {

                exit();
            }

            $key = $data['categories'];
            $title = 'Category';

            $subCategory = null;
            $backButton = null;
        }
    ?>

    <style>
        .btn-edit {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">

                <?=$backButton;?>

                <div class="col">
                    <h1 class="mb-0"><?=$title;?></h1>
                </div>
            </div>
            
            <div class="row">

            <?php
                foreach ($key as $category) {
                    $image = ($category['image'] && file_exists("../products/category/".$category['image'])) ? "../products/category/".$category['image'] : "../images/logo.png";
                    $subCategory = (count($category['subCategory']) == 0) ? null : '<div class="card-footer"> <a href="./category.php?id='.$category['id'].'" class="btn btn-primary w-100">ดูหมวดหมู่ย่อย</a> </div>';
            ?>

                <div class="col-12 col-xs-6 col-sm-4 col-md-3 col-lg-2 my-3">
                    <div class="card h-100 shadow position-relative" data-id="<?=$category['id'];?>" id="CategoryID<?=$category['id'];?>">
                        <button class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#CategoryModal" data-bs-id="<?=$category['id'];?>" data-bs-title="<?=$category['title'];?>" data-bs-description="<?=$category['description'];?>" data-bs-image="<?=$image;?>"><i class="fa-regular fa-pen-to-square"></i></button>
                        <img src="<?=$image;?>" alt="" class="card-img-top p-4">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><?=$category['title'];?></h5>
                        </div>

                        <?=$subCategory;?>
                    </div>
                </div>

            <?php
                }
            ?>

            </div>
        </div>
    </section>

    <div class="modal fade" id="CategoryModal" tabindex="-1" aria-labelledby="CategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CategoryModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="CategoryModalForm">
                        <input type="hidden" name="id" id="id">
                        <img src="" alt="" class="w-100 mb-3" id="CategoryImagePreview">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="image" id="InputCategoryImagePreview">
                            <label class="input-group-text" for="InputCategoryImagePreview">เลือกภาพ</label>
                        </div>
                        <small class="text-muted">ขนาดภาพที่แนะนำ 600x600 pixel</small>
                        <div class="my-3">
                            <label for="title" class="col-form-label">ชื่อหมวดหมู่</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="ชื่อหมวดหมู่">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">รายละเอียด</label>
                            <textarea name="description" id="description" class="form-control" placeholder="รายละเอียด"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="SubmitCategory">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            InputCategoryImagePreview.onchange = evt => {
            const [file] = InputCategoryImagePreview.files
                if (file) {
                    CategoryImagePreview.src = URL.createObjectURL(file)
                }
            }
        }, false);

        const CategoryModal = document.getElementById('CategoryModal')
        if (CategoryModal) {
            CategoryModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const title = button.getAttribute('data-bs-title')
                const description = button.getAttribute('data-bs-description')
                const image = button.getAttribute('data-bs-image')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalTitle = CategoryModal.querySelector('.modal-title')
                const inputId = CategoryModal.querySelector('#id')
                const inputTitle = CategoryModal.querySelector('#title')
                const inputDescription = CategoryModal.querySelector('#description')
                const ImagePreview = CategoryModal.querySelector('#CategoryImagePreview')

                modalTitle.textContent = `แก้ไขหมวดหมู่ ${title}`
                inputId.value = id
                inputTitle.value = title
                inputDescription.value = description
                inputDescription.textContent = description
                ImagePreview.src = image
            })

            CategoryModal.addEventListener('hidden.bs.modal', event => {
                document.getElementById("CategoryModalForm").reset();
            })
        }

        $('#SubmitCategory').click(function(e) {
            e.preventDefault();

            var form = $('#CategoryModalForm')[0];
            var data = new FormData(form);

            Swal.fire({
                title: 'กำลังทำงาน...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: './update/category.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
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
                            'ส่งข้อมูลล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'ส่งข้อมูลล้มเหลว!',
                        'กรุณาติดต่อเจ้าหน้าที่',
                        'error'
                    );
                }
            });
        });
    </script>

</body>

</html>