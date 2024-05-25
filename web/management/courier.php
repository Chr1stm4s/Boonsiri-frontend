<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "courier";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col text-center">
                    <h1 class="mb-0">Courier</h1>
                </div>
            </div>
            
            <div class="row">

            <?php
                $apiUrl = "$API_Link/v1/article-category/list-courier";
                
                $data = connect_api($apiUrl);

                if ($data['responseCode'] == 000) {
                    foreach ($data['courierCategories'] as $courier) {
            ?>

                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col text-center">
                                    <h5 class="mb-0 card-title"><?=$courier['title'];?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col">
                                    <form action="#" method="POST">
                                        <div class="input-group">
                                            <input type="hidden" name="courierId" value="<?=$courier['id'];?>">
                                            <input type="number" class="form-control" name="weight" placeholder="จำนวนน้ำหนักไม่เกินกี่กิโล" aria-label="จำนวนน้ำหนักไม่เกินกี่กิโล" required aria-required="true">
                                            <input type="number" class="form-control" name="price" placeholder="ราคาค่าขนส่ง" aria-label="ราคาค่าขนส่ง" required aria-required="true">
                                            <button type="submit" class="btn btn-primary">เพิ่มพิกัด</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">น้ำหนัก</th>
                                        <th class="text-center">ราคา</th>
                                        <th class="fit">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $dataAPI = [
                                        "courierId" => $courier['id']
                                    ];

                                    $apiUrl = "$API_Link/v1/courier-rate/list-courier-rate";
                                    
                                    $data = connect_api($apiUrl, $dataAPI);

                                    if ($data['responseCode'] == 000) {
                                        foreach ($data['courierRateCategories'] as $CourierRates) {
                                ?>

                                    <tr>
                                        <th class="text-center">ไม่เกิน <?=$CourierRates['weight'];?> กิโลกรัม</th>
                                        <td class="text-center"><?=number_format($CourierRates['price']);?> บาท</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-remove" data-id="<?=$CourierRates['id'];?>"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>

                                <?php
                                        }
                                    } else {
                                ?>

                                    <tr>
                                        <td colspan="3" class="text-center">ไม่มีข้อมูล</td>
                                    </tr>

                                <?php
                                    }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php
                    }
                } else {
            ?>

                <div class="col text-center">
                    <p class="mb-0">ไม่มีข้อมูล</p>
                </div>

            <?php
                }
            ?>

            </div>
        </div>
    </section>

    <?php require_once "./js.php"; ?>

    <script>
        $("form").submit(function() {
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
                url: '$API_Link/v1/courier-rate/insert-courier-rate',
                type: 'POST',
                data: JSON.stringify(indexed_array),
                contentType: "application/json", 
                success: function(response) {
                    Swal.close();

                    if (response.responseCode == "000") {
                        Swal.fire(
                            'เพิ่มพิกัดขนส่งเรียบร้อย!',
                            'ระบบจะทำการรีเฟรชหน้าใหม่',
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'เพิ่มพิกัดขนส่งไม่สำเร็จ!',
                            'กรุณาติดต่อเจ้าหน้าที่.',
                            'error'
                        );
                    }
                }
            });
        });

        $(".btn-remove").on("click", function() {
            const id = $(this).data("id");

            Swal.fire({
                title: 'ต้องการลบพิกัดขนส่งนี้ใช่ไหม?',
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

                    // API endpoint
                    const apiUrl = '$API_Link/v1/courier-rate/delete-courier-rate';

                    // Data to send in the request
                    const data = {
                        id: id
                    };

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
                                'ลบพิกัดขนส่งเรียบร้อย!',
                                'ระบบจะทำการรีเฟรชหน้าใหม่',
                                'success'
                            ).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'ลบพิกัดขนส่งไม่สำเร็จ!',
                                'กรุณาติดต่อเจ้าหน้าที่.',
                                'error'
                            );

                            console.log(responseData)
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'ลบพิกัดขนส่งไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );

                        console.error('Error:', error);
                    });
                }
            });
        });
    </script>

</body>

</html>