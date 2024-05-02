<?php
    if (isset($_SESSION['id'])) {
?>

<!-- Address profile Modal -->
<div class="modal fade" id="SelectAddressProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="SelectAddressProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="SelectAddressProfileModalLabel">เลือกที่อยู่จัดส่งสำหรับซื้อสินค้า</h1>

                <?php
                    if (@$_SESSION['address_id']) {
                ?>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <?php
                    }
                ?>

            </div>
            <div class="modal-body">

            <?php
                $ListAddressAPIRequest = [
                    'customerId' => $_SESSION['id'],
                ];

                $ListAddressResponse = connect_api("https://ecmapi.boonsiri.co.th/api/v1/address/list-address-profile", $ListAddressAPIRequest);

                if ($ListAddressResponse['responseCode'] == 000) {
                    foreach ($ListAddressResponse['addressProfile'] as $AddressData) {
            ?>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="address_profile_id" value="<?=$AddressData['id'];?>" id="address_profile_id_<?=$AddressData['id'];?>" <?php if( $AddressData['isMain'] == 1) { echo 'checked aria-checked="true"'; } ?>>
                    <label class="form-check-label text-overflow btn-tooltip" for="address_profile_id_<?=$AddressData['id'];?>" title="<?=$AddressData['fname'];?>&nbsp;<?=$AddressData['lname'];?>&nbsp;<?=$AddressData['addressMain'];?>&nbsp;<?=$AddressData['addressSub'];?>&nbsp;<?=$AddressData['districtName'];?>&nbsp;<?=$AddressData['amphurName'];?>&nbsp;<?=$AddressData['provinceName'];?>&nbsp;<?=$AddressData['postcode'];?>">
                        <?=$AddressData['name'];?>
                        &nbsp;
                        <?=$AddressData['amphurName'];?>
                        &nbsp;
                        <?=$AddressData['provinceName'];?>
                        &nbsp;
                        <?=$AddressData['phone'];?>
                        &nbsp;
                    </label>
                    <!-- <i class="fa-solid fa-circle-info btn p-0 btn-tooltip d-inline" title="<?=$AddressData['fname'];?>&nbsp;<?=$AddressData['lname'];?>&nbsp;<?=$AddressData['addressMain'];?>&nbsp;<?=$AddressData['addressSub'];?>&nbsp;<?=$AddressData['districtName'];?>&nbsp;<?=$AddressData['amphurName'];?>&nbsp;<?=$AddressData['provinceName'];?>&nbsp;<?=$AddressData['postcode'];?>"></i> -->
                </div>

            <?php
                    }
                } else {
            ?>

                <div class="row">
                    <div class="col text-center">
                        <p class="mb-0">ยังไม่มีที่อยู่จัดส่ง</p>
                    </div>
                </div>             

            <?php
                }
            ?>

                <div class="row">
                    <div class="col">
                        <a href="<?=rootURL();?>ที่อยู่จัดส่ง/" class="text-decoration-none"><i class="fa-solid fa-circle-plus"></i> เพิ่มที่อยู่จัดส่ง</a>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            <?php
                if (@$_SESSION['address_id']) {
            ?>

                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">ปิดหน้าต่าง</button>

            <?php
                }
            ?>

            <?php
                if ($ListAddressResponse['responseCode'] == 000) {
            ?>

                <button type="button" class="btn btn-dark" id="SetDefaultAddressButton"><i class="fa-solid fa-house-circle-check"></i> ตั้งค่าเป็นที่อยู่จัดส่ง</button>

            <?php
                } else {
            ?>

                <a href="<?=rootURL();?>ที่อยู่จัดส่ง/" class="btn btn-theme-1">เพิ่มที่อยู่จัดส่ง</a>

            <?php
                }
            ?>

            </div>
        </div>
    </div>
</div>

<?php
        if ((@$_SESSION['address_id'] == 0) && $page != "member-address") {
?>

<!--Modal JS Script -->
<script type="text/javascript">
    window.onload = () => {
        $('#SelectAddressProfileModal').modal('show');
    }
</script>

<?php
        }
    } else {
?>

<!-- Modal -->
<div class="modal fade" id="ModalMemberRequired" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalMemberRequiredLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="mb-0 modal-title">ลงชื่อเข้าใช้งานเพื่อดูสินค้า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 d-flex">
                <img src="<?=rootURL();?>images/check-member.png" alt="Boonsiri Member" class="logo-login my-auto">
            </div>
            <div class="modal-footer border-0">
                <div class="row w-100">
                    <div class="col">
                        <a href="<?=rootURL();?>สมัครสมาชิก/" class="btn btn-theme-3 w-100">สมัครสมาชิก</a>
                    </div>
                    <div class="col">
                        <a href="<?=rootURL();?>ลงชื่อเข้าใช้งาน/" class="btn btn-primary w-100">ลงชื่อเข้าใช้งาน</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>

<script>
    function urlDecode(urlEncodedString) {
        // Split the string into key-value pairs
        const keyValuePairs = urlEncodedString.split('&');

        const result = {};

        // Loop through each key-value pair
        for (const pair of keyValuePairs) {
            const [key, value] = pair.split('=');

            // URL-decode the key and value
            const decodedKey = decodeURIComponent(key);
            const decodedValue = decodeURIComponent(value);

            result[decodedKey] = decodedValue;
        }

        return result;
    }

    $(document).ready(function(){
        $("#SetDefaultAddressButton").click(function() {
            const address_id = $('input[name="address_profile_id"]:checked').val();

            if (address_id) {
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

                $.post(
                    "<?=rootURL();?>action/set-address/", 
                    {
                        address_id: address_id, 
                    }, 
                    function(result) {
                        if (result == "success") {
                            Swal.fire(
                                'ตั้งค่าที่อยู่จัดส่งสำเร็จ!',
                                '',
                                'success'
                            ).then(() => {
                                Swal.fire({
                                    title: 'กำลังโหลดหน้าใหม่...',
                                    showDenyButton: false,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
                                
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'ตั้งค่าที่อยู่จัดส่งไม่สำเร็จ!',
                                '',
                                'error'
                            );

                            console.log(result)
                        }
                    }
                );
            } else {
                Swal.fire(
                    'กรุณาเลือกที่อยู่จัดส่ง!',
                    '',
                    'info'
                );
            }
        });
    });
</script>