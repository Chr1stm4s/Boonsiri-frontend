<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "contact";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container-fluid">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Contact</h1>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">ลำดับ</th>
                                <th class="fit">ชื่อ</th>
                                <th class="fit">อีเมล</th>
                                <th class="fit">เบอร์โทรศัพท์</th>
                                <th class="fit">LINE ID</th>
                                <th>ข้อความ</th>
                                <th class="fit">ส่งเมื่อ</th>
                                <th class="fit">สถานะ</th>
                                <th class="fit">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "{$API_Link}api/v1/contact/list-contact";
                            
                            $data = connect_api($apiUrl);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['contactCategories'] as $contact) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$i;?></th>
                                <td class="fit"><?=$contact['name'];?></td>
                                <td class="fit"><a href="mailto:<?=$contact['email'];?>"><?=$contact['email'];?></a></td>
                                <td class="fit"><a href="tel:<?=$contact['phone'];?>"><?=$contact['phone'];?></a></td>
                                <td class="fit"><a href="http://line.me/ti/p/~<?=$contact['line'];?>"><?=$contact['line'];?></a></td>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=($contact['message']) ? $contact['message'] : "-";?>"><?=$contact['message'];?></p></td>
                                <td class="fit text-center"><?=time_ago("th", $contact['added']);?></td>
                                <td class="fit"> <?=($contact['marked']) ? '<span class="badge text-bg-primary w-100">อ่านแล้ว</span>' : '<span class="badge text-bg-light w-100">ยังไม่ได้อ่าน</span>'; ?> </td>
                                <td class="text-center">
                                    <button 
                                        type="button" 
                                        class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#ContactModal" 
                                        data-bs-id="<?=$contact['id'];?>" 
                                        data-bs-name="<?=$contact['name'];?>" 
                                        data-bs-email="<?=$contact['email'];?>" 
                                        data-bs-phone="<?=$contact['phone'];?>" 
                                        data-bs-line="<?=$contact['line'];?>" 
                                        data-bs-topic="<?=$contact['topic'];?>" 
                                        data-bs-message="<?=$contact['message'];?>" 
                                        data-bs-time-start="<?=$contact['timeStart'];?>" 
                                        data-bs-time-end="<?=$contact['timeEnd'];?>" 
                                    >
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
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

    <div class="modal fade" id="CustomerModal" tabindex="-1" aria-labelledby="CustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CustomerModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data" id="CustomerModalForm">
                        <input type="hidden" name="id" id="EditModalInputID">
                        <div class="mb-3">
                            <label for="title" class="form-label">ชื่อตำแหน่ง</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="ชื่อตำแหน่ง">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">รายละเอียดงาน</label>
                            <textarea name="description" id="description" class="form-control" placeholder="รายละเอียดงาน"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="workingHour" class="form-label">ช่วงเวลาทำงาน</label>
                                <input type="text" class="form-control" name="workingHour" id="workingHour" placeholder="09:00 - 18:00">
                            </div>
                            <div class="col">
                                <label for="title" class="form-label">วันเข้างาน</label>
                                <input type="text" class="form-control" name="workingDay" id="workingDay" placeholder="จันทร์ - ศุกร์">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="salary" class="form-label">เงินเดือน</label>
                                <input type="number" class="form-control" name="salary" id="salary" placeholder="15000">
                            </div>
                            <div class="col">
                                <label for="location" class="form-label">สถานที่ปฏิบัติงาน</label>
                                <input type="text" class="form-control" name="location" id="location" placeholder="สำนักงานใหญ่">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" id="CustomerModalSubmitButton">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ContactModal" tabindex="-1" aria-labelledby="ContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ContactModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless table-hover">
                        <input type="hidden" name="id" id="id">
                        <tbody>
                            <tr>
                                <th class="text-end">ชื่อผู้ติดต่อ:</th>
                                <td id="ContactName" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">อีเมล:</th>
                                <td id="ContactEmail" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">เบอร์โทรศัพท์:</th>
                                <td id="ContactPhone" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">LINE ID:</th>
                                <td id="ContactLINE" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">หัวเรื่อง:</th>
                                <td id="ContactTopic" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">ข้อความ:</th>
                                <td id="ContactMessage" colspan="3"></td>
                            </tr>
                            <tr>
                                <th class="text-end">ช่วงเวลาที่สะดวกติดต่อกลับ:</th>
                                <td class="fit" id="timeStart"></td>
                                <td class="fit px-0">ถึง</td>
                                <td id="timeEnd"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-primary" id="ContactMark">ทำเครื่องหมายอ่านแล้ว</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once "./js.php"; ?>

    <script>
        $(document).ready(function() {
            $('#DataTables').DataTable({
                columnDefs: [
                    { 
                        orderable: false, 
                        targets: -1 
                    }
                ],
                order: [
                    [
                        0, 'DESC'
                    ]
                ]
            });
        });

        $("#ContactMark").click(function() {
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

            const ConfirmData = {
                "id": $("#id").val(), 
                "marked": 1
            };

            const headers = {
                'Content-Type': 'application/json'
            };

            const requestOptions = {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(ConfirmData)
            };

            fetch("{$API_Link}api/v1/contact/update-Contact", requestOptions)
            .then(response => response.json())
            .then(
                obj => {
                    if (obj.responseCode === "000") {
                        Swal.fire(
                            `ทำเครื่องหมายแล้ว!`,
                            ``,
                            'success'
                        ).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            `ทำเครื่องหมายไม่สำเร็จ!`,
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
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

        const ContactModal = document.getElementById('ContactModal')
        if (ContactModal) {
            ContactModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const id = button.getAttribute('data-bs-id')
                const name = button.getAttribute('data-bs-name')
                const email = button.getAttribute('data-bs-email')
                const phone = button.getAttribute('data-bs-phone')
                const line = button.getAttribute('data-bs-line')
                const topic = button.getAttribute('data-bs-topic')
                const message = button.getAttribute('data-bs-message')
                const timeStart = button.getAttribute('data-bs-time-start')
                const timeEnd = button.getAttribute('data-bs-time-end')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const modalTitle = ContactModal.querySelector('.modal-title')
                const modalBodyInputID = ContactModal.querySelector('#id')
                const modalBodyInputName = ContactModal.querySelector('#ContactName')
                const modalBodyInputEmail = ContactModal.querySelector('#ContactEmail')
                const modalBodyInputPhone = ContactModal.querySelector('#ContactPhone')
                const modalBodyInputLINE = ContactModal.querySelector('#ContactLINE')
                const modalBodyInputTopic = ContactModal.querySelector('#ContactTopic')
                const modalBodyInputMessage = ContactModal.querySelector('#ContactMessage')
                const modalBodyInputTimeStart = ContactModal.querySelector('#timeStart')
                const modalBodyInputTimeEnd = ContactModal.querySelector('#timeEnd')

                modalTitle.textContent = `หัวเรื่อง: ${topic}`
                modalBodyInputID.value = id
                modalBodyInputName.textContent = (name) ? name : "ไม่มีข้อมูล"
                modalBodyInputEmail.textContent = (email) ? email : "ไม่มีข้อมูล"
                modalBodyInputPhone.textContent = (phone) ? phone : "ไม่มีข้อมูล"
                modalBodyInputLINE.textContent = (line) ? line : "ไม่มีข้อมูล"
                modalBodyInputTopic.textContent = (topic) ? topic : "ไม่มีข้อมูล"
                modalBodyInputMessage.textContent = (message) ? message : "ไม่มีข้อมูล"
                modalBodyInputTimeStart.textContent = (timeStart) ? timeStart : "ไม่มีข้อมูล"
                modalBodyInputTimeEnd.textContent = (timeEnd) ? timeEnd : "ไม่มีข้อมูล"
            })
        }
    </script>

</body>

</html>