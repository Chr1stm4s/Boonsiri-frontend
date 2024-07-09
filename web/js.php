<?php
    if (!@$_SESSION['pdpa']) {
?>

<div class="pdpa py-2 bg-theme-1 shadow">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md my-2 my-md-auto text-center text-md-start">
                <p class="mb-0 text-white">เว็บไซต์นี้มีการใช้งานคุกกี้เพื่อเพิ่มประสิทธิภาพและประสบการณ์ที่ดีในการใช้งานเว็บไซต์ของท่าน</p>
            </div>
            <div class="col col-md-auto pe-0 ps-md-0">
                <a href="<?=rootURL();?>นโยบายคุ้มครองข้อมูลส่วนบุคคล/" class="btn btn-warning w-100">นโยบายคุ้มครองข้อมูลส่วนบุคคล</a>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" onclick="AcceptPDPA();">ยอมรับทั้งหมด</button>
            </div>
        </div>
    </div>
</div>

<?php
    }
?>

<script src="<?=rootURL();?>bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="<?=rootURL();?>sweetalert2.all.min.js"></script>
<script src="<?=rootURL();?>select2/js/select2.min.js"></script>

<?php require_once "modal-member.php"; ?>
<?php require_once "cta-widget.php"; ?>

<script>
    document.addEventListener('contextmenu', event => {
        if (event.target.tagName === 'IMG') {
            event.preventDefault();
        }
    });

    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('dragstart', event => event.preventDefault());
    });

    function AcceptPDPA() {
        $.ajax({
            url: "<?=rootURL();?>action/accept-pdpa/", 
            contentType: "application/json",
            success: function (response) {
                if (response == "success") {
                    $(".pdpa").remove();
                }
            }
        });
    }

    $(document).on("click", ".btn-hyper-link", function() {
        Swal.fire({
            title: 'กำลังดำเนินการ',
            text: 'กรุณารอสักครู่', 
            allowOutsideClick: true,
            allowEscapeKey: true,
            didOpen: () => {
                Swal.showLoading()
            }
        });
    });

    function CheckBrowser() {
        const UserAgent = navigator.userAgent;
        
        if (UserAgent.indexOf("Line") > 0) {

            let url = window.location.href;
            if (url.indexOf("openExternalBrowser") < 0) {
                url += "?openExternalBrowser=1"
                window.location.href = url;
            }
        }
    }

    CheckBrowser();

    const tooltipTriggerList = document.querySelectorAll('.btn-tooltip')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    const AddressSelection = document.getElementById('province');
    
    if (AddressSelection) {
        $('#province').select2().on('select2:select', function (e) {
            $('#amphur').prop('disabled', false);
            $('#district').prop('disabled', true);
            $('#postcode').prop('disabled', true);
        }).on('change', function (e) {
            const provinceValue = $(this).val();
            const province = {
                "provinceId": provinceValue
            };

            Swal.showLoading();

            $.ajax({
                url: '<?=$API_URL;?>address/amphur',
                type: 'POST',
                data: JSON.stringify(province),
                contentType: "application/json",
                success: function (response) {
                    Swal.close();

                    const amphursArray = response.amphurs;
                    const SelectAmphur = document.getElementById("amphur");
                    const SelectDistrict = document.getElementById("district");
                    const postcodeInput = document.getElementById("postcode");

                    SelectAmphur.value = 0;
                    SelectDistrict.value = 0;
                    postcodeInput.value = "";

                    $('#amphur').select2();

                    if (response.hasOwnProperty('amphurs')) {
                        const amphursArray = response.amphurs;

                        while (SelectAmphur.options.length > 1) {
                            SelectAmphur.remove(1);
                        }

                        amphursArray.forEach(amphur => {
                            const amphurId = amphur.amphurId;
                            const amphurName = amphur.amphurName;

                            // Create a new <option> element
                            const OptionAmphur = document.createElement("option");
                            OptionAmphur.value = amphurId;
                            OptionAmphur.textContent = amphurName.trim(); // Remove extra spaces

                            // Append the <option> element to the <select>
                            SelectAmphur.appendChild(OptionAmphur);
                        });

                        // Add event listener to update the postcode input
                        $('#amphur').select2().on('select2:select', function (e) {
                            $('#district').prop('disabled', false);
                        }).on('change', function (e) {
                            Swal.showLoading();

                            const selectedAmphurId = parseInt(SelectAmphur.value);
                            const selectedAmphur = amphursArray.find(amphur => amphur.amphurId === selectedAmphurId);
                            const amphur = {
                                "provinceID": provinceValue,
                                "amphurID": $(this).val()
                            }

                            if (selectedAmphur) {
                                postcodeInput.value = selectedAmphur.postcode;
                                SelectDistrict.disabled = false;
                                postcodeInput.disabled = false;
                                $('#district').select2();

                                $.ajax({
                                    url: '<?=$API_URL;?>address/district',
                                    type: 'POST',
                                    data: JSON.stringify(amphur),
                                    contentType: "application/json",
                                    success: function (response) {
                                        Swal.close();

                                        const districtArray = response.district;

                                        if (response.hasOwnProperty('districts')) {
                                            const districtArray = response.districts;

                                            while (SelectDistrict.options.length > 1) {
                                                SelectDistrict.remove(1);
                                            }

                                            districtArray.forEach(district => {
                                                const districtId = district.districtId;
                                                const districtName = district.districtName;

                                                // Create a new <option> element
                                                const OptionDistrict = document.createElement("option");
                                                OptionDistrict.value = districtId;
                                                OptionDistrict.textContent = districtName.trim(); // Remove extra spaces

                                                // Append the <option> element to the <select>
                                                SelectDistrict.appendChild(OptionDistrict);
                                            });
                                        } else {
                                            console.log("No 'district' array found in the JSON data.");
                                        }
                                    },
                                    error: function (error) {
                                        console.error('Error:', error);
                                    }
                                });
                            } else {
                                postcodeInput.value = 0;
                            }
                        });
                    } else {
                        console.log("No 'amphurs' array found in the JSON data.");
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#amphur').select2()
        $('#district').select2()
    }

    $("#ContactForm").on("submit", function(e) {
        e.preventDefault();

        var unindexed_array = $(this).serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        $.ajax({
            url: '<?=$API_URL;?>contact/insert-Contact',
            type: 'POST',
            data: JSON.stringify(indexed_array),
            contentType: "application/json", 
            success: function(response) {
                Swal.close();

                if (response.responseCode === "000") {
                    Swal.fire(
                        'ขอบคุณสำหรับการติดต่อ!', 
                        'ทีมงานจะติดต่อกลับโดยเร็วที่สุด', 
                        'success'
                    ).then(
                        () => {
                            location.reload();
                        }
                    );
                } else {
                    Swal.fire(
                        'ขออภัย ส่งข้อความไม่สำเร็จ!', 
                        'กรุณาติดต่อเจ้าหน้าที่', 
                        'error'
                    );
                }
            }
        });
    });

    $(document).on("click", ".product-link", function() {
        const url = $(this).data("url");

        Swal.fire({
            title: 'กำลังดำเนินการ',
            text: 'กรุณารอสักครู่', 
            allowOutsideClick: true,
            allowEscapeKey: true,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.post(
            "<?=rootURL();?>action/check-login/", 
            function(result) {
                if (result == "success") {
                    window.location.href = url;
                } else {
                    Swal.close();
                    
                    const ModalMemberRequired = new bootstrap.Modal('#ModalMemberRequired', {
                        keyboard: false
                    });

                    ModalMemberRequired.show();
                }
            }
        );
    });
</script>