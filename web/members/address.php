<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "member-address";
        
        require_once "../head.php";
    ?>

</head>

<body>
    
    <?php require_once "../header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>สมาชิก/" class="text-theme-1">สมาชิก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ที่อยู่จัดส่ง</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row my-4">
                <div class="col-12 col-md my-auto mb-4 mb-md-0 text-center text-md-start">
                    <h1 class="mb-0">รายการที่อยู่จัดส่ง</h1>
                </div>
                <div class="col-9 col-md-auto m-auto">
                    <button type="button" class="btn btn-theme-4 w-100 px-4 rounded-0" data-bs-toggle="collapse" data-bs-target="#AddressCollapse" data-bs-id="0">เพิ่มโปรไฟล์ที่อยู่จัดส่ง</button>
                </div>
            </div>
            <div class="collapse my-4" id="AddressCollapse">
                <div class="card card-body">
                    <form method="POST" id="AddressProfileForm">
                        <input type="hidden" name="customerId" value="<?=$_SESSION['id'];?>" id="customerId">
                        <input type="hidden" name="id" id="id">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="บ้าน, ที่ทำงาน, ร้านค้า" required aria-required="true">
                                    <label for="name">ตั้งชื่อโปรไฟล์จัดส่ง <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" required aria-required="true">
                                    <label for="fname">ชื่อ <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล">
                                    <label for="lname">นามสกุล</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" inputmode="tel" required aria-required="true">
                                    <label for="phone">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล">
                                    <label for="email">อีเมล</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="address_main" id="addressMain" placeholder="ที่อยู่" required aria-required="true">
                                    <label for="addressMain">ที่อยู่ <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="address_sub" id="addressSub" placeholder="ที่อยู่ (เพิ่มเติม)">
                                    <label for="addressSub">ที่อยู่ (เพิ่มเติม)</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select" name="province" id="province" aria-label="จังหวัด" required aria-required="true">
                                    <option selected disabled value="0">เลือกจังหวัด</option>

                                    <?php
                                        $ListProvinceAPIRequest = [
                                            'geoId' => 0,
                                        ];

                                        $ListProvinceResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/address/province", $ListProvinceAPIRequest);

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
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select" name="amphur" id="amphur" aria-label="อำเภอ / เขต" disabled required aria-required="true">
                                    <option selected disabled value="0">เลือกอำเภอ / เขต</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select" name="district" id="district" aria-label="ตำบล / แขวง" disabled required aria-required="true">
                                    <option selected disabled value="0">เลือกตำบล / แขวง</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="postcode" id="postcode" placeholder="รหัสไปรษณีย์" inputmode="numeric" required aria-required="true">
                                    <label for="postcode">รหัสไปรษณีย์</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID">
                                    <label for="line">LINE ID</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-md-auto ms-auto d-flex">
                                <div class="form-check my-auto">
                                    <input class="form-check-input" type="checkbox" value="1" name="isMain" id="isMain">
                                    <label class="form-check-label" for="isMain">
                                        ตั้งค่าเป็นที่อยู่จัดส่ง
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-auto px-md-0 order-1 order-md-0">
                                <button type="button" class="btn w-100 btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            </div>
                            <div class="col-12 col-md-auto my-3 my-md-0 order-0 order-md-1">
                                <button type="submit" class="btn w-100 btn-primary">บันทึกข้อมูล</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr>
                                    <th class="fit">ลำดับ</th>
                                    <th class="fit">ชื่อโปรไฟล์</th>
                                    <th>ชื่อผู้รับ</th>
                                    <th class="fit">เบอร์โทรศัพท์</th>
                                    <th>ที่อยู่จัดส่ง</th>
                                    <th class="fit text-end">เครื่องมือ</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php
                                $ListAddressAPIRequest = [
                                    'customerId' => $_SESSION['id'],
                                ];
                
                                $ListAddressResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/address/list-address-profile", $ListAddressAPIRequest);
                
                                if ($ListAddressResponse['responseCode'] == 000) {
                                    $count = 1;

                                    foreach ($ListAddressResponse['addressProfile'] as $AddressProfileResult) {
                                        if($AddressProfileResult['isMain'] == 1) { 
                                            $icon = '<i class="fa-solid fa-circle-check text-primary"></i>';
                                            $button = '';
                                        } else {
                                            $icon = '';
                                            $button = '<button class="btn btn-primary rounded-0 btn-set btn-tooltip" data-id="'.$AddressProfileResult['id'].'" data-bs-title="ตั้งค่าเป็นที่อยู่จัดส่ง"><i class="fa-solid fa-check"></i></button>';
                                        }
                            ?>

                                <tr>
                                    <th class="text-end"><?=$count;?></th>
                                    <td class="fit"><?=$AddressProfileResult['name'];?></td>
                                    <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$AddressProfileResult['fname'];?>&nbsp;<?=$AddressProfileResult['lname'];?>"><?=$AddressProfileResult['fname'];?>&nbsp;<?=$AddressProfileResult['lname'];?>&nbsp;<?=$icon;?></p></td>
                                    <td class="text-center"><?=$AddressProfileResult['phone'];?></td>
                                    <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$AddressProfileResult['addressMain'];?> <?=$AddressProfileResult['addressSub'];?> <?=$AddressProfileResult['districtName'];?> <?=$AddressProfileResult['amphurName'];?> <?=$AddressProfileResult['provinceName'];?> <?=$AddressProfileResult['postcode'];?>"><?=$AddressProfileResult['addressMain'];?> <?=$AddressProfileResult['addressSub'];?> <?=$AddressProfileResult['districtName'];?> <?=$AddressProfileResult['amphurName'];?> <?=$AddressProfileResult['provinceName'];?> <?=$AddressProfileResult['postcode'];?></p></td>
                                    <td class="fit text-end">
                                        <?=$button;?>
                                        <button class="btn btn-danger rounded-0 btn-delete btn-tooltip" data-id="<?=$AddressProfileResult['id'];?>" data-bs-title="ลบข้อมูล"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>

                            <?php
                                        $count++;
                                    }
                                } else {
                            ?>

                                <tr>
                                    <th class="text-center" colspan="6">ยังไม่มีที่อยู่จัดส่ง</th>
                                </tr>

                            <?php
                                }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

    <script>
        $("#AddressProfileForm").on("submit", function(e) {
            e.preventDefault();

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

            const str = $(this).serializeArray();

            $.ajax({  
                type: "POST",  
                url: "<?=rootURL();?>action/insert-address/",  
                data: str,  
                success: function(response) {  
                    if (response == "success") {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ!',
                            '',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'บันทึกข้อมูลไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );

                        console.log(response)
                    }
                }
            });
        });

        $(".btn-delete").click(function() {
            const id = $(this).data("id");

            Swal.fire({
                icon: 'info', 
                title: 'ยืนยันการลบโปรไฟล์จัดส่ง?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: `ยกเลิก`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({  
                        type: "POST",  
                        url: "<?=rootURL();?>action/delete-address/",  
                        data: {
                            id: id 
                        },  
                        success: function(response) {  
                            if (response == "success") {
                                Swal.fire(
                                    'ลบข้อมูลสำเร็จ!',
                                    '',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'ลบข้อมูลไม่สำเร็จ!',
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );

                                console.log(response)
                            }
                        }
                    });
                }
            });
        });

        $(".btn-set").click(function() {
            const address_id = $(this).data("id");

            Swal.fire({
                icon: 'info', 
                title: 'ยืนยันการตั้งค่าที่อยู่จัดส่ง?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: `ยกเลิก`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({  
                        type: "POST",  
                        url: "<?=rootURL();?>action/set-address/",  
                        data: {
                            address_id: address_id 
                        },  
                        success: function(response) {  
                            if (response == "success") {
                                Swal.fire(
                                    'ตั้งค่าที่อยู่จัดส่งสำเร็จ!',
                                    '',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'ตั้งค่าที่อยู่จัดส่งไม่สำเร็จ!',
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );

                                console.log(response)
                            }
                        }
                    });
                }
            });
        });
        
        const AddressModal = document.getElementById('AddressModal')
        if (AddressModal) {
            AddressModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                
                const id = button.getAttribute('data-bs-id')
                const name = button.getAttribute('data-bs-name')
                const fname = button.getAttribute('data-bs-fname')
                const lname = button.getAttribute('data-bs-lname')
                const phone = button.getAttribute('data-bs-phone')
                const email = button.getAttribute('data-bs-email')
                const line = button.getAttribute('data-bs-line')
                const address_main = button.getAttribute('data-bs-address-main')
                const address_sub = button.getAttribute('data-bs-address-sub')
                const district = button.getAttribute('data-bs-district')
                const amphur = button.getAttribute('data-bs-amphur')
                const province = button.getAttribute('data-bs-province')
                const postcode = button.getAttribute('data-bs-postcode')
                const isMain = button.getAttribute('data-bs-isMain')
                
                const modalTitle = AddressModal.querySelector('.modal-title')
                const modalBodyInputId = AddressModal.querySelector('.modal-body #id')
                const modalBodyInputName = AddressModal.querySelector('.modal-body #name')
                const modalBodyInputFname = AddressModal.querySelector('.modal-body #fname')
                const modalBodyInputLname = AddressModal.querySelector('.modal-body #lname')
                const modalBodyInputPhone = AddressModal.querySelector('.modal-body #phone')
                const modalBodyInputEmail = AddressModal.querySelector('.modal-body #email')
                const modalBodyInputLine = AddressModal.querySelector('.modal-body #line')
                const modalBodyInputAddressMain = AddressModal.querySelector('.modal-body #addressMain')
                const modalBodyInputAddressSub = AddressModal.querySelector('.modal-body #addressSub')
                const modalBodyInputDistrict = AddressModal.querySelector('.modal-body #district')
                const modalBodyInputAmphur = AddressModal.querySelector('.modal-body #amphur')
                const modalBodyInputProvince = AddressModal.querySelector('.modal-body #province')
                const modalBodyInputPostcode = AddressModal.querySelector('.modal-body #postcode')
                const modalBodyInputIsMain = AddressModal.querySelector('.modal-body #isMain')

                modalTitle.textContent = (id == 0) ? 'เพิ่มที่อยู่จัดส่ง' : 'แก้ไขที่อยู่จัดส่ง'
                modalBodyInputId.value = id
            })
        }
    </script>

</body>

</html>