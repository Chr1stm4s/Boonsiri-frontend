<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "branches";

        require_once "./head.php";

        $id = $_GET['id'];
        $courier = $_GET['courier'];

        $dataAPI = [
            "branchId" => $id
        ];
        
        $dataBranch = connect_api("{$API_URL}branch/master/get-branch-by-id", $dataAPI);

        $branchData = $dataBranch['branch'];
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./branches.php" class="btn btn-outline-dark"><i class="fa-solid fa-angle-left"></i></a>
                </div>
                <div class="col my-auto">
                    <h1 class="mb-0 fs-3"><?=$branchData['title'];?> - <?=$branchData['address'];?> <?=$branchData['amphurName'];?> <?=$branchData['provinceName'];?></h1>
                </div>
                <div class="col-auto my-auto">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#AddAreaModal">เพิ่มอำเภอ / ตำบล</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">
                                    <input class="form-check-input my-auto" type="checkbox" id="checkAll">
                                </th>
                                <th class="fit">ลำดับ</th>
                                <th>ตำบล</th>
                                <th>อำเภอ</th>
                                <th>จังหวัด</th>
                                <th class="fit">
                                    <button type="button" class="btn btn-danger btn-tooltip" id="ButtonDeleteAll" data-type="all" data-bs-title="ลบทั้งหมด" disabled>
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $i = 1;

                            $MappingDataAPI = [
                                "courierId" => $courier
                            ];

                            $dataListBranch = connect_api("{$API_URL}mapping-branch/list-mapping-branch", $MappingDataAPI);

                            if ($dataListBranch['responseCode'] == 000) {
                                foreach ($dataListBranch['mappingBranches'] as $branchArea) {
                                    if ($branchArea['branchId'] == $id) {
                        ?>

                            <tr>
                                <td>
                                    <input class="form-check-input checkbox" type="checkbox" name="delete[]" value="<?=$branchArea['id'];?>">
                                </td>
                                <th class="text-end"><?=$i;?></th>
                                <td><?=$branchArea['districtName'];?></td>
                                <td><?=$branchArea['amphurName'];?></td>
                                <td><?=$branchArea['provinceName'];?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-delete-area btn-tooltip" data-type="single" data-id="<?=$branchArea['id'];?>" data-bs-title="ลบ"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>

                        <?php
                                    }

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

    <div class="modal fade" id="AddAreaModal" tabindex="-1" aria-labelledby="AddAreaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AddAreaModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data" id="AddAreaModalForm">
                        <input type="hidden" name="courierId" value="<?=$courier;?>">
                        <input type="hidden" name="branchId" value="<?=$id;?>">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="province" id="province" aria-label="จังหวัด">
                                        <option selected disabled value="0">เลือกจังหวัด</option>

                                        <?php
                                            $ListProvinceAPIRequest = [
                                                'geoId' => 0,
                                            ];

                                            $ListProvinceResponse = connect_api("{$API_URL}address/province", $ListProvinceAPIRequest);

                                            if ($ListProvinceResponse['responseCode'] == 000) {
                                                foreach ($ListProvinceResponse['provinces'] as $ProvinceData) {
                                        ?>

                                        <option value="<?=$ProvinceData['provinceId'];?>"><?=$ProvinceData['provinceName'];?></option>

                                        <?php
                                                }
                                            } else {
                                        ?>

                                        <option value="0" disabled selected>ไม่มีข้อมูล</option>

                                        <?php
                                            }
                                        ?>
                                        
                                    </select>
                                    <label for="province">จังหวัด</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="amphur" id="amphur" aria-label="อำเภอ / เขต" disabled>
                                        <option selected disabled value="0">เลือกตำบล / แขวง</option>
                                    </select>
                                    <label for="amphur">อำเภอ / เขต</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" name="district" id="district" aria-label="ตำบล / แขวง" disabled>
                                        <option selected disabled value="0">เลือกตำบล / แขวง</option>
                                    </select>
                                    <label for="district">ตำบล / แขวง</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="AddAreaModalSubmitButton">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function() {
            $('#DataTables').DataTable( 
                {
                    columnDefs: [
                        { 
                            orderable: false, 
                            targets: [
                                0, 5
                            ] 
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ], 
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "แสดงทั้งหมด"]
                    ],
                    iDisplayLength: 10
                } 
            );
            
            $(document).on('click', '#checkAll', function() {
                if($(this).is(':checked')) {
                    $('.checkbox').prop('checked', true);
                } else {
                    $('.checkbox').prop('checked', false);
                }
            });

            // Enable/disable delete button
            $(document).on('change', 'input[type="checkbox"]', updateButtonState);

            function updateButtonState() {
                var numberOfChecked = $('input[type="checkbox"]:checked').length;
                if(numberOfChecked < 2) {
                    $('#ButtonDeleteAll').prop('disabled', true);
                } else {
                    $('#ButtonDeleteAll').prop('disabled', false);
                }
            }

            // Handle button click
            $('#ButtonDeleteAll').click(function(e) {
                e.preventDefault();

                var id = [];

                $('.checkbox:checked').each(function() {
                    id.push($(this).val());
                });

                Swal.fire({
                    title: 'ต้องการลบตำบลเหล่านี้ใช่ไหม?',
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
                            type: 'POST',
                            url: './delete/branch-area.php', // your PHP script URL
                            data: { 
                                id: id, 
                                type: "multiple"
                            },
                            success: function(response) {
                                Swal.close();

                                if(response == 'success') {
                                    Swal.fire(
                                        'ลบตำบลเหล่านี้เรียบร้อย!',
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

                                    console.log(response);
                                }
                            }
                        });
                    }
                });
            });

            $(".btn-delete-area").on("click", function() {
                const id = $(this).data("id");

                Swal.fire({
                    title: 'ต้องการลบตำบลนี้ใช่ไหม?',
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
                            type: 'POST',
                            url: './delete/branch-area.php', // your PHP script URL
                            data: { 
                                id: id, 
                                type: "single"
                            },
                            success: function(response) {
                                Swal.close();

                                if(response == 'success') {
                                    Swal.fire(
                                        'ลบตำบลเรียบร้อย!',
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

                                    console.log(response)
                                }
                            }
                        });
                    }
                });
            });

            $('#AddAreaModalSubmitButton').click(function () {
                var unindexed_array = $('#AddAreaModalForm').serializeArray();
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
                    url: '<?=$API_URL;?>mapping-branch/insert-mapping-branch',
                    type: 'POST',
                    data: JSON.stringify(indexed_array),
                    contentType: "application/json", 
                    success: function(response) {
                        Swal.close();

                        if (response.responseCode == "000") {
                            Swal.fire(
                                'ดำเนินการสำเร็จ!',
                                '',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'ล้มเหลว!',
                                response.responseDesc,
                                'error'
                            )

                            console.log(response.responseCode)
                            console.log(response.responseDesc)
                        }
                    }
                });
            });
        });

        const AddressSelection = document.getElementById('province');
    
        if (AddressSelection) {
            AddressSelection.addEventListener("change", function() {
                const provinceValue = $(this).val();
                const province = {
                    "provinceId": provinceValue
                };
                
                Swal.showLoading();
                
                $.ajax({
                    url: '<?=$API_URL;?>address/amphur',
                    type: 'POST',
                    data: JSON.stringify(province),
                    contentType: "application/json", 
                    success: function(response) {
                        Swal.close();
                        
                        const amphursArray = response.amphurs;
                        const SelectAmphur = document.getElementById("amphur");
                        const SelectDistrict = document.getElementById("district");
                        
                        SelectAmphur.disabled = false;
                        SelectDistrict.disabled = true;
                        
                        SelectAmphur.value = 0;
                        SelectDistrict.value = 0;
                        
                        
                        if (response.hasOwnProperty('amphurs')) {
                            const amphursArray = response.amphurs;
                            
                            while (SelectAmphur.options.length > 1) {
                                SelectAmphur.remove(1);
                            }
                            
                            amphursArray.forEach(amphur => {
                                const amphurId = amphur.amphurId;
                                const amphurName = amphur.amphurName;
                                
                                // Create a new <option> element
                                const OptionAmphur = document.createElement("option");
                                OptionAmphur.value = amphurId;
                                OptionAmphur.textContent = amphurName.trim(); // Remove extra spaces
                                
                                // Append the <option> element to the <select>
                                SelectAmphur.appendChild(OptionAmphur);
                            });

                            // Add event listener to update the postcode input
                            SelectAmphur.addEventListener("change", function() {
                                Swal.showLoading();
                                
                                const selectedAmphurId = parseInt(SelectAmphur.value);
                                const selectedAmphur = amphursArray.find(amphur => amphur.amphurId === selectedAmphurId);
                                const amphur = {
                                    "provinceID": provinceValue, 
                                    "amphurID": $(this).val()
                                }

                                SelectDistrict.disabled = false;
                                
                                $.ajax({
                                    url: '<?=$API_URL;?>address/district',
                                    type: 'POST',
                                    data: JSON.stringify(amphur),
                                    contentType: "application/json", 
                                    success: function(response) {
                                        Swal.close();
                                        
                                        const districtArray = response.district;
                                        
                                        if (response.hasOwnProperty('districts')) {
                                            const districtArray = response.districts;
                                            
                                            while (SelectDistrict.options.length > 1) {
                                                SelectDistrict.remove(1);
                                            }
                                            
                                            districtArray.forEach(district => {
                                                const districtId = district.districtId;
                                                const districtName = district.districtName;
                                                
                                                // Create a new <option> element
                                                const OptionDistrict = document.createElement("option");
                                                OptionDistrict.value = districtId;
                                                OptionDistrict.textContent = districtName.trim(); // Remove extra spaces
                                                
                                                // Append the <option> element to the <select>
                                                SelectDistrict.appendChild(OptionDistrict);
                                            });
                                        } else {
                                            console.log("No 'district' array found in the JSON data.");
                                        }
                                    },
                                    error: function(error) {
                                        console.error('Error:', error);
                                    }
                                });
                            });
                        } else {
                            console.log("No 'amphurs' array found in the JSON data.");
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });
        }
    </script>

</body>

</html>