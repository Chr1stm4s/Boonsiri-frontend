<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "customers";

        require_once "./head.php";
    ?>

</head>

<body>
    
    <?php require_once "./header.php"; ?>

    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col">
                    <h1 class="mb-0">Customer</h1>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary"data-bs-toggle="modal" data-bs-target="#CustomerModal" data-bs-id="0">เพิ่มบัญชีสมาชิก</button>
                </div>
            </div>
            
            <div class="row">
                <div class="col">
                    <table class="table table-hover border table-striped mb-3" id="DataTables">
                        <thead>
                            <tr>
                                <th class="fit">รหัสลูกค้า</th>
                                <th>ชื่อ</th>
                                <th>อีเมล</th>
                                <th class="fit">เบอร์โทรศัพท์</th>
                                <th class="fit">วันที่สมัคร</th>
                                <th class="px-4 fit">ลงชื่อเข้าใช้ล่าสุด</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $apiUrl = "https://ecmapi.boonsiri.co.th/api/v1/customer/list-customer";
                            
                            $data = connect_api($apiUrl);

                            $i = 1;

                            if ($data['responseCode'] == 000) {
                                foreach ($data['customers'] as $customers) {
                        ?>

                            <tr>
                                <th class="text-end"><?=$i;?></th>
                                <td><p class="mb-0 text-overflow btn-tooltip" data-bs-title="<?=$customers['fname'];?> <?=$customers['lname'];?>"><?=$customers['fname'];?> <?=$customers['lname'];?></p></td>
                                <td class="fit"><a href="mailto:<?=$customers['email'];?>"><?=$customers['email'];?></a></td>
                                <td class="fit"><a href="tel:<?=$customers['phone'];?>"><?=$customers['phone'];?></a></td>
                                <td class="text-center fit"><?=date("d M Y", strtotime($customers['added']));?></td>
                                <td class="text-center"><?=($customers['lastLogin']) ? time_ago("th", $customers['lastLogin']) : '<span class="badge bg-secondary">ยังไม่เคยเข้าใช้งาน</span>';?></td>
                                <td class="fit">
                                    <button 
                                        type="button" 
                                        class="btn btn-warning btn-tooltip" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#CustomerModal" 
                                        data-bs-title="แก้ไขข้อมูลสมาชิก" 
                                        data-bs-id="<?=$customers['id'];?>" 
                                        data-bs-fname="<?=$customers['fname'];?>" 
                                        data-bs-lname="<?=$customers['lname'];?>" 
                                        data-bs-email="<?=$customers['email'];?>" 
                                        data-bs-phone="<?=$customers['phone'];?>" 
                                        data-bs-line="<?=$customers['line'];?>" 
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-tooltip btn-purchase" data-id="<?=$customers['id'];?>"  data-bs-title="ดูสินค้าที่สั่งซื้อ"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-info btn-tooltip dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-title="ดูสินค้าที่อยู่ในตะกร้า">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                        <ul class="dropdown-menu">

                                        <?php
                                            $GetBranch = connect_api("https://ecmapi.boonsiri.co.th/api/v1/branch/master/list-branch");

                                            foreach ($GetBranch['branches'] as $value) {
                                        ?>

                                            <li><a class="dropdown-item" href="./customer-cart.php?id=<?=$customers['id'];?>&whsCode=<?=$value['whsCode'];?>"><?=$value['title'];?></a></li>

                                        <?php
                                            }
                                        ?>
                                        
                                        </ul>
                                    </div>
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

    <form action="#" method="POST" id="CustomerModalForm">
        <div class="modal fade" id="CustomerModal" tabindex="-1" aria-labelledby="CustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="CustomerModalLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="EditModalInputID">
                        <div class="row">
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="fname" id="fname" placeholder="ชื่อ">
                                    <label for="fname">ชื่อ</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="lname" id="lname" placeholder="นามสกุล">
                                    <label for="lname">นามสกุล</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="line" id="line" placeholder="LINE ID">
                                    <label for="line">LINE ID</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="เบอร์โทรศัพท์">
                                    <label for="phone">เบอร์โทรศัพท์</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน">
                                    <label for="password">รหัสผ่าน</label>
                                </div>
                            </div>
                            <div class="col-6 my-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="ยืนยันรหัสผ่าน">
                                    <label for="cpassword">ยืนยันรหัสผ่าน</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php require_once "./js.php"; ?>

    <script>
        $(".btn-purchase").on("click", function() {
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

            const id = $(this).data("id");
            
            window.location.replace(`./customer-purchase.php?id=${id}`);
        });

        document.addEventListener('DOMContentLoaded', function() {
            let table = new DataTable('#DataTables');

            const CustomerModal = document.getElementById('CustomerModal')
            if (CustomerModal) {
                CustomerModal.addEventListener('show.bs.modal', event => {
                    // Button that triggered the modal
                    const button = event.relatedTarget
                    // Extract info from data-bs-* attributes
                    const id = button.getAttribute('data-bs-id')
                    const fname = button.getAttribute('data-bs-fname')
                    const lname = button.getAttribute('data-bs-lname')
                    const email = button.getAttribute('data-bs-email')
                    const phone = button.getAttribute('data-bs-phone')
                    const line = button.getAttribute('data-bs-line')

                    // Update the modal's content.
                    const modalTitle = CustomerModal.querySelector('.modal-title')
                    const modalBodyInputID = CustomerModal.querySelector('#EditModalInputID')
                    const modalBodyInputFname = CustomerModal.querySelector('#fname')
                    const modalBodyInputLname = CustomerModal.querySelector('#lname')
                    const modalBodyInputEmail = CustomerModal.querySelector('#email')
                    const modalBodyInputPhone = CustomerModal.querySelector('#phone')
                    const modalBodyInputLine = CustomerModal.querySelector('#line')

                    if (id == 0) {
                        modalTitle.textContent = `เพิ่มบัญชีผู้ใช้งาน`
                        modalBodyInputID.value = 0
                        modalBodyInputFname.value = ""
                        modalBodyInputLname.value = ""
                        modalBodyInputEmail.value = ""
                        modalBodyInputPhone.value = ""
                        modalBodyInputLine.value = ""
                    } else {
                        modalTitle.textContent = `แก้ไขข้อมูลบัญชีผู้ใช้งาน ${fname} ${lname}`
                        modalBodyInputID.value = id
                        modalBodyInputFname.value = fname
                        modalBodyInputLname.value = lname
                        modalBodyInputEmail.value = email
                        modalBodyInputPhone.value = phone
                        modalBodyInputLine.value = line
                    }
                });
            }

            $('#CustomerModalForm').on("submit", function () {
                var unindexed_array = $(this).serializeArray();
                var indexed_array = {};

                $.map(unindexed_array, function(n, i){
                    indexed_array[n['name']] = n['value'];
                });

                const InputID = $("#EditModalInputID").val();
                const url = (InputID == 0) ? 'https://ecmapi.boonsiri.co.th/api/v1/customer/add-customer' : 'https://ecmapi.boonsiri.co.th/api/v1/customer/edit-customer';

                Swal.fire({
                    title: 'กำลังดำเนินการ...',
                    showDenyButton: false,
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();

                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: JSON.stringify(indexed_array),
                            contentType: "application/json", 
                            success: function(response) {
                                if (response.responseCode == "000") {
                                    location.reload();
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
                    }
                });
            });
        }, false);
    </script>

</body>

</html>