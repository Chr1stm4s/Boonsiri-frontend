<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "claims";
        
        require_once "head.php";

        $id = $_GET['id'];

        $APIRequest = [
            'id' => $id,
        ];

        $Response = connect_api("{$API_URL}case/get-case", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $CaseData = $Response['case'];

            $status = array(
                '<span class="badge text-bg-light px-3">เปิดเคส</span>', 
                '<span class="badge text-bg-warning px-3">รอเจ้าหน้าที่ตอบกลับ</span>',
                '<span class="badge text-bg-primary px-3">รอลูกค้าตอบกลับ</span>',
                '<span class="badge text-bg-success px-3">เสร็จสิ้น</span>'
            );
        } else {
            var_dump($Response);
            
            exit();
        }
    ?>

    <style>
        .img-case {
            height: 30px;
            cursor: pointer;
            transition: ease 0.2s;
        }

        .img-case:hover {
            transform: scale(1.2);
        }
    </style>

</head>

<body>
    
    <?php require_once "header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row my-4">
                <div class="col-auto my-auto">
                    <a href="./claims.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0">สถานะการเคลม - <?=$status[$CaseData['status']];?></h1>
                </div>
            </div>

            <?php
                $count = 1;

                $MessageAPIRequest = [
                    'caseId' => $id,
                ];
        
                $MessageResponse = connect_api("{$API_URL}case-message/list-case-message", $MessageAPIRequest);
        
                if ($MessageResponse['responseCode'] == 000) {
                    $CaseMessageData = $MessageResponse['casesMessages'];

                    foreach ($CaseMessageData as $items) {
                        $Side = ($items['userId'] == 0) ? "me-auto" : "ms-auto";
            ?>

            <div class="row">
                <div class="col-10 col-md-9 col-lg-8 <?=$Side;?>">
                    <div class="card w-100 shadow my-3">

                        <?php
                            $MessageFileAPIRequest = [
                                'messageId' => $items['id'],
                            ];

                            $MessageFileResponse = connect_api("{$API_URL}case-file/list-case-file", $MessageFileAPIRequest);

                            if ($MessageFileResponse['responseCode'] == 000 || count($MessageFileResponse['casesFiles']) != 0) {
                        ?>

                        <div class="card-header border-0 bg-white">

                            <?php
                                foreach ($MessageFileResponse['casesFiles'] as $MessageFileData) {
                                    $path_info = pathinfo("../cases/$id/".$MessageFileData['file']);
                                    
                                    $icon = [
                                        "pdf" => '<i class="mx-2 fs-3 fa-solid fa-file-pdf text-danger"></i>', 
                                        "doc" => '<i class="mx-2 fs-3 fa-solid fa-file-word text-primary"></i>', 
                                        "docx" => '<i class="mx-2 fs-3 fa-solid fa-file-word text-primary"></i>', 
                                        "xlsx" => '<i class="mx-2 fs-3 fa-solid fa-file-excel text-success"></i>', 
                                        "xls" => '<i class="mx-2 fs-3 fa-solid fa-file-excel text-success"></i>', 
                                        "mp4" => '<i class="mx-2 fs-3 fa-solid fa-file-video text-warning"></i>', 
                                        "m4v" => '<i class="mx-2 fs-3 fa-solid fa-file-video text-warning"></i>', 
                                        "csv" => '<i class="mx-2 fs-3 fa-solid fa-file-csv text-success"></i>'
                                    ];

                                    if (in_array($path_info['extension'], array("jpg", "jpeg", "png"))) {
                            ?>

                            <img src="<?=rootURL();?>cases/<?=$id;?>/<?=$MessageFileData['file'];?>" alt="<?=$items['message'];?>" class="img-case" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-image="<?=rootURL();?>cases/<?=$id;?>/<?=$MessageFileData['file'];?>">

                            <?php
                                    } else {
                            ?>

                            <a href="<?=rootURL();?>cases/<?=$id;?>/<?=$MessageFileData['file'];?>" download="<?=$MessageFileData['file'];?>" class="text-decoration-none">
                                <?=$icon[$path_info['extension']];?>
                            </a>

                            <?php
                                    }
                                }
                            ?>

                        </div>

                        <?php
                            }
                        ?>

                        <div class="card-body">
                            <p class="mb-0 card-text"><?=$items['message'];?></p>
                        </div>
                        <div class="card-footer text-end border-0 bg-white">
                            <small class="text-muted"><?=time_ago("TH", $items['added']);?></small>
                        </div>
                    </div>
                </div>
            </div>
                    
            <?php
                        $count++;
                    }
                } else {
            ?>

            <div class="row">
                <div class="col">
                    <div class="card w-100">
                        <div class="card-body text-center">
                            <h5 class="mb-0">ยังไม่มีข้อมูล</h5>
                        </div>
                    </div>
                </div>
            </div>
                    
            <?php
                }
            ?>

        </div>
    </section>

    <div class="modal fade" id="PreviewThumbnailModal" tabindex="-1" aria-labelledby="PreviewThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" class="w-100" id="PreviewThumbnailModalIMG">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="PreviewVideoModal" tabindex="-1" aria-labelledby="PreviewVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <video class="w-100" controls id="PreviewVideoModalVideo">
                        <source id="PreviewVideoModalVideoSource" src="" type="video/mp4" />
                    </video>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5">
        <form action="#" method="post" id="SubmitClaimMessageForm">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-column">
                        <input type="hidden" name="caseId" id="caseId" value="<?=$id;?>">
                        <input type="hidden" name="status" id="status" value="2">
                        <div class="mb-3">
                            <label for="message" class="col-form-label">ข้อความ:</label>
                            <textarea class="form-control" id="message" name="message" required aria-required="true"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">รูปสินค้าที่มีปัญหา</label>
                            <div class="input-group">
                                <input type="file" class="form-control" name="claim[]" id="image" multiple accept="image/*">
                                <label class="input-group-text" for="image">Upload</label>
                            </div>
                        </div>
                        <div class="gallery"></div>
                        <button type="submit" class="btn btn-primary ms-auto">ส่งข้อความ</button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <?php require_once "js.php"; ?>

    <script>
        const PreviewThumbnailModal = document.getElementById('PreviewThumbnailModal')
        if (PreviewThumbnailModal) {
            PreviewThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const image = button.getAttribute('data-bs-image')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const PreviewThumbnailModalIMG = PreviewThumbnailModal.querySelector('#PreviewThumbnailModalIMG')

                PreviewThumbnailModalIMG.src = image
            })
        }

        const PreviewVideoModal = document.getElementById('PreviewVideoModal')
        if (PreviewVideoModal) {
            PreviewVideoModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const video = button.getAttribute('data-bs-video')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.

                const PreviewVideoModalVideo = myModal.querySelector('#PreviewVideoModalVideo');
                const PreviewVideoModalVideoSource = myModal.querySelector('#PreviewVideoModalVideoSource');
                
                PreviewVideoModalVideoSource.src = video;
                PreviewVideoModalVideo.load();
            });

            PreviewVideoModal.addEventListener('hidden.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const video = button.getAttribute('data-bs-video')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.

                const PreviewVideoModalVideo = myModal.querySelector('#PreviewVideoModalVideo');

                PreviewVideoModalVideo.pause();
            });
        }

        $('#SubmitClaimMessageForm').on("submit", function(e) {
            e.preventDefault();

            var form = $(this)[0];
            var data = new FormData(form);

            Swal.fire({
                title: 'กำลังส่งข้อมูล...',
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
                url: './insert/case-message.php',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'ส่งข้อความสำเร็จ!',
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