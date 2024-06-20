<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "cart";
        
        require_once "./head.php";
        
        if ($_SESSION['id']) {
            $UserID = $_SESSION['id'];
        } else {
            redirect(rootURL()."ลงชื่อเข้าใช้งาน/");
        }
        
        $CartDataAPI = [
            'customerId' => $_SESSION['id'],
            'whsCode' => $_SESSION['whsCode']
        ];

        $CartData = connect_api("{$API_URL}cart/list-cart", $CartDataAPI);

        $ShoppingCart = $CartData['cartModels'];
        $CreateOrder = "";

        if ($CartData['totalCart'] != 0) {
            $CreateOrder = "create-order";
        }

        $_SESSION['totalDiscount'] = ($CartData['totalDiscount']) ? $CartData['totalDiscount'] : 0;
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
                            <li class="breadcrumb-item active" aria-current="page">ตะกร้าสินค้า</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 col-md my-auto text-center text-md-start mb-4 mb-md-0">
                    <h1 class="mb-0">รายการสินค้าในตะกร้า</h1>
                </div>
                <div class="col-auto m-auto">
                    <div class="form-check mx-auto">
                        <input class="form-check-input" type="checkbox" value="2" id="shipping_type">
                        <label class="form-check-label" for="shipping_type">รับสินค้าที่ร้าน</label>
                    </div>
                </div>
            </div>
            <div class="row mb-4 d-none d-md-flex">
                <div class="col-6 col-md-auto mx-auto ms-md-auto me-md-0 px-md-0">
                    <a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="btn btn-theme-3 rounded-0 px-3 w-100">เลือกซื้อสินค้าต่อ <i class="fa-solid fa-cart-plus"></i></a>
                </div>
                <div class="col-6 col-md-auto mx-auto mx-md-0">
                    <button class="btn btn-theme-2 rounded-0 px-3 w-100 <?=$CreateOrder;?>"><i class="fa-solid fa-spinner fa-pulse create-order-loading"></i> ยืนยันคำสั่งซื้อ <i class="fa-solid fa-caret-right"></i></button>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="card my-2 rounded-1 d-none d-lg-block">
                        <div class="card-body py-2 px-0">
                            <div class="row mx-0">
                                <div class="my-auto col-cart cart-number text-end">
                                    <span>ลำดับ</span>
                                </div>
                                <div class="my-auto col-cart cart-image text-center">
                                    <p class="mb-0">รูปสินค้า</p>
                                </div>
                                <div class="my-auto col-cart cart-title">
                                    <p class="mb-0">ชื่อสินค้า</p>
                                </div>
                                <div class="my-auto col-cart cart-amount text-center">
                                    <p class="mb-0">จำนวน</p>
                                </div>
                                <div class="my-auto col-cart cart-price-each text-end">
                                    <p class="mb-0">ราคาต่อหน่วย</p>
                                </div>
                                <div class="my-auto col-cart cart-price-total text-end">
                                    <p class="mb-0">ราคารวม</p>
                                </div>
                                <div class="my-auto col-cart cart-tool text-center">
                                    <p class="mb-0">เครื่องมือ</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        if ($CartData['responseCode'] == 000) {
                            if ($CartData['totalCart'] == 0) {
                    ?>

                    <div class="card my-2 rounded-1">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">ยังไม่มีสินค้าในตะกร้า</h5>
                        </div>
                    </div>

                    <?php
                            } else {
                                $count = 1;

                                foreach ($ShoppingCart as $cart) {
                                    $thumbnail = (file_exists("products/".$cart['thumbnail'])) ? rootURL()."products/".$cart['thumbnail'] : rootURL()."images/logo.png";
                                    $placeholder = (file_exists("products/".$cart['thumbnail'])) ? "" : "thumbnail-placeholder";
                    ?>

                    <div class="card my-2 rounded-1" id="itemID<?=$cart['id'];?>">
                        <div class="card-body py-2 px-0">
                            <div class="row mx-0">
                                <div class="my-auto col-cart cart-number text-end d-none d-lg-block">
                                    <span><?=$count;?></span>
                                </div>
                                <div class="my-auto col-cart cart-image text-center">
                                    <img src="<?=$thumbnail;?>" alt="<?=$cart['title'];?>" class="product-thumbnail rounded-3" data-bs-toggle="modal" data-bs-target="#PreviewThumbnailModal" data-bs-img="<?=$thumbnail;?>">
                                </div>
                                <div class="my-0 my-md-auto col-cart cart-title">
                                    <p class="mb-0 btn-tooltip" data-bs-title="<?=$cart['title'];?>"><?=$cart['title'];?></p>
                                </div>
                                <div class="col-auto my-auto px-0">
                                    <div class="row mx-0">
                                        <div class="my-3 my-md-auto col-cart cart-amount text-center">
                                            <div class="row mx-0">
                                                <div class="col-auto px-0">
                                                    <button class="btn btn-outline-secondary btn-sm btn-amount-adjust rounded-0" type="button" data-action="decrease" data-item="<?=$cart['id'];?>" data-sequence="<?=$count - 1;?>" data-eprice="EachPrice<?=$cart['id'];?>" data-price="LastPrice<?=$cart['id'];?>" data-before="<?=number_format($cart['price'] * $cart['amount']);?>" data-after="<?=($cart['promotionId'] == 0) ? 0 : number_format($cart['lastPrice']); ?>" data-promotion="<?=($cart['promotionType'] !== null && ($cart['promotionType'] == 0 || $cart['promotionType'] == 1)) ? "yes" : "no"; ?>" data-input="#InputAmount<?=$count;?>" data-product="<?=$cart['productId'];?>">
                                                        <i class="fa-solid fa-minus"></i>
                                                    </button>
                                                </div>
                                                <div class="col px-0">
                                                    <input type="number" class="form-control form-control-sm input-amount-adjust rounded-0 text-end" placeholder="1" id="InputAmount<?=$count;?>" data-sequence="<?=$count - 1;?>" value="<?=$cart['amount'];?>" inputmode="numeric" data-before="<?=number_format($cart['price'] * $cart['amount']);?>" data-after="<?=($cart['promotionId'] == 0) ? 0 : number_format($cart['lastPrice']); ?>" data-promotion="<?=($cart['promotionType'] !== null && ($cart['promotionType'] == 0 || $cart['promotionType'] == 1)) ? "yes" : "no"; ?>" data-eprice="EachPrice<?=$cart['id'];?>" data-price="LastPrice<?=$cart['id'];?>" data-input="#InputAmount<?=$count;?>" data-action="custom" data-item="<?=$cart['id'];?>" data-product="<?=$cart['productId'];?>">
                                                </div>
                                                <div class="col-auto px-0">
                                                    <button class="btn btn-outline-secondary btn-sm btn-amount-adjust rounded-0" type="button" data-action="increase" data-item="<?=$cart['id'];?>" data-sequence="<?=$count - 1;?>" data-eprice="EachPrice<?=$cart['id'];?>" data-price="LastPrice<?=$cart['id'];?>" data-before="<?=number_format($cart['price'] * $cart['amount']);?>" data-after="<?=($cart['promotionId'] == 0) ? 0 : number_format($cart['lastPrice']); ?>" data-promotion="<?=($cart['promotionType'] !== null && ($cart['promotionType'] == 0 || $cart['promotionType'] == 1)) ? "yes" : "no"; ?>" data-input="#InputAmount<?=$count;?>" data-product="<?=$cart['productId'];?>">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            if ($cart['promotionType'] !== null) {
                                                if ($cart['promotionType'] == 3) {
                                        ?>

                                        <div class="my-3 my-md-auto col-cart cart-price-each text-end">
                                            <p class="mb-0 text-theme-4" id="EachPrice<?=$cart['id'];?>">
                                                <small class="text-dark"><?=($cart['uomCode']) ? $cart['uomCode'] : "ชิ้น"; ?>ละ</small>
                                                <?=number_format($cart['price']);?> บาท
                                            </p>
                                        </div>
                                        <div class="my-3 my-md-auto col-cart cart-price-total text-end d-none d-md-flex">
                                            <p class="mb-0 w-100 text-theme-4" id="LastPrice<?=$cart['id'];?>"><?=number_format($cart['lastPrice']);?> บาท</p>
                                        </div>

                                        <?php
                                                } else {
                                        ?>

                                        <div class="my-3 my-md-auto col-cart cart-price-each text-end">
                                            <p class="mb-0 w-100" id="EachPrice<?=$cart['id'];?>">
                                                <small class="text-dark"><?=($cart['uomCode']) ? $cart['uomCode'] : "ชิ้น"; ?>ละ</small>
                                                <small class="text-decoration-line-through text-theme-3 fw-light">
                                                    <?=number_format($cart['price']);?> บาท
                                                </small>
                                                <br class="d-none d-md-block">
                                                <span class="text-danger fw-bold"><?=number_format($cart['eachLastPrice']);?> บาท</span>
                                            </p>
                                        </div>
                                        <div class="my-3 my-md-auto col-cart cart-price-total text-end d-none d-md-flex">
                                            <p class="mb-0 w-100" id="LastPrice<?=$cart['id'];?>">
                                                <small class="text-decoration-line-through text-theme-3 fw-light">
                                                    <?=number_format($cart['price'] * $cart['amount']);?> บาท
                                                </small>
                                                <br class="d-none d-md-block">
                                                <span class="text-danger fw-bold"><?=number_format($cart['lastPrice']);?> บาท</span>
                                            </p>
                                        </div>

                                        <?php
                                                }
                                            } elseif ($cart['stepPrice'] !== $cart['price']) {
                                        ?>

                                        <div class="my-3 my-md-auto col-cart cart-price-each text-end">
                                            <p class="mb-0 w-100" id="EachPrice<?=$cart['id'];?>">
                                                <small class="text-dark"><?=($cart['uomCode']) ? $cart['uomCode'] : "ชิ้น"; ?>ละ</small>
                                                <small class="text-decoration-line-through text-theme-3 fw-light">
                                                    <?=number_format($cart['price']);?> บาท
                                                </small>
                                                <br class="d-none d-md-block">
                                                <span class="text-danger fw-bold"><?=number_format($cart['eachLastPrice']);?> บาท</span>
                                            </p>
                                        </div>
                                        <div class="my-3 my-md-auto col-cart cart-price-total text-end d-none d-md-flex">
                                            <p class="mb-0 w-100" id="LastPrice<?=$cart['id'];?>">
                                                <small class="text-decoration-line-through text-theme-3 fw-light">
                                                    <?=number_format($cart['price'] * $cart['amount']);?> บาท
                                                </small>
                                                <br class="d-none d-md-block">
                                                <span class="text-danger fw-bold"><?=number_format($cart['lastPrice']);?> บาท</span>
                                            </p>
                                        </div>

                                        <?php
                                            } else {
                                        ?>

                                        <div class="my-3 my-md-auto col-cart cart-price-each text-end">
                                            <p class="mb-0 text-theme-4" id="EachPrice<?=$cart['id'];?>">
                                                <small class="text-dark"><?=($cart['uomCode']) ? $cart['uomCode'] : "ชิ้น"; ?>ละ</small>
                                                <?=number_format($cart['price']);?> บาท
                                            </p>
                                        </div>
                                        <div class="my-3 my-md-auto col-cart cart-price-total text-end d-none d-md-flex">
                                            <p class="mb-0 w-100 text-theme-4" id="LastPrice<?=$cart['id'];?>"><?=number_format($cart['lastPrice']);?> บาท</p>
                                        </div>

                                        <?php
                                            }
                                        ?>

                                        <div class="my-auto col-cart cart-tool text-center">
                                            <a href="<?=rootURL();?>ข้อมูลสินค้าบุญศิริ/<?=$cart['productId'];?>/<?=str_replace(" ", "-", $cart['title']);?>/" class="btn btn-dark rounded-0 btn-edit btn-tooltip" data-bs-title="ดูรายละเอียดสินค้า">
                                                <i class="fa-regular fa-eye d-none d-md-block"></i>
                                                <span class="d-block d-md-none">ดูข้อมูลสินค้า</span>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-remove-cart btn-tooltip rounded-0" data-id="<?=$cart['productId'];?>" data-bs-title="ลบสินค้าออกจากตะกร้า">
                                                <i class="fa-solid fa-xmark d-none d-md-block"></i>
                                                <span class="d-block d-md-none">เอาออกจากตะกร้า</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                                    $count++;
                                }
                            }
                        } else {
                    ?>

                    <div class="card my-2 rounded-1">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">ไม่สามารถเรียกดูสินค้าในตะกร้าได้</h5>
                        </div>
                    </div>
                        
                    <?php
                        }
                    ?>
                            
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-cart2 col-md mb-4 mb-md-0">
                    <h5 class="text-danger">*โปรดอ่านก่อนยืนยันคำสั่งซื้อ และชำระค่าสินค้า*</h5>
                    <p class="fw-bold">เงื่อนไขการจัดส่ง</p>
                    <ol>
                        <li>กรณียืนยันคำสั่งซื้อและชำระเงิน ภายใน 8.30 น. สินค้าจะถูกจัดส่งไม่เกิน 1-2 วัน นับจากวันชำระเงิน</li>
                        <li>กรณียืนยันคำสั่งซื้อและชำระเงิน หลังจาก 8.30 น. สินค้าจะถูกจัดส่งไม่เกิน 2-3 วัน นับจากวันชำระเงิน</li>
                    </ol>
                    <small>หลังจากยืนยันคำสั่งซื้อและชำระเงินเรียบร้อย ลูกค้าสามารถติดตามสถานะการจัดส่งได้จาก เมนู <a href="<?=rootURL();?>คำสั่งซื้อ/">"คำสั่งซื้อ"</a> > "สถานะคำสั่งซื้อ"<br>หากต้องการสอบถามเพิ่มเติม ติดต่อ call center : <a href="tel:094-698-5555">094-698-5555</a></small>
                </div>
                <div class="col-cart2 col-md-auto text-end mt-auto">
                    <table class="table table-hover table-borderless">
                        <tbody>
                            <tr>
                                <th class="py-0">ส่วนลดทั้งหมด</th>
                                <td class="py-0 total-discount-text"><?=number_format($CartData['totalDiscount']);?> บาท</td>
                            </tr>
                            <tr class="fs-5">
                                <th class="py-0">ราคาทั้งหมด</th>
                                <td class="py-0 total-price-text"><?=number_format($CartData['lastTotalPrice']);?> บาท</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="PreviewThumbnailModal" tabindex="-1" aria-labelledby="PreviewThumbnailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="" class="w-100" id="PreviewThumbnailModalIMG">
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-menu d-block d-lg-none shadow">
        <div class="row mx-0">
            <div class="col-auto text-center h-100 px-0 bg-theme-3">
                <a href="<?=rootURL();?>หมวดหมู่สินค้าทั้งหมด/" class="btn shoping-bag-icon px-3 py-2 btn-tooltip">
                    <i class="fa-solid fa-cart-plus"></i>
                </a>
            </div>
            <div class="col text-end my-auto d-flex flex-column align-items-end justify-content-center" id="PriceTotalMobileBottom">
                <p class="mb-0">Total: <span class="text-danger total-price-text"><?=number_format($CartData['lastTotalPrice']);?> บาท</span></p>
                <small>ส่วนลดทั้งหมด: <span class="text-danger total-discount-text"><?=number_format($CartData['totalDiscount']);?> บาท</span></small>
            </div>
            <div class="col-auto text-center h-100 px-0 bg-theme-1">
                <button class="btn rounded-0 px-3 py-2 text-white <?=$CreateOrder;?>"><i class="fa-solid fa-spinner fa-pulse create-order-loading"></i> ยืนยันคำสั่งซื้อ <span class="badge bg-danger"><?=$HeaderCartCount;?></span></button>
            </div>
        </div>
    </div>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>
    <?php require_once "./cart-js.php"; ?>

    <script>
        $(".create-order-loading").hide();

        $(".btn-amount-adjust").on("click", function() {
            const action = $(this).data("action");
            const input = $(this).data("input");
            const price = $(this).data("price");
            const eprice = $(this).data("eprice");
            const amount = $(input).val();
            const item = $(this).data("item");
            const product = $(this).data("product");
            const before = $(this).data("before");
            const after = $(this).data("after");
            const promotion = $(this).data("promotion");
            const sequence = $(this).data("sequence");

            AdjustItemAmount(action, input, amount, item, product, eprice, price, before, after, promotion, sequence);
        });
        
        $(".input-amount-adjust").on("change", function() {
            const action = $(this).data("action");
            const input = $(this).data("input");
            const price = $(this).data("price");
            const eprice = $(this).data("eprice");
            const amount = $(this).val();
            const item = $(this).data("item");
            const product = $(this).data("product");
            const before = $(this).data("before");
            const after = $(this).data("after");
            const promotion = $(this).data("promotion");
            const sequence = $(this).data("sequence");

            AdjustItemAmount(action, input, amount, item, product, eprice, price, before, after, promotion, sequence);
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function AdjustItemAmount(action, input, amount, item, product, eprice, price, before, after, promotion, sequence) {
            $(".create-order").prop("disabled", true);
            $(".btn-remove-cart").prop("disabled", true);
            $(".create-order-loading").show();

            if (amount <= 0 ) {
                RemoveCartItem(product);
            } else {
                if (action == "increase") {
                    var newAmount = parseInt(amount) + 1;
                } else if (action == "decrease") {
                    var newAmount = parseInt(amount) - 1;
                } else {
                    var newAmount = parseInt(amount);
                }

                $(input).val(newAmount);

                setTimeout(
                    function() {
                        $.post(
                            '<?=rootURL();?>action/update-cart/', 
                            {
                                "cartId": item,
                                "productId": product,
                                "amount": newAmount
                            }, 
                            function (response) {
                                if (response.responseCode == "000") {
                                    $.post(
                                        '<?=rootURL();?>action/check-cart/', 
                                        function(response, status) {
                                            if (response.responseCode == "000") {
                                                $(".total-discount-text").text(`${numberWithCommas(response.totalDiscount)} บาท`)
                                                $(".total-price-text").text(`${numberWithCommas(response.lastTotalPrice)} บาท`)

                                                $(".create-order").prop("disabled", false);
                                                $(".btn-remove-cart").prop("disabled", false);
                                                $(".create-order-loading").hide();

                                                const stepPrice = (response.cartModels[sequence].stepPrice == response.cartModels[sequence].price) ? false : true;

                                                if (promotion == "no" && stepPrice == false) {
                                                    var newPrice = `${numberWithCommas(response.cartModels[sequence].lastPrice)} บาท`;
                                                    var newEprice = `<small class="text-dark">${(response.cartModels[sequence].uomCode) ? response.cartModels[sequence].uomCode : "ชิ้น"}ละ</small> ${numberWithCommas(response.cartModels[sequence].price)} บาท`;
                                                } else {
                                                    var newPrice = `<small class="text-decoration-line-through text-theme-3"> ${numberWithCommas(response.cartModels[sequence].price * response.cartModels[sequence].amount)} บาท </small> <br class="d-none d-md-block"> <span class="text-danger fw-bold">${numberWithCommas(response.cartModels[sequence].lastPrice)} บาท</span>`;
                                                    var newEprice = `<small class="text-dark">${(response.cartModels[sequence].uomCode) ? response.cartModels[sequence].uomCode : "ชิ้น"}ละ</small> <small class="text-decoration-line-through text-theme-3"> ${numberWithCommas(response.cartModels[sequence].price)} บาท </small> <br class="d-none d-md-block"> <span class="text-danger fw-bold">${numberWithCommas(response.cartModels[sequence].eachLastPrice)} บาท</span>`;
                                                }
                                                
                                                $("#" + price).html(newPrice);
                                                $("#" + eprice).html(newEprice);
                                            } else {
                                                Swal.fire({
                                                    title: 'ไม่สามารถแก้ไขจำนวนสินค้าได้!',
                                                    text: `กรุณาติดต่อเจ้าหน้าที่`,
                                                    html:   `
                                                                <p>กรุณาติดต่อเจ้าหน้าที่</p>
                                                                โทร: <a href="tel:061-559-5555">061-559-5555</a>
                                                                <br>
                                                                LINE ID: <a href="https://line.me/ti/p/%40boonsiri">@boonsiri</a>
                                                            `, 
                                                    icon: 'error'
                                                });

                                                console.log(response);
                                            }
                                        }
                                    );
                                } else if (response.responseCode == "S01") {
                                    Swal.fire({
                                        title: 'สินค้าไม่เพียงพอ!',
                                        text: `กรุณาติดต่อเจ้าหน้าที่`,
                                        html:   `
                                                    <p>กรุณาติดต่อเจ้าหน้าที่</p>
                                                    โทร: <a href="tel:061-559-5555">061-559-5555</a>
                                                    <br>
                                                    LINE ID: <a href="https://line.me/ti/p/%40boonsiri">@boonsiri</a>
                                                `, 
                                        icon: 'info'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'ไม่สามารถแก้ไขจำนวนสินค้าได้!',
                                        text: `กรุณาติดต่อเจ้าหน้าที่`,
                                        html:   `
                                                    <p>กรุณาติดต่อเจ้าหน้าที่</p>
                                                    โทร: <a href="tel:061-559-5555">061-559-5555</a>
                                                    <br>
                                                    LINE ID: <a href="https://line.me/ti/p/%40boonsiri">@boonsiri</a>
                                                `, 
                                        icon: 'error'
                                    });

                                    console.log(response);
                                }
                            }
                        )
                    }, 
                    500
                );
            }
        }

        $(".create-order").on("click", function() {
            const shipping_type = ($("#shipping_type").prop('checked') == true) ? 2 : 1;

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

            console.log(shipping_type);
            
            $.ajax({
                type: "POST",  
                url: "<?=rootURL();?>action/purchase/", 
                data: {
                    "shipping_type": shipping_type
                }, 
                success: function(response) {  
                    let data = $.parseJSON(response);

                    if (data.responseCode == "000") {
                        window.location.replace(`<?=rootURL();?>ยืนยันคำสั่งซื้อ/${data.purchase.id}/`);
                    } else if (data.responseCode == "A04") {
                        Swal.fire({
                            title: 'ที่อยู่จัดส่งไม่รองรับ!',
                            text: `กรุณาติดต่อเจ้าหน้าที่`,
                            html:   `
                                        <p>กรุณาติดต่อเจ้าหน้าที่</p>
                                        โทร: <a href="tel:061-559-5555">061-559-5555</a>
                                        <br>
                                        LINE ID: <a href="https://line.me/ti/p/%40boonsiri">@boonsiri</a>
                                    `, 
                            icon: 'error'
                        });
                    } else if (data.responseCode == "S01") {
                        Swal.fire({
                            title: 'สินค้าไม่เพียงพอ!',
                            text: `กรุณาติดต่อเจ้าหน้าที่`,
                            html:   `
                                        <p>กรุณาติดต่อเจ้าหน้าที่</p>
                                        โทร: <a href="tel:061-559-5555">061-559-5555</a>
                                        <br>
                                        LINE ID: <a href="https://line.me/ti/p/%40boonsiri">@boonsiri</a>
                                    `, 
                            icon: 'error'
                        });
                    } else {
                        Swal.fire(
                            'สั่งซื้อสินค้าไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือ ติดต่อเจ้าหน้าที่`,
                            'error'
                        );

                        console.log(data)
                    }
                }
            });
        });
        
        const PreviewThumbnailModal = document.getElementById('PreviewThumbnailModal');
        if (PreviewThumbnailModal) {
            PreviewThumbnailModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const img = button.getAttribute('data-bs-img')
                // If necessary, you could initiate an Ajax request here
                // and then do the updating in a callback.

                // Update the modal's content.
                const PreviewThumbnailModalIMG = PreviewThumbnailModal.querySelector('#PreviewThumbnailModalIMG')

                PreviewThumbnailModalIMG.src = img
            })
        }
    </script>

</body>

</html>