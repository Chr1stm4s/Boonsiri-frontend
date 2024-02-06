<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "jobs";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Translate</h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#JobhModal" data-bs-id="0">เพิ่มตำแหน่งงาน</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th>รายละเอียดงาน</th>
                                <th>เงินเดือน</th>
                                <th class="px-4 fit">วันที่ประกาศ</th>
                                <th class="px-4 fit">ปรับปรุงล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "https://www.ecmapi.boonsiri.co.th/api/v1/translate/list-translate";
                            
                            $data = connect_api($apiUrl);

                            if ($data['responseCode'] == 000) {
                                foreach ($data['translations'] as $translate) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$translate['id'];?></th>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=strip_tags($translate['ContentEn']);?>"><?=strip_tags($translate['ContentEn']);?></p></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=strip_tags($translate['ContentTh']);?>"><?=strip_tags($translate['ContentTh']);?></p></td>
                                <td class="text-center"><?=date("d M Y", strtotime($translate['Added']));?></td>
                                <td class="text-center"><?=time_ago("th", $translate['Updates']);?></td>
                                <td class="fit">
                                    <button type="button" class="btn btn-danger btn-remove" data-id="<?=$translate['id'];?>"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>

                        <?php
                                }
                            }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <form action="#" method="POST" enctype="multipart/form-data" id="JobhModalForm">
        <div class="modal fade" id="JobhModal" tabindex="-1" aria-labelledby="JobhModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="JobhModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="EditModalInputID">
                        <div class="mb-3">
                            <label for="title" class="form-label">ชื่อตำแหน่ง</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="ชื่อตำแหน่ง" required aria-required="true">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">รายละเอียดงาน</label>
                            <textarea name="description" id="description" class="form-control" placeholder="รายละเอียดงาน" required aria-required="true"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="salary" class="form-label">เงินเดือน</label>
                                <input type="number" class="form-control" name="salary" id="salary" placeholder="15000" required aria-required="true">
                            </div>
                            <div class="col">
                                <label for="location" class="form-label">สถานที่ปฏิบัติงาน</label>
                                <input type="text" class="form-control" name="location" id="location" placeholder="สำนักงานใหญ่" required aria-required="true">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="workingHour" class="form-label">จำนวนอัตราจ้าง</label>
                                <input type="text" class="form-control" name="workingHour" id="workingHour" placeholder="จำนวนอัตราจ้าง" required aria-required="true">
                            </div>
                            <!-- <div class="col">
                                <label for="title" class="form-label">วันเข้างาน</label>
                                <input type="text" class="form-control" name="workingDay" id="workingDay" placeholder="จันทร์ - ศุกร์" required aria-required="true">
                            </div> -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" id="JobhModalSubmitButton">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

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
                    const workingDay = button.getAttribute('data-bs-working-day')
                    const location = button.getAttribute('data-bs-location')

                    // Update the modal's content.
                    const modalTitle = JobhModal.querySelector('.modal-title')
                    const modalBodyInputID = JobhModal.querySelector('#EditModalInputID')
                    const modalBodyInputTitle = JobhModal.querySelector('#title')
                    const modalBodyInputDescription = JobhModal.querySelector('#description')
                    const modalBodyInputSalary = JobhModal.querySelector('#salary')
                    const modalBodyInputWorkingHour = JobhModal.querySelector('#workingHour')
                    const modalBodyInputWorkingDay = JobhModal.querySelector('#workingDay')
                    const modalBodyInputLocation = JobhModal.querySelector('#location')

                    if (id == 0) {
                        modalTitle.textContent = `เพิ่มตำแหน่งงาน`
                        modalBodyInputID.value = 0
                        modalBodyInputTitle.value = ""
                        modalBodyInputDescription.value = ""
                        modalBodyInputDescription.textContent = ""
                        modalBodyInputSalary.value = ""
                        modalBodyInputWorkingHour.value = ""
                        modalBodyInputWorkingDay.value = ""
                        modalBodyInputLocation.value = ""
                    } else {
                        modalTitle.textContent = `แก้ไขข้อมูลตำแหน่งงาน ${title}`
                        modalBodyInputID.value = id
                        modalBodyInputTitle.value = title
                        modalBodyInputDescription.value = description
                        modalBodyInputDescription.textContent = description
                        modalBodyInputSalary.value = salary
                        modalBodyInputWorkingHour.value = workingHour
                        modalBodyInputWorkingDay.value = workingDay
                        modalBodyInputLocation.value = location
                    }
                })
            }

            $('#JobhModalForm').submit(function () {
                const InputID = $("#EditModalInputID").val();
                const url = (InputID == 0) ? 'https://www.ecmapi.boonsiri.co.th/api/v1/job/insert-job' : 'https://www.ecmapi.boonsiri.co.th/api/v1/job/update-job';

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
        }, false);
    </script>

</body>

</html>