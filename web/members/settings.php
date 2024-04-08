<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "contact";
        
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
                            <li class="breadcrumb-item active" aria-current="page">ตั้งค่าบัญชี</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="POST" id="FormPassword">
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <div class="mx-0 row my-4">
                        <div class="col my-auto">
                            <h1 class="mb-0">ตั้งรหัสผ่าน</h1>
                        </div>
                        <div class="col-auto my-auto">
                            <button type="submit" class="btn btn-theme-4 w-100 px-4 rounded-0">บันทึก</button>
                        </div>
                    </div>
                    <div class="mx-0 row g-3">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="password" placeholder="เปลี่ยนรหัสผ่าน" required aria-required="true">
                                <label for="password">เปลี่ยนรหัสผ่าน</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่" required aria-required="true">
                                <label for="confirm_password">ยืนยันรหัสผ่านใหม่</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>

    <?php require_once "../footer.php"; ?>
    <?php require_once "../js.php"; ?>

    <script>
        $("#FormPassword").submit(function(e) {
            e.preventDefault();

            const password = $("#password").val();
            const confirm_password = $("#confirm_password").val();

            if (password && (password == confirm_password)) {
                $.post(
                    '<?=rootURL();?>action/update-password/', 
                    {
                        password: password, 
                    }, 
                    function(result) {
                        if (result == "success") {
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
                                'กรุณาติดต่อเจ้าหน้าที่',
                                'error'
                            );

                            console.log(result)
                        }
                    }
                );
            } else {
                Swal.fire(
                    'รหัสผ่านไม่ถูกต้อง!',
                    '',
                    'error'
                );
            }
        });
    </script>

</body>

</html>