<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "order";
        
        require_once "./head.php";

        $id = $_GET['id'];

        $request = [
            'id' => $id
        ];

        $data = connect_api("https://ecmapi.boonsiri.co.th/api/v1/purchase/get-purchase", $request);
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
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>ยืนยันคำสั่งซื้อ/<?=$id;?>/" class="text-theme-1">ข้อมูลคำสั่งซื้อ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ชำระเงิน</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">

        <?php
            if ($data['responseCode'] == 000) {
                if ($data['purchase']['status'] == 1) {
                    $requestQR = [
                        'purchaseId' => $id
                    ];
            
                    $dataQR = connect_api("https://ecmapi.boonsiri.co.th/api/v1/boonsiri/gen-qr-payment", $requestQR);
            
                    if ($dataQR['responseCode'] == 000) {
                        $PaymentData = $dataQR['response']['results'];
        ?>

            <div class="row">
                <div class="col-10 col-md-6 col-lg-3 mx-auto">
                    <a href="data:image/png;base64,<?=$PaymentData['generateQr']['qrImage'];?>" download="boonsiri-payment.png">
                        <img src="data:image/png;base64,<?=$PaymentData['generateQr']['qrImage'];?>" alt="ชำระเงิน" class="w-100">
                    </a>
                </div>
            </div>
            <div class="row my-5">
                <div class="col text-end">
                    <a href="data:image/png;base64,<?=$PaymentData['generateQr']['qrImage'];?>" download="boonsiri-payment.png" class="btn btn-outline-dark rounded-0 h-100">
                        ดาวน์โหลด QR Code <i class="fa-solid fa-download"></i>
                    </a>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-theme-2 rounded-0 px-3 h-100" id="PaymentStep">ยืนยันการชำระเงิน <i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    <h5>ชื่อบัญชี: <?=$PaymentData['bankAccount']['bankName'];?></h5>
                    <!-- <h5>เลขที่บัญชี: <span id="BankNumber"><?=$PaymentData['bankAccount']['bankNumber'];?></span></h5> -->
                    <h5>ยอดชำระ: <?=number_format($PaymentData['resultQr']['amount']);?> บาท</h5>
                    <h5 class="text-danger mb-0">
                        โปรดชำระเงินเพื่อยืนยันคำสั่งซื้อภายใน 10 นาที
                        <br>
                        หากไม่ชำระภายใน 10 นาที คำสั่งซื้อจะถูกยกเลิกอัตโนมัติ
                    </h5>
                </div>
            </div>

        <?php
                    } else {    
        ?>

            <div class="row">
                <div class="col text-center">
                    <h5 class="mb-0">
                        ไม่สามารถสร้าง QR Code เพื่อชำระเงินได้
                        <br>
                        กรุณาติดต่อเจ้าหน้าที่
                        <br>
                        <a href="tel:094-698-5555">094-698-5555</a>
                    </h5>
                </div>
            </div>

        <?php   
                    }
                } else {
        ?>

            <div class="row">
                <div class="col text-center">
                    <h5 class="mb-0">
                        ไม่สามารถชำระเงินได้
                        <br>
                        เนื่องจากเกินระยะเวลาที่กำหนด
                        <br>
                        กรุณาสั่งซื้อใหม่อีกครั้ง
                    </h5>
                    <br>
                    <a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="btn btn-theme-1 px-3 btn-hyper-link">เลือกซื้อสินค้า</a>
                </div>
            </div>

        <?php   
                }
            } else {
        ?>

            <div class="row">
                <div class="col text-center">
                    <h5 class="mb-0">
                        ไม่สามารถชำระเงินได้
                        <br>
                        กรุณาติดต่อเจ้าหน้าที่
                        <br>
                        <a href="tel:094-698-5555">094-698-5555</a>
                    </h5>
                </div>
            </div>

        <?php
            }
        ?>

        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

    <script>
        $(".btn-copy").click(function(){
            var text = $("#BankNumber").text();

            navigator.clipboard.writeText(text).then(function() {
                Swal.fire(
                    'คัดลอกสำเร็จ!',
                    '',
                    'success'
                );
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        });

        $("#PaymentStep").click(function() {
            Swal.fire({
                title: 'กำลังดำเนินการ...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();

                    $.ajax({
                        type: "POST",  
                        url: "<?=rootURL();?>action/check-payment/",
                        data: {
                            id: <?=$id;?>
                        }, 
                        success: function(response) {  
                            if (response == "success") {
                                window.location.replace("<?=rootURL();?>ขอบคุณสำหรับคำสั่งซื้อ/");
                            } else {
                                Swal.fire(
                                    'ดำเนินการไม่สำเร็จ!',
                                    `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>