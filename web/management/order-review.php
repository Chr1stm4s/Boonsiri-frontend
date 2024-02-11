<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "orders";

        require_once "./head.php";

        $id = $_GET['id'];

        $APIRequest = [
            'id' => $id,
        ];

        $Response = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/review/get-review", $APIRequest);

        if ($Response['responseCode'] == 000) {
            $ReviewData = $Response['review'];
        } else {
            exit();
        }
    ?>

    <style>
        #PreviewThumbnailModal .btn-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
        }
    </style>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./orders.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">Review</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-auto">
                    <p>
                        คุณภาพสินค้า <?=$ReviewData['quality'];?>
                        <br>

                        <?php
                            for ($i=1; $i <= 5; $i++) { 
                                if ($i <= $ReviewData['quality']) {
                        ?>

                        <i class="fa-solid fa-star text-warning"></i>

                        <?php
                                } else {
                        ?>

                        <i class="fa-regular fa-star text-warning"></i>

                        <?php
                                }
                            }
                        ?>

                    </p>
                    <p>
                        บริการผู้ขาย <?=$ReviewData['services'];?>
                        <br>

                        <?php
                            for ($i=1; $i <= 5; $i++) { 
                                if ($i <= $ReviewData['services']) {
                        ?>

                        <i class="fa-solid fa-star text-warning"></i>

                        <?php
                                } else {
                        ?>

                        <i class="fa-regular fa-star text-warning"></i>

                        <?php
                                }
                            }
                        ?>

                    </p>
                    <p>
                        บริการผู้ส่ง <?=$ReviewData['delivery'];?>
                        <br>

                        <?php
                            for ($i=1; $i <= 5; $i++) { 
                                if ($i <= $ReviewData['delivery']) {
                        ?>

                        <i class="fa-solid fa-star text-warning"></i>

                        <?php
                                } else {
                        ?>

                        <i class="fa-regular fa-star text-warning"></i>

                        <?php
                                }
                            }
                        ?>

                    </p>
                </div>
            </div>
            
            <div class="row my-5">
                <div class="col">
                    <p class="mb-0"><?=$ReviewData['message'];?></p>
                </div>
            </div>

            <?php
                $ReviewImageAPIRequest = [
                    'reviewId' => $id,
                ];

                $ReviewImageResponse = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/reviews-image/get-reviews-image", $ReviewImageAPIRequest);

                if ($ReviewImageResponse['responseCode'] == 000) {
            ?>

            <div class="row">
                
                <?php
                    foreach ($ReviewImageResponse['reviewsImage'] as $ReviewImageData) {
                        $path_info = pathinfo("../reviews/$id/".$ReviewImageData['image']);
                        $icon = [
                            "pdf" => '<i class="mx-2 fs-3 fa-solid fa-file-pdf text-danger"></i>', 
                            "doc" => '<i class="mx-2 fs-3 fa-solid fa-file-word text-primary"></i>', 
                            "docx" => '<i class="mx-2 fs-3 fa-solid fa-file-word text-primary"></i>', 
                            "xlsx" => '<i class="mx-2 fs-3 fa-solid fa-file-excel text-success"></i>', 
                            "xls" => '<i class="mx-2 fs-3 fa-solid fa-file-excel text-success"></i>', 
                            "csv" => '<i class="mx-2 fs-3 fa-solid fa-file-csv text-success"></i>'
                        ];

                        if (in_array($path_info['extension'], array("jpg", "jpeg", "png"))) {
                ?>

                <div class="col-3 my-3">
                    <img src="../reviews/<?=$id;?>/<?=$ReviewImageData['image'];?>" alt="<?=$ReviewData['message'];?>" class="w-100 btn p-0 rounded-5" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="../reviews/<?=$id;?>/<?=$ReviewImageData['image'];?>">
                </div>

                <?php
                        } else {
                ?>

                <div class="col-3 my-3">
                    <video class="w-100 btn p-0 rounded-5" controls>
                        <source src="../reviews/<?=$id;?>/<?=$ReviewImageData['image'];?>" type="video/mp4" />
                    </video>
                </div>

                <?php
                        }
                    }
                ?>

            </div>

            <?php
                } else {
            ?>

            No image

            <?php
                }
            ?>

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

    <?php require_once "./js.php"; ?>

    <script>
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
    </script>

</body>

</html>