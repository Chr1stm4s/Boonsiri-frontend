<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "jobs";
        
        require_once "./head.php";

        $id = $_GET['id'];

        $requestData = [
            "id" => $id,
        ];

        $data = connect_api("https://www.ecmapi.boonsiri.co.th/api/v1/job/get-job", $requestData);

        if ($data['responseCode'] === "000") {
            $JobData = $data['job'];
        } else {
            var_dump($data);

            exit();
        }
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>ร่วมงานกับเรา/" class="text-theme-1">ร่วมงานกับเรา</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ตำแหน่งงาน <?=$JobData['title'];?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h1>ตำแหน่ง: <b><?=$JobData['title'];?></b></h1>
                    <table class="table table-borderless table-hover table-jobs">
                        <tbody>
                            <tr>
                                <th class="fit text-end">รายละเอียดงาน : </th>
                                <td><?=$JobData['description'];?></td>
                            </tr>
                            <tr>
                                <th class="fit text-end">เงินเดือน : </th>
                                <td><?=number_format($JobData['salary']);?> บาท</td>
                            </tr>
                            <tr>
                                <th class="fit text-end">จำนวนอัตราจ้าง : </th>
                                <td><?=$JobData['workingHour'];?></td>
                            </tr>
                            <tr>
                                <th class="fit text-end">สถานที่ปฏิบัติงาน</th>
                                <td><?=$JobData['location'];?></td>
                            </tr>
                            <tr>
                                <th class="fit text-end">โพสต์เมื่อ</th>
                                <td><?=time_ago("TH", $JobData['added']);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-md-5 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row mx-0 mb-4">
                                <div class="col-auto px-0">
                                    <h3 class="border-bottom border-2 border-info">กรอกใบสมัคร</h3>
                                </div>
                            </div>
                            <form method="POST" enctype="multipart/form-data" id="FormApplyJob">
                                <input type="hidden" name="job_id" value="<?=$id;?>">
                                <div class="mb-3">
                                    <label for="name" class="form-label">ชื่อผู้ติดต่อ</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="ชื่อผู้ติดต่อ" required aria-required="true">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">อีเมล</label>
                                    <input type="email" class="form-control" name="email" id="email" inputmode="email" placeholder="youremail@email.com" required aria-required="true">
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                                    <input type="tel" class="form-control" name="phone" id="phone" inputmode="numeric" placeholder="099-999-9999" required aria-required="true">
                                </div>
                                <div class="mb-3">
                                    <label for="line" class="form-label">LINE ID</label>
                                    <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID" required aria-required="true">
                                </div>
                                <div class="mb-4">
                                    <label for="resume" class="form-label">อัปโหลด Resume</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="resume" id="resume" required aria-required="true" accept="image/*, .pdf">
                                        <label class="input-group-text" for="resume">Upload</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary px-4">สมัครงาน &nbsp;<i class="fa-solid fa-briefcase"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function() {
            $('#FormApplyJob').submit(function(e) {
                e.preventDefault();

                var form = $(this)[0];
                var data = new FormData(form);

                Swal.fire({
                    title: 'กำลังส่งข้อมูล...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    type: 'POST',
                    enctype: 'multipart/form-data',
                    url: '<?=rootURL();?>action/apply-job/',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    success: function(response) {
                        Swal.close();

                        if (response == "success") {
                            Swal.fire(
                                'ส่งข้อมูลสำเร็จ!',
                                'เราจะติดต่อกลับโดยเร็วที่สุด.',
                                'success'
                            );
                        } else if (response == "sending") {
                            Swal.fire(
                                'ไม่สามารถส่งข้อมูลได้!',
                                'กรุณาติดต่อเจ้าหน้าที่',
                                'error'
                            );
                        } else if (response == "upload") {
                            Swal.fire(
                                'ไม่สามารถส่งไฟล์ได้!',
                                'กรุณาติดต่อเจ้าหน้าที่',
                                'error'
                            );
                        } else {
                            Swal.fire(
                                'ส่งข้อมูลล้มเหลว!',
                                'กรุณาติดต่อเจ้าหน้าที่',
                                'error'
                            );
                        }
                    },
                    error: function(e) {
                        Swal.fire(
                            'ส่งข้อมูลล้มเหลว!',
                            'กรุณาติดต่อเจ้าหน้าที่',
                            'error'
                        );
                    }
                });
            });
        });
    </script>

</body>

</html>