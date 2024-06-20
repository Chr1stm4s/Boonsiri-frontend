<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "products";

        require_once "./head.php";
    ?>

    <style>
        .product-thumbnail {
            height: 50px;
            cursor: pointer;
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            width: 100vw;
            height: 100vh;
            z-index: 1;
        }
    </style>

</head>

<body>
    <div class="loading">
        <i class="fa-solid fa-spinner fa-pulse m-auto fs-1 text-white"></i>
    </div>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Products</h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary" id="Export">Export</button>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th class="px-4 fit">รูปปกสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>SKU</th>
                                <th class="px-4 fit">น้ำหนักขนส่ง</th>
                                <th class="px-4 text-center">ราคา</th>
                                <th class="px-4 fit">ปรับปรุงล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "{$API_URL}product/list-product-all";

                            $requestData = [
                                "itemSize" => "",
                                'orderByColumn' => '',  
                                'orderBy' => '', 
                                'pageNo' => 0, 
                                'pageSize' => 0
                            ];

                            // Decode the response
                            $dataAPI = connect_api($apiUrl, $requestData);

                            if ($dataAPI['responseCode'] == "000") {
                                foreach ($dataAPI['products'] as $product) {
                                    $image = ($product['thumbnail'] && file_exists("../products/".$product['thumbnail'])) ? "../products/".$product['thumbnail'] : "../images/logo.png";
                        ?>

                            <tr>
                                <th class="text-end"><?=$product['id'];?></th>
                                <td class="text-center">
                                    <img src='<?=$image;?>' class='product-thumbnail' data-bs-toggle='modal' data-bs-target='#ThumbnailModal' data-bs-id='<?=$product['id'];?>' data-bs-img='<?=$image;?>' data-bs-title='<?=$product['title'];?>' >
                                </td>
                                <td> <p class='mb-0 btn-tooltip' data-bs-title='<?=$product['title'];?>'><?=$product['title'];?></p> </td>
                                <td> <p class='mb-0 btn-tooltip' data-bs-title='<?=$product['sku'];?>'><?=$product['sku'];?></p> </td>
                                <td class="text-end"><?=$product['weight'];?> กิโลกรัม</td>
                                <td class="text-end"><?=number_format($product['price']);?> บาท</td>
                                <td class="text-center"><?=time_ago("th", $product['updates']);?></td>
                                <td class="fit">
                                    <a href='<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$product['id'];?>/<?=str_replace(" ", "-", $product['title']);?>/' class='btn btn-primary btn-tooltip' target='_blank' data-bs-title='ดูข้อมูลสินค้า'><i class='fa-regular fa-eye'></i></a>
                                    <a href='./product-images.php?id=<?=$product['id'];?>' class='btn btn-outline-dark btn-tooltip' data-bs-title='จัดการรูปสินค้า'><i class='fa-solid fa-images'></i></a>
                                    <button 
                                        type='button' 
                                        class='btn btn-warning btn-tooltip btn-edit' 
                                        data-bs-title='แก้ไขข้อมูลสินค้า' 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#EditProductModal"
                                        data-bs-id='<?=$product['id'];?>' 
                                        data-meta-title='<?=$product['metaTitle'];?>' 
                                        data-meta-description='<?=$product['metaDescription'];?>' 
                                        data-keywords='<?=$product['keywords'];?>' 
                                        data-sku='<?=$product['sku'];?>' 
                                        data-title='<?=$product['title'];?>' 
                                        data-description='<?=$product['description'];?>' 
                                        data-url='<?=$product['url'];?>' 
                                        data-price='<?=$product['price'];?>' 
                                        data-weight='<?=$product['weight'];?>' 
                                        data-thumbnail='<?=$product['thumbnail'];?>' 
                                    >
                                        <i class='fa-regular fa-pen-to-square'></i>
                                    </button>
                                </td>
                            </tr>
                        
                        <?php
                                }
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="post" id="FormEditProduct">
        <div class="modal fade" id="EditProductModal" tabindex="-1" aria-labelledby="EditProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="EditProductModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="thumbnail" id="thumbnail">
                        <input type="hidden" name="weight" id="weight">
                        <input type="hidden" name="price" id="price">
                        <div class="row mb-3">
                            <div class="col-3">
                                <label for="meta_title" class="col-form-label">Meta Title:</label>
                                <input type="text" class="form-control" id="meta_title" name="metaTitle">
                            </div>
                            <div class="col-3">
                                <label for="meta_description" class="col-form-label">Meta Description:</label>
                                <input type="text" class="form-control" id="meta_description" name="metaDescription">
                            </div>
                            <div class="col-3">
                                <label for="keywords" class="col-form-label">Keywords:</label>
                                <input type="text" class="form-control" id="keywords" name="keyWords">
                            </div>
                            <div class="col-3">
                                <label for="sku" class="col-form-label">SKU:</label>
                                <input type="text" class="form-control" id="sku" name="sku">
                            </div>
                            <div class="col-3">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="col-3">
                                <label for="description" class="col-form-label">Description:</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="col-6">
                                <label for="url" class="col-form-label">URL:</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="ProductURLLabel"></span>
                                    <input type="text" class="form-control" id="url" name="url" placeholder="URL" aria-label="URL" aria-describedby="ProductURLLabel">
                                    <span class="input-group-text" id="ProductURLLabel2">/</span>
                                </div>
                            </div>
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

    <form action="#" method="POST" enctype="multipart/form-data" id="ThumbnailModalForm">
        <div class="modal fade" id="ThumbnailModal" tabindex="-1" aria-labelledby="ThumbnailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mb-0" id="ThumbnailModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="ThumbnailModalInputID">
                        <img src="" class="w-100 mb-4 image-preview" id="ThumbnailModalPreview">
                        <div class="input-group">
                            <input type="file" name="image" class="form-control image-input" id="ThumbnailModalInputImage" accept="image/*" required aria-required="true">
                            <label class="input-group-text" for="ThumbnailModalInputImage">Upload</label>
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
            $(".loading").fadeOut();
        }, false);

        $(document).ready(function() {
            $('#DataTables').DataTable({
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 
                    }
                ],
                order: [
                    [
                        0, 'asc'
                    ]
                ]
            });
        });

        $("#Export").click(function() {
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

            $.post(
                "./generate-products.php", 
                function(response) {
                    const data = JSON.parse(response);

                    if (data.response == "success") {
                        Swal.fire({
                            title: 'สร้างรายงานสำเร็จ',
                            icon: 'success',
                            showCancelButton: false,
                            showDenyButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'ดาวน์โหลด'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = `./report/${data.file}`; // Replace with your link
                            }
                        })
                    } else {
                        Swal.fire(
                            'สร้างรายงานไม่สำเร็จ',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );

                        console.log(data)
                    }
                }
            )
        });

        const EditProductModal = document.getElementById('EditProductModal')
        if (EditProductModal) {
            EditProductModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const title = button.getAttribute('data-title')
                const meta_title = button.getAttribute('data-meta-title')
                const meta_description = button.getAttribute('data-meta-description')
                const keywords = button.getAttribute('data-keywords')
                const sku = button.getAttribute('data-sku')
                const description = button.getAttribute('data-description')
                const getURL = button.getAttribute('data-url')

                const url = (getURL) ? getURL : title;

                // To remove later
                const thumbnail = button.getAttribute('data-thumbnail')
                const price = button.getAttribute('data-price')
                const weight = button.getAttribute('data-weight')
                // To remove later
                
                const modalTitle = EditProductModal.querySelector('.modal-title')
                const modalBodyInputID = EditProductModal.querySelector('#id')
                const modalBodyInputTitle = EditProductModal.querySelector('#title')
                const modalBodyInputMetaTitle = EditProductModal.querySelector('#meta_title')
                const modalBodyInputMetaDescription = EditProductModal.querySelector('#meta_description')
                const modalBodyInputKeywords = EditProductModal.querySelector('#keywords')
                const modalBodyInputSKU = EditProductModal.querySelector('#sku')
                const modalBodyInputDescription = EditProductModal.querySelector('#description')
                const modalBodyInputURL = EditProductModal.querySelector('#url')
                const ProductURLLabel = EditProductModal.querySelector('#ProductURLLabel')

                // To remove later
                const modalBodyInputThumbnail = EditProductModal.querySelector('#thumbnail')
                const modalBodyInputPrice = EditProductModal.querySelector('#price')
                const modalBodyInputWeight = EditProductModal.querySelector('#weight')
                // To remove later

                modalTitle.textContent = `แก้ไขข้อมูลสินค้า ${title}`
                modalBodyInputID.value = id
                modalBodyInputTitle.value = title
                modalBodyInputMetaTitle.value = meta_title
                modalBodyInputMetaDescription.value = meta_description
                modalBodyInputKeywords.value = keywords
                modalBodyInputSKU.value = sku
                modalBodyInputDescription.value = description
                modalBodyInputURL.value = url
                ProductURLLabel.textContent = `<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/${id}/`

                // To remove later
                modalBodyInputThumbnail.value = price
                modalBodyInputPrice.value = price
                modalBodyInputWeight.value = weight
                // To remove later
            })
        }

        const ThumbnailModal = document.getElementById('ThumbnailModal');

        if (ThumbnailModal) {
            ThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const img = button.getAttribute('data-bs-img')
                const title = button.getAttribute('data-bs-title')

                const ThumbnailModalLabel = ThumbnailModal.querySelector('#ThumbnailModalLabel')
                const ThumbnailModalPreview = ThumbnailModal.querySelector('#ThumbnailModalPreview')
                const ThumbnailModalInputID = ThumbnailModal.querySelector('#ThumbnailModalInputID')

                ThumbnailModalLabel.textContent = `แก้ไขรูปปก ${title}`
                ThumbnailModalPreview.src = img
                ThumbnailModalInputID.value = id
            })
        }

        $('#FormEditProduct').submit(function() {
            var unindexed_array = $(this).serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });

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
                url: '<?=$API_URL;?>product/update-product',
                type: 'POST',
                data: JSON.stringify(indexed_array),
                contentType: "application/json", 
                success: function(response) {
                    Swal.close();

                    if (response.responseCode == "000") {
                        Swal.fire(
                            'แก้ไขข้อมูลเรียบร้อย!',
                            'ระบบจะทำการรีเฟรชหน้าใหม่',
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'แก้ไขข้อมูลไม่สำเร็จ!',
                            'กรุณาติดต่อเจ้าหน้าที่.',
                            'error'
                        );
                    }
                }
            });
        });

        $('#ThumbnailModalForm').submit(function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Serialize the form data
            var formData = new FormData(this);

            Swal.fire({
                title: 'Processing...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: './update/product-thumbnail.php', // Replace with your PHP script URL
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
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
                error: function (xhr, status, error) {
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