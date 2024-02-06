<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "articles";

        require_once "./head.php";

        $id = $_GET['id'];

        $ArticleDataRequest = [
            "id" => $id
        ];

        $ArticleDataResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article/get-article", $ArticleDataRequest);

        if ($ArticleDataResponse['responseCode'] == "000") {
            $ArticleData = $ArticleDataResponse['article'];
        } else {
            var_dump($ArticleDataResponse);

            exit();
        }
    ?>

    <script src="https://cdn.tiny.cloud/1/u91050fzj02e3pcqppumc8iwx4nanmnh3o67dxmrou3s4nff/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./articles-list.php?id=<?=$ArticleData['categoryId'];?>" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">บทความ - <?=$ArticleData['title'];?></h1>
                </div>
                <div class="col-auto px-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ArticleContentTextModal" data-bs-id="<?=$id;?>" data-bs-id="0">เพิ่มเนื้อหา</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#ArticleContentImageModal" data-bs-id="<?=$id;?>" data-bs-id="0">เพิ่มรูปภาพ</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th>หัวข้อ</th>
                                <th>เนื้อหา</th>
                                <th class="fit">เพิ่มเมื่อ</th>
                                <th class="fit">ปรับปรุงล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/article-detail/list-article-detail";
                            $dataRequest = [
                                "articleId" => $id,
                            ];
                            
                            $data = connect_api($apiUrl, $dataRequest);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['articleDetails'] as $Article) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$Article['id'];?></th>
                                <td class="fit"><p class="mb-0 text-overflow" data-bs-toggle="tooltip" data-bs-title="<?=$Article['header'];?>"><?=$Article['header'];?></p></td>
                                <td>

                                    <?php
                                        if ($Article['type'] == 1) {
                                    ?>

                                    <p class="mb-0 text-overflow" data-bs-toggle="tooltip" data-bs-title="<?=strip_tags($Article['content']);?>"><?=strip_tags($Article['content']);?></p>

                                    <?php
                                        } else {
                                    ?>

                                    <img src="<?=rootURL();?>articles/<?=$id;?>/<?=$Article['content'];?>" class="article-thumbnail btn p-0" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=rootURL();?>articles/<?=$id;?>/<?=$Article['content'];?>">

                                    <?php
                                        }
                                    ?>

                                </td>
                                <td class="fit text-center"><?=date("d M Y H:i", strtotime($Article['added']));?></td>
                                <td class="fit text-center"><?=time_ago("th", $Article['updates']);?></td>
                                <td class="fit">
                                    <a href="./article-details.php?id=<?=$Article['id'];?>&article=<?=$id;?>" class="btn btn-warning btn-tooltip" data-bs-title="แก้ไขเนื้อหา"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <button type="button" class="btn btn-danger btn-tooltip btn-remove" data-id="<?=$Article['id'];?>" data-bs-title="ลบเนื้อหา"><i class="fa-solid fa-trash"></i></button>
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

    <form action="#" method="post" id="ArticleContentTextModalForm" class="article-details-form">
        <div class="modal fade" id="ArticleContentTextModal" tabindex="-1" aria-labelledby="ArticleContentTextModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ArticleContentTextModalLabel">เพิ่มเนื้อหาแบบข้อความ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="articleId" value="<?=$id;?>">
                        <input type="hidden" name="type" value="1">
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="header" placeholder="หัวข้อ">
                            <label for="title">หัวข้อ</label>
                        </div>
                        <textarea class="form-control" name="content" placeholder="เนื้อหา" style="height: 150px" required aria-required="true"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="#" method="post" id="ArticleContentImageModalForm" class="article-details-form">
        <div class="modal fade" id="ArticleContentImageModal" tabindex="-1" aria-labelledby="ArticleContentImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="ArticleContentImageModalLabel">เพิ่มเนื้อหาแบบภาพ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="articleId" value="<?=$id;?>">
                        <input type="hidden" name="type" value="2">
                        <img src="" alt="" class="w-100" id="ArticleContentImageModalThumbnail">
                        <div class="input-group my-3">
                            <input type="file" class="form-control" name="content" id="InputContentImage" accept="image/*" required aria-required="true">
                            <label class="input-group-text" for="InputContentImage">Upload</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" class="form-control" name="header" placeholder="หัวข้อ" required aria-required="true">
                            <label for="title">หัวข้อ</label>
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
        tinymce.init({
            selector: "textarea",
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });

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
                        url: "https://www.ecmapi.boonsiri.co.th/api/v1/article-detail/delete-article-detail",
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

        InputContentImage.onchange = evt => {
            const [file] = InputContentImage.files
            if (file) {
                ArticleContentImageModalThumbnail.src = URL.createObjectURL(file)
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

        $('.article-details-form').on("submit", function(e) {
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
                url: './insert/article-details.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'เพิ่มเนื้อหาสำเร็จ!',
                            'เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'เพิ่มเนื้อหาล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'เพิ่มเนื้อหาล้มเหลว!',
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