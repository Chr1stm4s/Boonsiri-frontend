<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "branches";

        require_once "./head.php";

        $host = "119.59.96.90";
        $database = "boonsiri";
        $user = "christmas";
        $pass = "61Dszy3&9";
        $con=mysqli_connect($host, $user, $pass, $database);
        $conn = new mysqli($host, $user, $pass, $database);
        
        $dbh = new PDO("mysql:host=$host; dbname=$database; charset=utf8;", $user, $pass);
        $dbh->exec("set names utf8");
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check connection
        if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
        
        // Change character set to utf8
        mysqli_set_charset($con,"utf8");

        date_default_timezone_set('Asia/Bangkok');
        setlocale(LC_TIME, 'th_TH.utf8');

        $CountCourier = [
            null => [
                        "count" => 0,
                        "title" => "ยังไม่ได้กำหนด", 
                        "address" => null
                    ],
               1 => [
                        "count" => 0,
                        "title" => "ขนส่งบุญศิริ", 
                        "address" => null
                    ],
               2 => [
                        "count" => 0,
                        "title" => "ขนส่งเอกชน (ภาคเหนือ)", 
                        "address" => null
                    ],
               3 => [
                        "count" => 0,
                        "title" => "ขนส่งเอกชน (ภาคอื่นๆ)", 
                        "address" => null
                    ],
        ];
        
        $Address = array();

        $SQL = "SELECT * FROM `dashboard_branches`";
        $Query = mysqli_query($con, $SQL) or die(mysqli_error($con));
        while ($Result = mysqli_fetch_array($Query)) {
            $CountCourier[$Result['courier_id']]["count"]++;

            $CountCourier[$Result['courier_id']]["address"][] = array(
                "district" => $Result['DISTRICT_NAME'],
                "amphur" => $Result['AMPHUR_NAME'],
                "province" => $Result['PROVINCE_NAME']
            );
        }
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Dashboard - Branches</h1>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-6 col-md-3 my-3">
                    <a href="./branches-dashboard.php?id=1" class="btn btn<?=(@$_GET['id'] == 1) ? "" : "-outline"; ?>-primary w-100 py-3">
                        <p class="card-title">ขนส่งบุญศิริ</p>
                        <h1 class="mb-0"><?=number_format($CountCourier[1]["count"]);?> ตำบล</h1>
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <a href="./branches-dashboard.php?id=2" class="btn btn<?=(@$_GET['id'] == 2) ? "" : "-outline"; ?>-warning w-100 py-3">
                        <p class="card-title">ขนส่งเอกชน (ภาคเหนือ)</p>
                        <h1 class="mb-0"><?=number_format($CountCourier[2]["count"]);?> ตำบล</h1>
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <a href="./branches-dashboard.php?id=3" class="btn btn<?=(@$_GET['id'] == 3) ? "" : "-outline"; ?>-warning w-100 py-3">
                        <p class="card-title">ขนส่งเอกชน (ภาคอื่นๆ)</p>
                        <h1 class="mb-0"><?=number_format($CountCourier[3]["count"]);?> ตำบล</h1>
                    </a>
                </div>
                <div class="col-6 col-md-3 my-3">
                    <a href="./branches-dashboard.php" class="btn btn<?=(@$_GET['id'] == null) ? "" : "-outline"; ?>-secondary w-100 py-3">
                        <p class="card-title">ยังไม่ได้กำหนด &nbsp;<i class="fa-solid fa-circle-info btn-tooltip" data-bs-title="ตำบลที่ไม่ได้กำหนดสายส่งจะใช้งานสายส่งบุญศิริโดยอัตโนมัติ"></i></p>
                        <h1 class="mb-0"><?=number_format($CountCourier[null]["count"]);?> ตำบล</h1>
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th>ตำบล / แขวง</th>
                                <th>อำเภอ / เขต</th>
                                <th>จังหวัด</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $id = (@$_GET['id']) ? $_GET['id'] : null;

                            foreach ($CountCourier[$id]["address"] as $value) {
                        ?>

                            <tr>
                                <td><?=$value['district'];?></td>
                                <td><?=$value['amphur'];?></td>
                                <td><?=$value['province'];?></td>
                            </tr>

                        <?php
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="POST" enctype="multipart/form-data" id="EditBranchModalForm">
    <div class="modal fade" id="EditBranchModal" tabindex="-1" aria-labelledby="EditBranchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="EditBranchModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="branchId" id="EditModalInputID">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" inputmode="tel" required aria-required="true">
                                <label for="phone">เบอร์โทรศัพท์</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="line" id="line" placeholder="LINE@ ID">
                                <label for="line">LINE@ ID</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="address" id="address" placeholder="ที่อยู่">
                                <label for="address">ที่อยู่</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="province" id="province" aria-label="จังหวัด" required aria-required="true">
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
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="amphur" id="amphur" aria-label="อำเภอ / เขต" disabled required aria-required="true">
                                    <option disabled value="0">เลือกอำเภอ / เขต</option>

                                    <?php
                                        $ListAmphurAPIRequest = [
                                            'provinceId' => 0,
                                        ];

                                        $ListAmphurResponse = connect_api("{$API_URL}address/amphur", $ListAmphurAPIRequest);

                                        if ($ListAmphurResponse['responseCode'] == 000) {
                                            foreach ($ListAmphurResponse['amphurs'] as $AmphurData) {
                                    ?>

                                    <option value="<?=$AmphurData['amphurId'];?>"><?=$AmphurData['amphurName'];?></option>

                                    <?php
                                            }
                                        } else {
                                    ?>

                                    <option value="0" disabled selected>ไม่มีข้อมูล</option>

                                    <?php
                                        }
                                    ?>
                                    
                                </select>
                                <label for="amphur">อำเภอ / เขต</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="district" id="district" aria-label="ตำบล / แขวง" disabled required aria-required="true">
                                    <option disabled value="0">เลือกตำบล / แขวง</option>

                                    <?php
                                        $ListDistrictAPIRequest = [
                                            'provinceId' => 0, 
                                            'amphurId' => 0, 
                                        ];

                                        $ListDistrictResponse = connect_api("{$API_URL}address/district", $ListDistrictAPIRequest);

                                        if ($ListDistrictResponse['responseCode'] == 000) {
                                            foreach ($ListDistrictResponse['districts'] as $DistrictData) {
                                    ?>

                                    <option value="<?=$DistrictData['districtId'];?>"><?=$DistrictData['districtName'];?></option>

                                    <?php
                                            }
                                        } else {
                                    ?>

                                    <option value="0" disabled selected>ไม่มีข้อมูล</option>

                                    <?php
                                        }
                                    ?>

                                </select>
                                <label for="district">ตำบล / แขวง</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="postcode" id="postcode" placeholder="รหัสไปรษณีย์" required aria-required="true">
                                <label for="postcode">รหัสไปรษณีย์</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="number" step="any" class="form-control" name="latitude" id="latitude" placeholder="ละติจูด" required aria-required="true">
                                <label for="latitude">ละติจูด</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="number" step="any" class="form-control" name="longitude" id="longitude" placeholder="ลองจิจูด" required aria-required="true">
                                <label for="longitude">ลองจิจูด</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" id="ButtonLoading"><i class="fa-solid fa-spinner fa-pulse"></i></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary" disabled id="ModalSubmitButton">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            const EditBranchModal = document.getElementById('EditBranchModal')
            if (EditBranchModal) {
                EditBranchModal.addEventListener('show.bs.modal', event => {

                    // Button that triggered the modal
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const name = button.getAttribute('data-bs-name')
                    const address = button.getAttribute('data-bs-address')
                    const district = button.getAttribute('data-bs-district')
                    const amphur = button.getAttribute('data-bs-amphur')
                    const phone = button.getAttribute('data-bs-phone')
                    const line = button.getAttribute('data-bs-line')
                    const province = button.getAttribute('data-bs-province')
                    const postcode = button.getAttribute('data-bs-postcode')
                    const latitude = button.getAttribute('data-bs-latitude')
                    const longitude = button.getAttribute('data-bs-longitude')

                    const provinceAPI = {
                        "provinceId": province
                    };

                    const amphurAPI = {
                        "amphurId": amphur
                    };

                    const ModalSubmitButton = EditBranchModal.querySelector('#ModalSubmitButton')
                    const modalTitle = EditBranchModal.querySelector('.modal-title')
                    const modalBodyInputID = EditBranchModal.querySelector('#EditModalInputID')
                    const modalBodyInputAddress = EditBranchModal.querySelector('#address')
                    const modalBodyInputDistrict = EditBranchModal.querySelector('#district')
                    const modalBodyInputAmphur = EditBranchModal.querySelector('#amphur')
                    const modalBodyInputPhone = EditBranchModal.querySelector('#phone')
                    const modalBodyInputLine = EditBranchModal.querySelector('#line')
                    const modalBodyInputProvince = EditBranchModal.querySelector('#province')
                    const modalBodyInputPostcode = EditBranchModal.querySelector('#postcode')
                    const modalBodyInputLatitude = EditBranchModal.querySelector('#latitude')
                    const modalBodyInputLongitude = EditBranchModal.querySelector('#longitude')

                    ModalSubmitButton.disabled = true;

                    $("#ButtonLoading").show();

                    $.ajax({
                        url: '<?=$API_URL;?>address/amphur',
                        type: 'POST',
                        data: JSON.stringify(provinceAPI),
                        contentType: "application/json", 
                        success: function(response) {
                            const amphursArray = response.amphurs;
                            const SelectAmphur = document.getElementById("amphur");

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
                        },
                        complete: function () {
                            $.ajax({
                                url: '<?=$API_URL;?>address/district',
                                type: 'POST',
                                data: JSON.stringify(amphurAPI),
                                contentType: "application/json", 
                                success: function(response) {
                                    
                                    const districtArray = response.district;
                                    const SelectDistrict = document.getElementById("district");

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

                                        ModalSubmitButton.disabled = false;
                                        
                                        $("#ButtonLoading").hide();
                                    } else {
                                        console.log("No 'district' array found in the JSON data.");
                                    }
                                },
                                complete: function () {
                                    modalBodyInputDistrict.value = district;
                                    modalBodyInputDistrict.disabled = false;
                                }, 
                                error: function(error) {
                                    console.error('Error:', error);
                                }
                            });

                            modalBodyInputAmphur.value = amphur;
                            modalBodyInputAmphur.disabled = false;
                        }, 
                        error: function(error) {
                            console.error('Error:', error);
                            console.log(provinceAPI)
                        }
                    });

                    modalTitle.textContent = `แก้ไขข้อมูลสาขา ${name}`
                    modalBodyInputID.value = id
                    modalBodyInputAddress.value = address
                    modalBodyInputPhone.value = phone
                    modalBodyInputLine.value = line
                    modalBodyInputProvince.value = province
                    modalBodyInputPostcode.value = postcode
                    modalBodyInputLatitude.value = latitude
                    modalBodyInputLongitude.value = longitude
                });
            }

            $('#EditBranchModalForm').on("submit", function (e) {
                e.preventDefault();

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
                    url: '<?=$API_URL;?>branch/master/update-branch',
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

                            const amphursArray = response.amphurs;
                            const SelectAmphur = document.getElementById("amphur");
                            const SelectDistrict = document.getElementById("district");
                            const postcodeInput = document.getElementById("postcode");

                            SelectAmphur.disabled = false;
                            SelectDistrict.disabled = true;
                            postcodeInput.disabled = true;

                            SelectAmphur.value = 0;
                            SelectDistrict.value = 0;
                            postcodeInput.value = "";

                            
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

                                Swal.close();

                                // Add event listener to update the postcode input
                                SelectAmphur.addEventListener("change", function() {
                                    Swal.showLoading();

                                    const selectedAmphurId = parseInt(SelectAmphur.value);
                                    const selectedAmphur = amphursArray.find(amphur => amphur.amphurId === selectedAmphurId);
                                    const amphur = {
                                        "provinceID": provinceValue, 
                                        "amphurID": $(this).val()
                                    }

                                    if (selectedAmphur) {
                                        postcodeInput.value = selectedAmphur.postcode;
                                        SelectDistrict.disabled = false;
                                        postcodeInput.disabled = false;

                                        $.ajax({
                                            url: '<?=$API_URL;?>address/district',
                                            type: 'POST',
                                            data: JSON.stringify(amphur),
                                            contentType: "application/json", 
                                            success: function(response) {
                                                
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

                                                    Swal.close();
                                                } else {
                                                    console.log("No 'district' array found in the JSON data.");
                                                }
                                            },
                                            error: function(error) {
                                                console.error('Error:', error);
                                            }
                                        });
                                    } else {
                                        postcodeInput.value = 0;
                                    }
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
        }, false);
    </script>

</body>

</html>