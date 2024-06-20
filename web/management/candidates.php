<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "jobs";

        require_once "./head.php";

        $id = $_GET['id'];

        $JobApiUrl = "{$API_URL}job/get-job";
        $JobApiRequest = [
            "id" => $id
        ];
        
        $JobData = connect_api($JobApiUrl, $JobApiRequest);
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-auto my-auto">
                    <a href="./jobs.php" class="btn btn-outline-dark"><i class="fa-solid fa-caret-left"></i></a>
                </div>
                <div class="col">
                    <h1 class="mb-0">Jobs : <?=$JobData['job']['title'];?></h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th>ชื่อผู้สมัคร</th>
                                <th>อีเมล</th>
                                <th class="fit">เบอร์โทรศัพท์</th>
                                <th class="fit">LINE ID</th>
                                <th class="px-4 fit">วันที่สมัคร</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "{$API_URL}candidate/list-candidate";
                            $apiRequest = [
                                "jobId" => $id
                            ];
                            
                            $data = connect_api($apiUrl, $apiRequest);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['candidates'] as $candidate) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$i;?></th>
                                <td><?=$candidate['name'];?></td>
                                <td><a href="mailto:<?=$candidate['email'];?>"><?=$candidate['email'];?></a></td>
                                <td class="fit"><a href="tel:<?=$candidate['phone'];?>"><?=$candidate['phone'];?></a></td>
                                <td class="fit"><a href="http://line.me/ti/p/~<?=$candidate['line'];?>"><?=$candidate['line'];?></a></td>
                                <td class="text-center"><?=date("d M Y", strtotime($candidate['added']));?></td>
                                <td class="fit">
                                    <a href="../candidates/<?=$candidate['resume'];?>" class="btn btn-primary" download="resume-<?=$candidate['resume'];?>"><i class="fa-solid fa-file"></i></a>
                                    <!-- <button type="button" class="btn btn-danger btn-remove" data-id="<?=$candidate['id'];?>"><i class="fa-solid fa-trash"></i></button> -->
                                </td>
                            </tr>

                        <?php
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

    <?php require_once "./js.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            const JobhModal = document.getElementById('JobhModal')
            if (JobhModal) {
                JobhModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const title = button.getAttribute('data-bs-title')
                    const description = button.getAttribute('data-bs-description')
                    const salary = button.getAttribute('data-bs-salary')
                    const workingHour = button.getAttribute('data-bs-working-hour')
                    // const workingDay = button.getAttribute('data-bs-working-day')
                    const location = button.getAttribute('data-bs-location')

                    // Update the modal's content.
                    const modalTitle = JobhModal.querySelector('.modal-title')
                    const modalBodyInputID = JobhModal.querySelector('#EditModalInputID')
                    const modalBodyInputTitle = JobhModal.querySelector('#title')
                    const modalBodyInputDescription = JobhModal.querySelector('#description')
                    const modalBodyInputSalary = JobhModal.querySelector('#salary')
                    const modalBodyInputWorkingHour = JobhModal.querySelector('#workingHour')
                    // const modalBodyInputWorkingDay = JobhModal.querySelector('#workingDay')
                    const modalBodyInputLocation = JobhModal.querySelector('#location')
                    
                    console.log(location)

                    if (id == 0) {
                        modalTitle.textContent = `เพิ่มตำแหน่งงาน`
                        modalBodyInputID.value = 0
                        modalBodyInputTitle.value = ""
                        modalBodyInputDescription.value = ""
                        modalBodyInputDescription.textContent = ""
                        modalBodyInputSalary.value = ""
                        modalBodyInputWorkingHour.value = ""
                        // modalBodyInputWorkingDay.value = ""
                        modalBodyInputLocation.value = ""
                    } else {
                        modalTitle.textContent = `แก้ไขข้อมูลตำแหน่งงาน ${title}`
                        modalBodyInputID.value = id
                        modalBodyInputTitle.value = title
                        modalBodyInputDescription.value = description
                        modalBodyInputDescription.textContent = description
                        modalBodyInputSalary.value = salary
                        modalBodyInputWorkingHour.value = workingHour
                        // modalBodyInputWorkingDay.value = workingDay
                        modalBodyInputLocation.value = location
                    }
                })
            }

            $('#JobhModalForm').submit(function () {
                const InputID = $("#EditModalInputID").val();
                const url = (InputID == 0) ? '<?=$API_URL;?>job/insert-job' : '<?=$API_URL;?>job/update-job';

                var unindexed_array = $('#JobhModalForm').serializeArray();
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
                    url: url,
                    type: 'POST',
                    data: JSON.stringify(indexed_array),
                    contentType: "application/json", 
                    success: function(response) {
                        Swal.close();

                        if (response.responseCode == "000") {
                            Swal.fire(
                                'บันทึกข้อมูลสำเร็จ!',
                                '',
                                'success'
                            ).then(function() {
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

            $(".btn-remove").on("click", function() {
                const id = $(this).data("id");

                var data = {
                    id: id,
                };

                Swal.fire({
                    title: 'ต้องการลบข้อมูลนี้ใช่ไหม?',
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
                            url: "<?=$API_URL;?>job/delete-job",
                            type: "POST",
                            data: JSON.stringify(data),
                            contentType: "application/json; charset=utf-8",
                            dataType: "JSON",
                            success: function(result) {
                                Swal.close();

                                if(result.responseCode == '000') {
                                    Swal.fire(
                                        'ลบข้อมูลเรียบร้อย!',
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

                                    console.log(result)
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    }
                });
            });
        }, false);
    </script>

</body>

</html>