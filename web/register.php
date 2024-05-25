<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "login";
        
        require_once "./head.php";
    ?>

</head>

<body class="member-form">
    
    <div class="card card-member-form">
        <div class="card-body text-center p-3 p-md-4 p-lg-5">
            <form method="POST" id="FormCheckMember">
                <h1 class="mb-0">สมัครสมาชิก</h1>
                <img src="<?=rootURL();?>images/send-otp.svg" alt="สมัครสมาชิก บุญศิริ" class="member-form-image">
                <input type="hidden" name="type" value="regis">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 my-3 ms-auto">
                        <div class="form-floating">
                            <input type="tel" name="phone" id="CheckPhone" placeholder="เบอร์โทรศัพท์" class="form-control" inputmode="tel" required aria-required="true">
                            <label for="CheckPhone" class="text-secondary">เบอร์โทรศัพท์</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 my-3 me-auto">
                        <button type="submit" class="btn btn-dark w-100 h-100" id="SendOTP">สมัครสมาชิก</button>
                    </div>
                    <div class="col-12 my-3">
                        <p class="mb-0"><a href="<?=rootURL();?>ลืมรหัสผ่าน/" class="fw-bold">ลืมรหัสผ่าน</a> หรือ <a href="<?=rootURL();?>ลงชื่อเข้าใช้งาน/" class="fw-bold">ลงชื่อเข้าใช้งาน</a> ที่นี่</p>
                    </div>
                </div>
            </form>

            <div id="RegisterFormWizard">
                <div class="row steps">
                    <div class="col-4 text-center active" id="Step1Header">
                        <p>ยืนยันตัวตน</p>
                    </div>
                    <div class="col-4 text-center" id="Step2Header">
                        <p>ข้อมูลสมาชิก</p>
                    </div>
                    <div class="col-4 text-center" id="Step3Header">
                        <p>เสร็จสมบูรณ์</p>
                    </div>
                </div>
                <div class="row steps">
                    <div class="col-4 start-step active" id="Step1Number">
                        <span class="step-number mx-auto">1</span>
                    </div>
                    <div class="col-4 middle-step" id="Step2Number">
                        <span class="step-number mx-auto">2</span>
                    </div>
                    <div class="col-4 end-step" id="Step3Number">
                        <span class="step-number mx-auto">3</span>
                    </div>
                </div>

                <!-- Step 1 Elements -->
                <img src="<?=rootURL();?>images/get-otp.svg" alt="สมัครสมาชิก บุญศิริ" class="step-1-element member-form-image">
                <div class="step-1-element row">
                    <div class="col">
                        <p class="mb-0">รหัสยืนยัน (OTP) ได้ส่งไปยัง <span id="OtpNumber"></span></p>
                    </div>
                </div>
                <div class="step-1-element row my-4">
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP1" id="OTP1" inputmode="numeric" onkeyup="focusNext(this, 'OTP2')">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP2" id="OTP2" inputmode="numeric" onkeyup="focusNext(this, 'OTP3')">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP3" id="OTP3" inputmode="numeric" onkeyup="focusNext(this, 'OTP4')">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP4" id="OTP4" inputmode="numeric" onkeyup="focusNext(this, 'OTP5')">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP5" id="OTP5" inputmode="numeric" onkeyup="focusNext(this, 'OTP6')">
                    </div>
                    <div class="col-2">
                        <input type="text" class="form-control mx-auto input-otp" maxlength="1" placeholder="9" oninput="this.value=this.value.replace(/[^0-9]/g,'');" onfocus="this.select()" name="OTP6" id="OTP6" inputmode="numeric" onkeyup="focusNext(this, 'ConfirmOTP')">
                    </div>
                </div>
                <div class="step-1-element row my-4">
                    <div class="col text-center">
                        <button class="btn btn-theme-4 px-5" id="ConfirmOTP">ยืนยันรหัส OTP</button>
                    </div>
                </div>
                <div class="step-1-element row">
                    <div class="col">
                        <button type="button" class="btn text-warning">ขอรหัสยืนยัน OTP ใหม่อีกครั้ง</button>
                    </div>
                </div>
                <!-- Step 1 Elements -->

                <!-- Step 2 Elements -->
                <form action="#" method="POST" id="FormRegister" class="step-2-element mt-4">
                    <input type="hidden" name="phone" id="RegisterPhone">
                    <input type="hidden" name="customerId" id="customerId" value="null">
                    <input type="hidden" name="cardCode" id="customerCode" value="null">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" required aria-required="true">
                                <label for="fname" class="text-secondary">ชื่อ<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" required aria-required="true">
                                <label for="lname" class="text-secondary">นามสกุล<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน" minlength="6" required aria-required="true">
                                <label for="password" class="text-secondary">รหัสผ่าน<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล" inputmode="email">
                                <label for="email" class="text-secondary">อีเมล</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID">
                                <label for="line" class="text-secondary">LINE ID</label>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="#" method="POST" id="FormRegisterAddress" class="step-2-element">
                    <input type="hidden" name="name" id="name" value="ที่อยู่จัดส่งเริ่มต้น">
                    <input type="hidden" name="whsGrpCode" id="whsGrpCode" value="SSK">
                    <input type="hidden" name="whsGrpName" id="whsGrpName" value="สาขาศรีสะเกษ">
                    <input type="hidden" name="isMain" value="1">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="addressMain" id="addressMain" placeholder="ที่อยู่สำหรับจัดส่ง" required aria-required="true">
                                <label for="addressMain" class="text-secondary">ที่อยู่สำหรับจัดส่ง<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="addressSub" id="addressSub" placeholder="ที่อยู่สำหรับจัดส่ง (เพิ่มเติม)">
                                <label for="addressSub" class="text-secondary">ที่อยู่สำหรับจัดส่ง (เพิ่มเติม)</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-select address-select2" name="province" id="province" aria-label="จังหวัด">
                                <option selected disabled value="0">เลือกจังหวัด</option>

                                <?php
                                    $ListProvinceAPIRequest = [
                                        'geoId' => 0,
                                    ];

                                    $ListProvinceResponse = connect_api("$API_Link/v1/address/province", $ListProvinceAPIRequest);

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
                            <select class="form-select address-select2" name="amphur" id="amphur" aria-label="อำเภอ / เขต" disabled>
                                <option selected disabled value="0">เลือกอำเภอ / เขต</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <select class="form-select address-select2" name="district" id="district" aria-label="ตำบล / แขวง" disabled>
                                <option selected disabled value="0">เลือกตำบล / แขวง</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="number" class="form-control" name="postcode" id="postcode" placeholder="รหัสไปรษณีย์" disabled>
                                <label for="postcode" class="text-secondary">รหัสไปรษณีย์<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row step-2-element">
                    <div class="col col-md-6 col-lg-4 mx-auto">
                        <button type="button" class="btn btn-theme-4 w-100" id="RegisterButton">สมัครสมาชิก</button>
                    </div>
                </div>
                <!-- Step 2 Elements -->

                <!-- Step 3 Elements -->
                <h2 class="mt-3 mb-0 step-3-element">สมัครสมาชิกสำเร็จ</h2>
                <img src="<?=rootURL();?>images/signed-up.svg" alt="สมัครสมาชิก บุญศิริ" class="step-3-element member-form-image">

                <div class="row step-3-element">
                    <div class="col col-md-6 col-lg-4 mx-auto">
                        <a href="<?=rootURL();?>" class="btn btn-theme-4 w-100">เข้าสู่ระบบ</a>
                    </div>
                </div>
                <!-- Step 3 Elements -->

            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        function focusNext(currentInput, nextInputId) {
            var inputValue = currentInput.value;
            if (inputValue.length === 1) {
                var nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }
    </script>

    <script>
        $("#RegisterFormWizard").hide();

        $(".step-2-element").hide();
        $(".step-3-element").hide();

        $(document).ready(function(){
            $("#ConfirmOTP").click(function() {
                const OTP1 = $("#OTP1").val();
                const OTP2 = $("#OTP2").val();
                const OTP3 = $("#OTP3").val();
                const OTP4 = $("#OTP4").val();
                const OTP5 = $("#OTP5").val();
                const OTP6 = $("#OTP6").val();

                const otp = OTP1 + OTP2 + OTP3 + OTP4 + OTP5 + OTP6;

                const phone = $("#OtpNumber").text();

                if (OTP1 && OTP2 && OTP3 && OTP4 && OTP5 && OTP6) {
                    // API endpoint
                    const apiUrl = '$API_Link/v1/otp/validate-otp';

                    // Data to send in the request
                    const data = {
                        phone: phone, 
                        otpValue: otp, 
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
                        if (responseData.responseCode == "000") {
                            $("#Step1Header").removeClass("active");
                            $("#Step1Number").removeClass("active");

                            $("#Step2Header").addClass("active");
                            $("#Step2Number").addClass("active");

                            $(".step-1-element").hide();
                            $(".step-2-element").fadeIn();
                        } else {
                            Swal.fire(
                                'รหัสยืนยันไม่ถูกต้อง!',
                                `กรุณาลองใหม่`,
                                'error'
                            ).then(() => {
                                $(".input-otp").val("");
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'ส่ง OTP ไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );
                    });
                } else {
                    Swal.fire(
                        'รหัสยืนยันไม่ถูกต้อง!',
                        `กรุณาลองใหม่`,
                        'error'
                    ).then(() => {
                        $(".input-otp").val("");
                    });
                }
            });

            $("#FormCheckMember").submit(function (event) {
                const phone = $("#CheckPhone").val();

                Swal.fire({
                    title: 'กำลังดำเนินการ', 
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                
                event.preventDefault();

                const formData = new FormData(this);
                
                const formDataObject = {};

                formData.forEach((value, key) => {
                    formDataObject[key] = value;
                });

                const headers = {
                    'Content-Type': 'application/json'
                };

                const requestOptions = {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(formDataObject)
                };

                fetch("$API_Link/v1/boonsiri/check-customer", requestOptions)
                .then(response => response.json())
                .then(
                    obj => {
                        if (obj.responseCode === "000") {
                            Swal.fire({
                                title: 'คุณเป็นสมาชิกอยู่แล้ว!', 
                                showCancelButton: false, 
                                showDenyButton: false, 
                                confirmButtonText: "ลงชื่อเข้าใช้งาน", 
                                icon: 'info' 
                            }).then(() => {
                                window.location.href = "<?=rootURL();?>ลงชื่อเข้าใช้งาน/";
                            });
                        } else if (obj.responseCode === "A06") {
                            $("#Step1Header").removeClass("active");
                            $("#Step1Number").removeClass("active");

                            $("#Step2Header").addClass("active");
                            $("#Step2Number").addClass("active");

                            Swal.close();

                            const userDataResponse = obj.response;

                            console.log(userDataResponse);

                            $("#RegisterPhone").val(phone);
                            $("#FormCheckMember").hide();


                            $(".step-1-element").hide();
                            $(".step-2-element").show();

                            $("#fname").val(userDataResponse.firstname);
                            $("#lname").val(userDataResponse.lastname);
                            $("#email").val(userDataResponse.email);
                            $("#customerId").val(userDataResponse.customerId);
                            $("#customerCode").val(userDataResponse.customerCode);
                            $("#whsGrpCode").val(userDataResponse.whsGrpCode);
                            $("#whsGrpName").val(userDataResponse.whsGrpName);

                            $("#RegisterFormWizard").fadeIn();
                        } else {
                            fetch("$API_Link/v1/otp/send-otp", requestOptions)
                            .then(response => response.json())
                            .then(
                                obj => {
                                    if (obj.responseCode === "000") {
                                        Swal.fire({
                                            title: 'กรุณาตรวจสอบเลข OTP ในมือถือของคุณ!', 
                                            showCancelButton: false, 
                                            showDenyButton: false, 
                                            confirmButtonText: "ดำเนินการต่อ", 
                                            icon: 'success' 
                                        }).then(() => {
                                            $("#OtpNumber").text(phone);
                                            $("#RegisterPhone").val(phone);
                                            $("#FormCheckMember").hide();
                                            $("#RegisterFormWizard").fadeIn();
                                        });
                                    } else if (obj.responseCode === "A05") {
                                        Swal.fire({
                                            title: 'คุณเป็นสมาชิกอยู่แล้ว!', 
                                            showCancelButton: false, 
                                            showDenyButton: false, 
                                            confirmButtonText: "ลงชื่อเข้าใช้งาน", 
                                            icon: 'info' 
                                        }).then(() => {
                                            window.location.href = "<?=rootURL();?>ลงชื่อเข้าใช้งาน/";
                                        });
                                    } else if (obj.responseCode === "A06") {
                                        Swal.fire({
                                            title: 'คุณเป็นสมาชิกอยู่แล้ว!', 
                                            text: 'กรุณาใช้เบอร์โทรศัพท์เป็นรหัสผ่าน', 
                                            showCancelButton: false, 
                                            showDenyButton: false, 
                                            confirmButtonText: "ลงชื่อเข้าใช้งาน", 
                                            icon: 'info' 
                                        }).then(() => {
                                            window.location.href = "<?=rootURL();?>ลงชื่อเข้าใช้งาน/";
                                        });
                                    } else {
                                        Swal.fire(
                                            'สมัครสมาชิกไม่สำเร็จ!',
                                            `กรุณาติดต่อเจ้าหน้าที่`,
                                            'error'
                                        );

                                        console.log(obj)
                                    }
                                }
                            )
                            .catch(
                                error => {
                                    console.error('Error:', error);
                                }
                            );
                        }
                    }
                )
                .catch(
                    error => {
                        console.error('Error:', error);
                    }
                );
            });

            // For test
            // $("#ConfirmOTP").click(function() {
            //     $("#Step1Header").removeClass("active");
            //     $("#Step1Number").removeClass("active");

            //     $("#Step2Header").addClass("active");
            //     $("#Step2Number").addClass("active");

            //     $(".step-1-element").hide();
            //     $(".step-2-element").fadeIn();
            // });

            // $("#FormCheckMember").submit(function (event) {
            //     const phone = $("#CheckPhone").val();

            //     Swal.fire({
            //         title: 'กำลังดำเนินการ', 
            //         didOpen: () => {
            //             Swal.showLoading()
            //         }
            //     });
                
            //     event.preventDefault();

            //     const formData = new FormData(this);
                
            //     const formDataObject = {};

            //     formData.forEach((value, key) => {
            //         formDataObject[key] = value;
            //     });

            //     const headers = {
            //         'Content-Type': 'application/json'
            //     };

            //     const requestOptions = {
            //         method: 'POST',
            //         headers: headers,
            //         body: JSON.stringify(formDataObject)
            //     };

            //     fetch("$API_Link/v1/boonsiri/check-customer", requestOptions)
            //     .then(response => response.json())
            //     .then(
            //         obj => {
            //             if (obj.responseCode === "000") {
            //                 Swal.fire({
            //                     title: 'คุณเป็นสมาชิกอยู่แล้ว!', 
            //                     showCancelButton: false, 
            //                     showDenyButton: false, 
            //                     confirmButtonText: "ลงชื่อเข้าใช้งาน", 
            //                     icon: 'info' 
            //                 }).then(() => {
            //                     window.location.href = "<?=rootURL();?>ลงชื่อเข้าใช้งาน/";
            //                 });
            //             } else if (obj.responseCode === "A06") {
            //                 $("#Step1Header").removeClass("active");
            //                 $("#Step1Number").removeClass("active");

            //                 $("#Step2Header").addClass("active");
            //                 $("#Step2Number").addClass("active");

            //                 Swal.close();

            //                 const userDataResponse = obj.response;

            //                 console.log(userDataResponse);

            //                 $("#RegisterPhone").val(phone);
            //                 $("#FormCheckMember").hide();


            //                 $(".step-1-element").hide();
            //                 $(".step-2-element").show();

            //                 $("#fname").val(userDataResponse.firstname);
            //                 $("#lname").val(userDataResponse.lastname);
            //                 $("#email").val(userDataResponse.email);
            //                 $("#customerId").val(userDataResponse.customerId);
            //                 $("#customerCode").val(userDataResponse.customerCode);
            //                 $("#whsGrpCode").val(userDataResponse.whsGrpCode);
            //                 $("#whsGrpName").val(userDataResponse.whsGrpName);

            //                 $("#RegisterFormWizard").fadeIn();
            //             } else {
            //                 Swal.fire({
            //                     title: 'กรุณาตรวจสอบเลข OTP ในมือถือของคุณ!', 
            //                     showCancelButton: false, 
            //                     showDenyButton: false, 
            //                     confirmButtonText: "ดำเนินการต่อ", 
            //                     icon: 'success' 
            //                 }).then(() => {
            //                     $("#OtpNumber").text(phone);
            //                     $("#RegisterPhone").val(phone);
            //                     $("#FormCheckMember").hide();
            //                     $("#RegisterFormWizard").fadeIn();
            //                 });
            //             }
            //         }
            //     )
            //     .catch(
            //         error => {
            //             console.error('Error:', error);
            //         }
            //     );
            // });
            // For test

            $("#FormLogin").submit(function (event) {
                Swal.fire({
                    title: 'กำลังเข้าสู่ระบบ',
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                event.preventDefault();

                const formData = new FormData(this);

                const formDataObject = {};
                formData.forEach((value, key) => {
                    formDataObject[key] = value;
                });

                const headers = {
                    'Content-Type': 'application/json'
                };

                const requestOptions = {
                    method: 'POST',
                    headers: headers,
                    body: JSON.stringify(formDataObject)
                };

                fetch("$API_Link/v1/customer/login", requestOptions)
                .then(response => response.json())
                .then(
                    obj => {
                        if (obj.responseCode === "000") {
                            $.post(
                                "<?=rootURL();?>action/login/", 
                                {
                                    id: obj.id,
                                    fname: obj.fname,
                                    lname: obj.lname,
                                    email: obj.email,
                                    phone: obj.phone, 
                                    line: obj.line, 
                                    address_id: obj.addressProfileId, 
                                    address_main: obj.addressMain, 
                                    address_sub: obj.addressSub, 
                                    district: obj.district, 
                                    amphur: obj.amphur, 
                                    province: obj.province, 
                                    postcode: obj.postcode, 
                                    whsCode: obj.whsCode, 
                                }, 
                                function(result) {
                                    if (result == "success") {
                                        Swal.fire(
                                            'ลงชื่อเข้าใช้งานสำเร็จ!',
                                            `ยินดีต้อนรับ คุณ ${obj.fname} ${obj.lname}`,
                                            'success'
                                        ).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            'ลงชื่อเข้าใช้งานไม่สำเร็จ!',
                                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                            'error'
                                        );

                                        console.log(obj);
                                        console.log(result);
                                    }
                                }
                            );
                        } else {
                            Swal.fire(
                                'ลงชื่อเข้าใช้งานไม่สำเร็จ!',
                                `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                'error'
                            );

                            console.log(obj)
                        }
                    }
                )
                .catch(
                    error => {
                        console.error('Error:', error);
                    }
                );
            });

            $("#RegisterButton").click(function() {
                if (!$("#fname").val() || !$("#lname").val() || !$("#password").val()) {
                    Swal.fire(
                        'กรุณากรอกข้อมูลให้ถูกต้อง!',
                        ``,
                        'error'
                    );
                } else {
                    console.log(`customerId : ${$("#customerId").val()}`)
                    console.log(`customerCode : ${$("#customerCode").val()}`)

                    if ($("#customerId").val() == "null" && $("#customerCode").val() == "null") {
                        console.log("null");

                        var formValue = $("#FormRegister").serializeArray();
                        var indexFormValue = {};

                        $.map(formValue, function(n, i){
                            indexFormValue[n['name']] = n['value'];
                        });

                        let customerData = {
                            "customerId": null,
                            "firstname": indexFormValue.fname,
                            "lastname": indexFormValue.lname,
                            "aliasName": "",
                            "dateOfBirth": "",
                            "phone1": indexFormValue.phone,
                            "phone2": "",
                            "email": indexFormValue.email,
                            "shippingType": "1",
                            "userResponsible": "012265",
                            "branchId": 1,
                            "whsGrpCode": "SSK",
                            "whsGrpName": "สาขาศรีสะเกษ",
                            "customerTypeCode": "T01",
                            "customerType": "แปรรูปปลาทู",
                            "knowus": "F01",
                            "knowusCode": "Facebook",
                            "addresses": [
                                {
                                    "addressType": "bo_BillTo",
                                    "checkAddressName": "",
                                    "addressName": "",
                                    "street": "",
                                    "block": "",
                                    "city": "",
                                    "country": "",
                                    "zipCode": "",
                                    "visOrder": "",
                                    "U_BFP_Amphur": "",
                                    "U_BFP_Tambon": "",
                                    "U_ISS_RouteCode": "",
                                    "U_ISS_RouteName": "",
                                    "U_BFP_Latitude": "",
                                    "U_BFP_Longitude": ""
                                }
                            ],
                            "branches": [
                                {
                                    "branchCode": "1",
                                    "branchName": "SSK",
                                    "whGrpName": "สาขาศรีสะเกษ"
                                }
                            ]
                        };

                        console.log(JSON.stringify(customerData, null, 2));

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

                        console.log(`customerData : ${JSON.stringify(customerData, null, 4)}`)

                        $.ajax({
                            url: '<?=$API_Link;?>api/v1/boonsiri/create-customer-to-pos',
                            type: 'POST',
                            data: JSON.stringify(customerData),
                            contentType: "application/json", 
                            success: function(response) {
                                if (response.responseCode == "000") {
                                    const formDataObject = {
                                        "phone": indexFormValue.phone
                                    };

                                    console.log(`Form Phone : ${JSON.stringify(formDataObject, null, 4)}`)

                                    const headers = {
                                        'Content-Type': 'application/json'
                                    };

                                    const requestOptions = {
                                        method: 'POST',
                                        headers: headers,
                                        body: JSON.stringify(formDataObject)
                                    };

                                    fetch("<?=$API_Link;?>api/v1/boonsiri/check-customer", requestOptions)
                                    .then(response => response.json())
                                    .then(
                                        obj => {
                                            if (obj.responseCode === "A06") {
                                                const userDataResponse = obj.response;

                                                $("#customerId").val(userDataResponse.customerId);
                                                $("#customerCode").val(userDataResponse.customerCode);
                    
                                                console.log(`CheckCustomer - customerId : ${userDataResponse.customerId}`)
                                                console.log(`CheckCustomer - customerCode : ${userDataResponse.customerCode}`)

                                                var unindexed_array = $("#FormRegister").serializeArray();
                                                var indexed_array = {};

                                                $.map(unindexed_array, function(n, i){
                                                    indexed_array[n['name']] = n['value'];
                                                });

                                                $.ajax({
                                                    url: '<?=$API_Link;?>api/v1/customer/add-customer',
                                                    type: 'POST',
                                                    data: JSON.stringify(indexed_array),
                                                    contentType: "application/json", 
                                                    success: function(response) {
                                                        if (response.responseCode == "000") {
                                                            const UserID = response.id;
                                                            const fname = indexed_array.fname;
                                                            const lname = indexed_array.lname;
                                                            const email = indexed_array.email;
                                                            const phone = indexed_array.phone;
                                                            const line = indexed_array.line;
                                                            
                                                            var FormRegisterAddress = $("#FormRegisterAddress").serializeArray();
                                                            var FormRegisterAddressArray = {};

                                                            $.map(FormRegisterAddress, function(n, i){
                                                                FormRegisterAddressArray[n['name']] = n['value'];
                                                            });
                                                            
                                                            FormRegisterAddressArray['customerId'] = UserID;
                                                            FormRegisterAddressArray['fname'] = fname;
                                                            FormRegisterAddressArray['lname'] = lname;
                                                            FormRegisterAddressArray['phone'] = phone;
                                                            FormRegisterAddressArray['email'] = email;
                                                            FormRegisterAddressArray['line'] = line;

                                                            $.ajax({
                                                                url: '<?=$API_Link;?>api/v1/address/insert-address-profile',
                                                                type: 'POST',
                                                                data: JSON.stringify(FormRegisterAddressArray),
                                                                contentType: "application/json", 
                                                                success: function(response) {
                                                                    if (response.responseCode == "000") {
                                                                        $.post(
                                                                            "<?=rootURL();?>action/login/", 
                                                                            {
                                                                                id: UserID, 
                                                                                fname: fname, 
                                                                                lname: lname, 
                                                                                email: email, 
                                                                                line: line, 
                                                                                phone: phone, 
                                                                                address_id: response.addressProfile.id, 
                                                                                fname: response.addressProfile.fname, 
                                                                                lname: response.addressProfile.lname, 
                                                                                addressMain: response.addressProfile.addressMain, 
                                                                                addressSub: response.addressProfile.addressSub, 
                                                                                district: response.addressProfile.district, 
                                                                                amphur: response.addressProfile.amphur, 
                                                                                province: response.addressProfile.province, 
                                                                                postcode: response.addressProfile.postcode, 
                                                                                whsCode: response.addressProfile.whsCode, 
                                                                            }, 
                                                                            function(result) {
                                                                                Swal.close();

                                                                                if (result == "success") {
                                                                                    $("#Step2Header").removeClass("active");
                                                                                    $("#Step2Number").removeClass("active");

                                                                                    $("#Step3Header").addClass("active");
                                                                                    $("#Step3Number").addClass("active");

                                                                                    $(".step-2-element").hide();
                                                                                    $(".step-3-element").fadeIn();
                                                                                } else {
                                                                                    Swal.fire(
                                                                                        'ลงชื่อเข้าใช้งานไม่สำเร็จ!',
                                                                                        `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                                                        'error'
                                                                                    );

                                                                                    console.log(result)
                                                                                    console.log(response)
                                                                                }
                                                                            }
                                                                        );
                                                                    } else {
                                                                        Swal.fire(
                                                                            'เพิ่มที่อยู่ไม่สำเร็จ!',
                                                                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                                            'error'
                                                                        );
                                                                        console.log(`Form Address : ${JSON.stringify(FormRegisterAddressArray, null, 4)}`)
                                                                        console.log(FormRegisterAddressArray)
                                                                        console.log(response)
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            Swal.fire(
                                                                'สมัครสมาชิกไม่สำเร็จ!',
                                                                `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                                'error'
                                                            );

                                                            console.log(FormRegisterAddressArray)
                                                            console.log(response)
                                                        }
                                                    }
                                                });
                                            } else {
                                                console.log(obj)

                                                debugger
                                            }
                                        }
                                    )
                                    .catch(
                                        error => {
                                            console.error('Error:', error);
                                        }
                                    );
                                } else {
                                    Swal.fire(
                                        'สมัครสมาชิกไม่สำเร็จ!',
                                        `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                        'error'
                                    );

                                    console.log(response)
                                }
                            }
                        });
                    } else {
                        console.log("ok");

                        const formDataObject = {
                            "phone": $("#RegisterPhone").val()
                        };

                        console.log(`Form Phone : ${JSON.stringify(formDataObject, null, 4)}`)

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

                        const headers = {
                            'Content-Type': 'application/json'
                        };

                        const requestOptions = {
                            method: 'POST',
                            headers: headers,
                            body: JSON.stringify(formDataObject)
                        };

                        fetch("<?=$API_Link;?>api/v1/boonsiri/check-customer", requestOptions)
                        .then(response => response.json())
                        .then(
                            obj => {
                                if (obj.responseCode === "A06") {
                                    const userDataResponse = obj.response;

                                    $("#customerId").val(userDataResponse.customerId);
                                    $("#customerCode").val(userDataResponse.customerCode);
                    
                                    console.log(`customerId : ${userDataResponse.customerId}`)
                                    console.log(`customerCode : ${userDataResponse.customerCode}`)

                                    var unindexed_array = $("#FormRegister").serializeArray();
                                    var indexed_array = {};

                                    $.map(unindexed_array, function(n, i){
                                        indexed_array[n['name']] = n['value'];
                                    });

                                    $.ajax({
                                        url: '<?=$API_Link;?>api/v1/customer/add-customer',
                                        type: 'POST',
                                        data: JSON.stringify(indexed_array),
                                        contentType: "application/json", 
                                        success: function(response) {
                                            if (response.responseCode == "000") {
                                                const UserID = response.id;
                                                const fname = indexed_array.fname;
                                                const lname = indexed_array.lname;
                                                const email = indexed_array.email;
                                                const phone = indexed_array.phone;
                                                const line = indexed_array.line;
                                                
                                                var FormRegisterAddress = $("#FormRegisterAddress").serializeArray();
                                                var FormRegisterAddressArray = {};

                                                $.map(FormRegisterAddress, function(n, i){
                                                    FormRegisterAddressArray[n['name']] = n['value'];
                                                });
                                                
                                                FormRegisterAddressArray['customerId'] = UserID;
                                                FormRegisterAddressArray['fname'] = fname;
                                                FormRegisterAddressArray['lname'] = lname;
                                                FormRegisterAddressArray['phone'] = phone;
                                                FormRegisterAddressArray['email'] = email;
                                                FormRegisterAddressArray['line'] = line;

                                                $.ajax({
                                                    url: '<?=$API_Link;?>api/v1/address/insert-address-profile',
                                                    type: 'POST',
                                                    data: JSON.stringify(FormRegisterAddressArray),
                                                    contentType: "application/json", 
                                                    success: function(response) {
                                                        if (response.responseCode == "000") {
                                                            $.post(
                                                                "<?=rootURL();?>action/login/", 
                                                                {
                                                                    id: UserID, 
                                                                    fname: fname, 
                                                                    lname: lname, 
                                                                    email: email, 
                                                                    line: line, 
                                                                    phone: phone, 
                                                                    address_id: response.addressProfile.id, 
                                                                    fname: response.addressProfile.fname, 
                                                                    lname: response.addressProfile.lname, 
                                                                    addressMain: response.addressProfile.addressMain, 
                                                                    addressSub: response.addressProfile.addressSub, 
                                                                    district: response.addressProfile.district, 
                                                                    amphur: response.addressProfile.amphur, 
                                                                    province: response.addressProfile.province, 
                                                                    postcode: response.addressProfile.postcode, 
                                                                    whsCode: response.addressProfile.whsCode, 
                                                                }, 
                                                                function(result) {
                                                                    Swal.close();

                                                                    if (result == "success") {
                                                                        $("#Step2Header").removeClass("active");
                                                                        $("#Step2Number").removeClass("active");

                                                                        $("#Step3Header").addClass("active");
                                                                        $("#Step3Number").addClass("active");

                                                                        $(".step-2-element").hide();
                                                                        $(".step-3-element").fadeIn();
                                                                    } else {
                                                                        Swal.fire(
                                                                            'ลงชื่อเข้าใช้งานไม่สำเร็จ!',
                                                                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                                            'error'
                                                                        );

                                                                        console.log(result)
                                                                        console.log(response)
                                                                    }
                                                                }
                                                            );
                                                        } else {
                                                            Swal.fire(
                                                                'เพิ่มที่อยู่ไม่สำเร็จ!',
                                                                `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                                'error'
                                                            );
                                                            console.log(`Form Address : ${JSON.stringify(FormRegisterAddressArray, null, 4)}`)
                                                            console.log(FormRegisterAddressArray)
                                                            console.log(response)
                                                        }
                                                    }
                                                });
                                            } else {
                                                Swal.fire(
                                                    'สมัครสมาชิกไม่สำเร็จ!',
                                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                                    'error'
                                                );

                                                console.log(FormRegisterAddressArray)
                                                console.log(response)
                                            }
                                        }
                                    });
                                } else {
                                    console.log(obj)
                                }
                            }
                        )
                        .catch(
                            error => {
                                console.error('Error:', error);
                            }
                        );
                    }
                }
            });
        });
    </script>

</body>

</html>