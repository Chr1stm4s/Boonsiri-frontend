<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "articles";

        require_once "./head.php";

        $id = $_GET['id'];

        $ArticleCategoryRequest = [
            "id" => $id
        ];

        $ArticleCategoryData = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article-category/get-article-category", $ArticleCategoryRequest);

        if ($ArticleCategoryData['responseCode'] != "000") {
            var_dump($ArticleCategoryData);

            exit();
        }
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./articles.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">หมวดหมู่บทความ - <?=$ArticleCategoryData['articleCategory']['title'];?></h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ArticleCategoryModal" data-bs-category="<?=$id;?>" data-bs-id="0">เพิ่มบทความ</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th class="fit">รูปภาพ</th>
                                <th>ชื่อบทความ</th>
                                <th>เกริ่นนำ</th>
                                <th class="fit">เผยแพร่เมื่อ</th>
                                <th class="fit">ปรับปรุงล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/article/list-article";
                            $dataRequest = [
                                "categoryId" => $id,
                                "orderByColumn" => "",
                                "orderBy" => "",
                                "pageNo" => 0,
                                "pageSize" => 0
                            ];
                            
                            $data = connect_api($apiUrl, $dataRequest);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['articleCategories'] as $ArticleCategory) {
                                    $thumbnail = (file_exists("../articles/".$ArticleCategory['id']."/".$ArticleCategory['thumbnail']) && $ArticleCategory['thumbnail']) ? "../articles/".$ArticleCategory['id']."/".$ArticleCategory['thumbnail'] : "../images/logo.png";
                        ?>

                            <tr>
                                <th class="text-end"><?=$ArticleCategory['id'];?></th>
                                <td class="fit text-center"><img src="<?=$thumbnail;?>" class="article-thumbnail btn p-0" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>"></td>
                                <td><p class="mb-0 text-overflow" data-bs-toggle="tooltip" data-bs-title="<?=$ArticleCategory['title'];?>"><?=$ArticleCategory['title'];?></p></td>
                                <td><p class="mb-0 text-overflow" data-bs-toggle="tooltip" data-bs-title="<?=$ArticleCategory['intro'];?>"><?=$ArticleCategory['intro'];?></p></td>
                                <td class="fit text-center"><?=$ArticleCategory['published'];?></td>
                                <td class="fit text-center"><?=time_ago("th", $ArticleCategory['added']);?></td>
                                <td class="fit">
                                    <a href="<?=rootURL();?>ข่าวสารและกิจกรรม/<?=$ArticleCategory['id'];?>/<?=str_replace(" ", "-", $ArticleCategory['title']);?>/" class="btn btn-primary btn-tooltip" data-bs-title="ดูบทความ"><i class="fa-solid fa-eye"></i></a>
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-tooltip" 
                                        data-bs-title="แก้ไขบทความ" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#ArticleCategoryModal" 
                                        data-bs-category="<?=$id;?>" 
                                        data-bs-id="<?=$ArticleCategory['id'];?>" 
                                        data-bs-thumbnail-path="<?=$thumbnail;?>" 
                                        data-bs-thumbnail="<?=$ArticleCategory['thumbnail'];?>" 
                                        data-title="<?=$ArticleCategory['title'];?>"
                                        data-bs-intro="<?=$ArticleCategory['intro'];?>" 
                                        data-bs-meta-title="<?=$ArticleCategory['metaTitle'];?>" 
                                        data-bs-meta-description="<?=$ArticleCategory['metaDescription'];?>" 
                                        data-bs-keywords="<?=$ArticleCategory['keywords'];?>" 
                                    >
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <a href="./articles-details-list.php?id=<?=$ArticleCategory['id'];?>" class="btn btn-dark btn-tooltip" data-bs-title="จัดการเนื้อหาบทความ"><i class="fa-solid fa-file-pen"></i></a>
                                    <button type="button" class="btn btn-danger btn-tooltip btn-remove" data-id="<?=$ArticleCategory['id'];?>" data-bs-title="ลบบทความ"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>

                        <?php
                                    $i++;
                                }
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="PreviewThumbnailModal" tabindex="-1" aria-labelledby="PreviewThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" class="w-100" id="PreviewThumbnailModalIMG">
                </div>
            </div>
        </div>
    </div>

    <form action="#" method="post" id="EditArticleForm">
        <div class="modal fade" id="ArticleCategoryModal" tabindex="-1" aria-labelledby="ArticleCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ArticleCategoryModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="categoryId" id="categoryId">
                        <input type="hidden" name="thumbnail" id="thumbnail">
                        <img src="" alt="" class="w-100" id="ArticleCategoryModalThumbnail">
                        <div class="input-group my-3">
                            <input type="file" class="form-control" name="thumbnail" id="InputThumbnail" accept="image/*">
                            <label class="input-group-text" for="InputThumbnail">Upload</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="title" id="title" placeholder="ชื่อบทความ">
                            <label for="title">ชื่อบทความ</label>
                        </div>
                        <div class="form-floating my-3">
                            <textarea class="form-control" name="intro" placeholder="เกริ่นนำ" id="intro" style="height: 150px"></textarea>
                            <label for="intro">เกริ่นนำ</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="metaTitle" id="metaTitle" placeholder="META Title">
                            <label for="metaTitle">META Title</label>
                        </div>
                        <div class="form-floating my-3">
                            <textarea class="form-control" name="metaDescription" placeholder="META Description" id="metaDescription" style="height: 150px"></textarea>
                            <label for="metaDescription">META Description</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="keywords" id="keywords" placeholder="Keywords">
                            <label for="keywords">Keywords</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function() {
            $('#DataTables').DataTable({
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 
                    }
                ]
            });
        });

        $(".btn-remove").on("click", function() {
            const id = $(this).data("id");

            var data = {
                id: id,
            };

            Swal.fire({
                title: 'ต้องการลบข้อมูลนี้ใช่ไหม?',
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

                    $.ajax({
                        url: "https://www.ecmapi.boonsiri.co.th/api/v1/article/delete-article",
                        type: "POST",
                        data: JSON.stringify(data),
                        contentType: "application/json; charset=utf-8",
                        dataType: "JSON",
                        success: function(result) {
                            Swal.close();

                            if(result.responseCode == '000') {
                                Swal.fire(
                                    'ลบข้อมูลเรียบร้อย!',
                                    'ระบบจะทำการรีเฟรชหน้าใหม่',
                                    'success'
                                ).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting your records.',
                                    'error'
                                );

                                console.log(result)
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

        InputThumbnail.onchange = evt => {
            const [file] = InputThumbnail.files
            if (file) {
                ArticleCategoryModalThumbnail.src = URL.createObjectURL(file)
            }
        }

        const PreviewThumbnailModal = document.getElementById('PreviewThumbnailModal')
        if (PreviewThumbnailModal) {
            PreviewThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const img = button.getAttribute('data-bs-img')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const PreviewThumbnailModalIMG = PreviewThumbnailModal.querySelector('#PreviewThumbnailModalIMG')

                PreviewThumbnailModalIMG.src = img
            })
        }

        $('#EditArticleForm').on("submit", function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);

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

            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: './insert/article.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'เพิ่มบทความสำเร็จ!',
                            'เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'เพิ่มบทความล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'เพิ่มบทความล้มเหลว!',
                        'กรุณาติดต่อเจ้าหน้าที่',
                        'error'
                    );

                    console.log(e)
                }
            });
        });

        const ArticleCategoryModal = document.getElementById('ArticleCategoryModal')
        if (ArticleCategoryModal) {
            ArticleCategoryModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                
                const id = button.getAttribute('data-bs-id')
                const category = button.getAttribute('data-bs-category')
                const thumbnail = button.getAttribute('data-bs-thumbnail')
                const thumbnailPath = button.getAttribute('data-bs-thumbnail-path')
                const title = button.getAttribute('data-title')
                const intro = button.getAttribute('data-bs-intro')
                const metaTitle = button.getAttribute('data-bs-meta-title')
                const metaDescription = button.getAttribute('data-bs-meta-description')
                const keywords = button.getAttribute('data-bs-keywords')
                
                const modalTitle = ArticleCategoryModal.querySelector('.modal-title')
                const modalBodyInputID = ArticleCategoryModal.querySelector('#id')
                const modalBodyInputCategoryID = ArticleCategoryModal.querySelector('#categoryId')
                const modalArticleCategoryModalThumbnail = ArticleCategoryModal.querySelector('#ArticleCategoryModalThumbnail')
                const modalBodyInputThumbnail = ArticleCategoryModal.querySelector('#thumbnail')
                const modalBodyInputTitle = ArticleCategoryModal.querySelector('#title')
                const modalBodyInputIntro = ArticleCategoryModal.querySelector('#intro')
                const modalBodyInputMetaTitle = ArticleCategoryModal.querySelector('#metaTitle')
                const modalBodyInputMetaDescription = ArticleCategoryModal.querySelector('#metaDescription')
                const modalBodyInputKeywords = ArticleCategoryModal.querySelector('#keywords')

                modalTitle.textContent = (id == 0) ? "เพิ่มบทความ" : `แก้ไขบทความ: ${title}`
                modalBodyInputID.value = id
                modalBodyInputCategoryID.value = category
                modalArticleCategoryModalThumbnail.src = thumbnailPath
                modalBodyInputThumbnail.value = thumbnail
                modalBodyInputTitle.value = title
                modalBodyInputIntro.value = intro
                modalBodyInputMetaTitle.value = metaTitle
                modalBodyInputMetaDescription.value = metaDescription
                modalBodyInputKeywords.value = keywords
            })
        }
    </script>

</body>

</html>