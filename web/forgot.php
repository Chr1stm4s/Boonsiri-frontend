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
            <h1 class="mb-0">ลืมรหัสผ่าน</h1>
            <img src="<?=rootURL();?>images/forget-password.svg" alt="ลืมรหัสผ่าน บุญศิริ" class="member-form-image">
            <form method="POST" id="FormReset">
                <input type="hidden" name="type" value="reset">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 my-3 ms-auto">
                        <div class="form-floating">
                            <input type="tel" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" class="form-control" inputmode="tel" required aria-required="true">
                            <label for="phone" class="text-secondary">เบอร์โทรศัพท์</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 my-3 me-auto">
                        <button type="submit" class="btn btn-dark w-100 h-100" id="SendOTP">เปลี่ยนรหัสผ่าน</button>
                    </div>
                    <div class="col-12 my-3">
                        <p class="mb-0"><a href="<?=rootURL();?>ลงชื่อเข้าใช้งาน/" class="fw-bold">ลงชื่อเข้าใช้งาน</a> หรือ <a href="<?=rootURL();?>สมัครสมาชิก/" class="fw-bold">สมัครสมาชิก</a> ที่นี่</p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function(){
            $("#FormReset").submit(function (event) {
                $('#SendOTP').prop('disabled', false);

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

                fetch("<?=$API_URL;?>otp/send-otp", requestOptions)
                .then(response => response.json())
                .then(
                    obj => {
                        if (obj.responseCode === "000") {
                            Swal.fire(
                                'กรุณาลงชื่อเข้าใช้งานใหม่!', 
                                `รหัสผ่านใหม่ได้ส่งไปที่เบอร์โทรศัพท์ที่ลงทะเบียนแล้ว`, 
                                'success' 
                            ).then(() => {
                                window.location.href = "<?=rootURL();?>ลงชื่อเข้าใช้งาน/";
                            });
                        } else {
                            Swal.fire(
                                'เปลี่ยนรหัสผ่านไม่สำเร็จ!',
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
            });
        });
    </script>

</body>

</html>