<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "articles";

        require_once "./head.php";

        $id = $_GET['id'];
        $article = $_GET['article'];

        $ArticleDataRequest = [
            "id" => $article
        ];

        $ArticleDataResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article/get-article", $ArticleDataRequest);

        if ($ArticleDataResponse['responseCode'] == "000") {
            $ArticleData = $ArticleDataResponse['article'];

            $ArticleDetailsDataRequest = [
                "id" => $id
            ];
    
            $ArticleDetailsDataResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/article-detail/get-article-detail", $ArticleDetailsDataRequest);
    
            if ($ArticleDetailsDataResponse['responseCode'] == "000") {
                $ArticleDetailsData = $ArticleDetailsDataResponse['articleDetail'];
            } else {
                var_dump($ArticleDetailsDataResponse);
    
                exit();
            }
        } else {
            var_dump($ArticleDataResponse);

            exit();
        }
    ?>

    <script src="https://cdn.tiny.cloud/1/u91050fzj02e3pcqppumc8iwx4nanmnh3o67dxmrou3s4nff/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <form action="#" class="article-details-form">
        <section class="py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-auto my-auto">
                        <a href="./articles-details-list.php?id=<?=$article;?>" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                    </div>
                    <div class="col">
                        <h1 class="mb-0">บทความ - <?=$ArticleData['title'];?></h1>
                    </div>
                    <div class="col-auto px-0">
                        <input type="text" name="header" id="header" class="form-control" value="<?=$ArticleDetailsData['header'];?>" placeholder="หัวข้อ">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="id" value="<?=$id;?>">
                        <input type="hidden" name="articleId" value="<?=$article;?>">
                        
                        <?php
                            if ($ArticleDetailsData['type'] == 1) {
                        ?>

                        <textarea name="content" id="content"><?=$ArticleDetailsData['content'];?></textarea>
                        <input type="hidden" name="type" value="1">

                        <?php
                            } elseif ($ArticleDetailsData['type'] == 2) {
                        ?>

                        <input type="hidden" name="type" value="2">
                        <label for="ContentImage">
                            <img src="<?=rootURL();?>articles/<?=$article;?>/<?=$ArticleDetailsData['content'];?>" class="btn p-0 rounded-4 w-100" id="ArticleContentImageModalThumbnail">
                            <input type="file" name="content" id="ContentImage" class="d-none" accept="image/*">
                        </label>

                        <?php
                            }
                        ?>

                    </div>
                </div>
            </div>
        </section>
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

        <?php
            if ($ArticleDetailsData['type'] == 2) {
        ?>

        ContentImage.onchange = evt => {
            const [file] = ContentImage.files
            if (file) {
                ArticleContentImageModalThumbnail.src = URL.createObjectURL(file)
            }
        }

        <?php
            }
        ?>
        
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
                            'แก้ไขเนื้อหาสำเร็จ!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'แก้ไขเนื้อหาล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(response)
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'แก้ไขเนื้อหาล้มเหลว!',
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