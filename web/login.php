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
            <h1 class="mb-0">ลงชื่อเข้าใช้งาน</h1>
            <img src="<?=rootURL();?>images/login-member.svg" alt="ลงชื่อเข้าใช้งาน บุญศิริ" class="member-form-image">
            <form method="POST" id="FormLogin">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 my-3">
                        <div class="form-floating">
                            <input type="tel" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" class="form-control" inputmode="tel" required aria-required="true">
                            <label for="phone" class="text-secondary">เบอร์โทรศัพท์</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 my-3">
                        <div class="form-floating">
                            <input type="password" name="password" id="password" placeholder="รหัสผ่าน" class="form-control" required aria-required="true">
                            <label for="password" class="text-secondary">รหัสผ่าน</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 my-3 mx-auto">
                        <button type="submit" class="btn btn-dark w-100 h-100">ลงชื่อเข้าใช้งาน</button>
                    </div>
                    <div class="clearfix d-block d-lg-none"></div>
                    <div class="col-12 my-3">
                        <p class="mb-0"><a href="<?=rootURL();?>ลืมรหัสผ่าน/" class="fw-bold">ลืมรหัสผ่าน</a> หรือ <a href="<?=rootURL();?>สมัครสมาชิก/" class="fw-bold">สมัครสมาชิก</a> ที่นี่</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function(){
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
                                    addressMain: obj.addressMain, 
                                    addressSub: obj.addressSub, 
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
                                            window.location.href = "<?=rootURL();?>";
                                        });
                                    } else {
                                        Swal.fire(
                                            'ลงชื่อเข้าใช้งานไม่สำเร็จ!',
                                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                            'error'
                                        );

                                        console.log(result)
                                    }
                                }
                            );
                        } else if (obj.responseCode === "A03") {
                            Swal.fire({
                                title: 'คุณยังไม่เป็นสมาชิก!',  
                                showCancelButton: false, 
                                showDenyButton: false, 
                                confirmButtonText: "สมัครสมาชิก", 
                                icon: 'info' 
                            }).then(() => {
                                window.location.href = "<?=rootURL();?>สมัครสมาชิก/";
                            });
                        } else if (obj.responseCode === "A02") {
                            Swal.fire({
                                title: 'รหัสผ่านไม่ถูกต้อง!',  
                                showCancelButton: false, 
                                showDenyButton: false, 
                                icon: 'info' 
                            });
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
        });
    </script>

</body>

</html>