<!doctype html>
<html lang="en">

<head>

    <?php
        $page = "products";
        $id = $_GET['id'];

        require_once "./head.php";

        $APIURL = "https://www.ecmapi.boonsiri.co.th/api/v1/product/get-product-by-id";
                    
        $ProductAPIDataRequest = [
            'productId' => $id, 
        ];
    
        $ProductAPIDataResponse = connect_api($APIURL, $ProductAPIDataRequest);
        
        if ($ProductAPIDataResponse['responseDesc'] == "Success") {
            $data = $ProductAPIDataResponse['product'];
        } else {
            var_dump($ProductAPIDataResponse);

            exit();
        }
    ?>

    <style>
        .img-gallery {
            margin: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .img-gallery>img {
            height: 100px;
            cursor: pointer;
        }

        .img-gallery>button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }
    </style>

</head>

<body>

    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./products.php" class="btn btn-outline-dark"><i class="fa-solid fa-angle-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0 fs-4">รูปภาพสินค้า : <?= $data['title']; ?></h1>
                </div>
                <div class="col-auto my-auto">
                    <form action="#" method="POST" enctype="multipart/form-data" id="InsertImagesForm">
                        <input type="hidden" name="id" value="<?= $data['id']; ?>">
                        <input type="hidden" name="title" value="<?= $data['title']; ?>">
                        <input type="hidden" name="itemCode" value="<?= $data['itemCode']; ?>">
                        <div class="input-group">
                            <input type="file" class="form-control" name="image[]" id="InputImage" aria-describedby="InputImageAddon" multiple accept="image/*" aria-label="เพิ่มรูปสินค้า">
                            <button class="btn btn-primary" type="submit" id="InputImageAddon">เพิ่มรูปสินค้า</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">

                    <?php
                        foreach ($data['productImages'] as $product) {
                    ?>

                        <div class="img-gallery" id="GalleryImg<?= $product['id']; ?>">
                            <button type="button" class="btn btn-danger btn-remove" data-id="<?= $product['id']; ?>"><i class="fa-solid fa-trash"></i></button>
                            <img src="../products/gallery/<?= $id; ?>/<?= $product['image']; ?>">
                        </div>

                    <?php
                        }
                    ?>

                </div>
            </div>
        </div>
    </section>

    <?php require_once "./js.php"; ?>

    <script>
        $(".btn-remove").click(function() {
            const id = $(this).data("id");

            const data = {
                "id": id
            };

            Swal.fire({
                title: 'ต้องการลบรูปนี้ใช่ไหม?',
                icon: "warning", 
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: `ยกเลิก`
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        showDenyButton: false,
                        showCancelButton: false,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // API endpoint
                    const apiUrl = 'https://www.ecmapi.boonsiri.co.th/api/v1/product/delete-product-image';

                    // Send the POST request
                    fetch(apiUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': '*/*',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(responseData => {
                        Swal.close();

                        if(responseData.responseDesc == 'Success') {
                            Swal.fire(
                                'ดำเนินการสำเร็จ!',
                                '',
                                'success'
                            ).then(() => {
                                $("#GalleryImg" + id).remove();
                            });
                        } else {
                            Swal.fire(
                                'ล้มเหลว!',
                                '',
                                'error'
                            )

                            console.log(responseData)
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'ล้มเหลว!',
                            '',
                            'error'
                        )

                        console.error('Error:', error);
                    });
                }
            })
        });

        $('#InsertImagesForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = new FormData(this);

            Swal.fire({
                title: 'Processing...',
                showDenyButton: false,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: './insert/product-image.php', // Replace with your PHP script URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();

                    if (response == "success") {
                        Swal.fire(
                            'ดำเนินการสำเร็จ!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else if (response == "upload") {
                        Swal.fire(
                            'ไม่สามารถอัพโหลดรูปได้!',
                            response,
                            'error'
                        )
                    } else if (response == "update") {
                        Swal.fire(
                            'แก้ไขข้อมูลไม่สำเร็จ!',
                            response,
                            'error'
                        )
                    } else {
                        Swal.fire(
                            'ล้มเหลว!',
                            response,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();

                    Swal.fire(
                        'ล้มเหลว!',
                        xhr.responseText,
                        'error'
                    )
                }
            });
        });
    </script>

</body>

</html>