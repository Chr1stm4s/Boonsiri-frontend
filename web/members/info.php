<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "member-profile";
        
        require_once "../head.php";

        $ListAddressAPIRequest = [
            'customerId' => $_SESSION['id'],
        ];

        $ListAddressResponse = connect_api("{$API_Link}api/v1/address/list-address-profile", $ListAddressAPIRequest);

        if ($ListAddressResponse['responseCode'] == 000) {

        }
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
                            <li class="breadcrumb-item active" aria-current="page">ข้อมูลสมาชิก</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="POST" id="FormProfile">
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-6 mx-auto">
                    <div class="mx-0 row my-4">
                        <div class="col my-auto">
                            <h1 class="mb-0">ข้อมูลสมาชิก</h1>
                        </div>
                        <div class="col-auto my-auto">
                            <button type="submit" class="btn btn-theme-4 w-100 px-4 rounded-0">บันทึก</button>
                        </div>
                    </div>
                    <div class="mx-0 row g-3">
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ" value="<?=$_SESSION['fname'];?>" required aria-required="true">
                                <label for="fname">ชื่อ</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล" value="<?=$_SESSION['lname'];?>" required aria-required="true">
                                <label for="lname">นามสกุล</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์" inputmode="tel" disabled value="<?=$_SESSION['phone'];?>">
                                <label for="phone">เบอร์โทรศัพท์</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล" value="<?=@$_SESSION['email'];?>">
                                <label for="email">อีเมล</label>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID" value="<?=@$_SESSION['line'];?>">
                                <label for="line">LINE ID</label>
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
        $("#FormProfile").submit(function(e) {
            e.preventDefault();

            const fname = $("#fname").val();
            const lname = $("#lname").val();
            const email = $("#email").val();
            const line = $("#line").val();

            $.post(
                '<?=rootURL();?>action/update-profile/', 
                {
                    fname: fname, 
                    lname: lname, 
                    email: email, 
                    line: line, 
                }, 
                function(result) {
                    if (result == "success") {
                        Swal.fire(
                            'บันทึกข้อมูลสำเร็จ!',
                            '',
                            'success'
                        );
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
        });
    </script>

</body>

</html>