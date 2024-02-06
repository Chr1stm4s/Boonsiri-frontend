<script>
    $(".add-to-cart").on("click", function() {
        const id = $(this).data("id");
        const amount = ($(this).data("amount")) ? $(this).data("amount") : $("#amount").val();

        if (amount) {
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
                type: "POST",  
                url: "<?=rootURL();?>action/add-to-cart/",  
                data: {
                    id: id, 
                    amount: amount, 
                },  
                success: function(response) {  
                    if (response == "Success") {
                        const CartAmount = document.getElementById('CartAmount');
                        const CartAmountMobile = document.getElementById('CartAmountMobile');

                        if (CartAmount) {
                            $.ajax({
                                type: "POST",  
                                url: "<?=rootURL();?>action/shopping-bag/",
                                success: function(response) {  
                                    CartAmount.textContent = response;
                                    CartAmountMobile.textContent = response;

                                    Swal.fire(
                                        'หยิบใส่ตะกร้าเรียบร้อย!',
                                        '',
                                        'success'
                                    );
                                }
                            });
                        }
                    } else if (response == "Insufficient") {
                        Swal.fire(
                            'สินค้าไม่เพียงพอ!',
                            `กรุณาเลือกจำนวนใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'info'
                        );
                    } else {
                        Swal.fire(
                            'หยิบใส่ตะกร้าไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );

                        console.log(response)
                    }
                }
            });
        } else {
            Swal.fire(
                'หยิบใส่ตะกร้าไม่สำเร็จ!',
                `กรุณาเลือกจำนวนสินค้า`,
                'info'
            );
        }
    });

    $(".pre-order").on("click", function() {
        const id = $(this).data("id");
        const amount = ($(this).data("amount")) ? $(this).data("amount") : $("#amount").val();

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

        if (amount) {
            $.ajax({
                type: "POST",  
                url: "<?=rootURL();?>action/pre-order/",  
                data: {
                    id: id, 
                    amount: amount, 
                },  
                success: function(response) {  
                    if (response == "Success") {
                        Swal.fire(
                            'สั่งซื้อสินค้าเรียบร้อย!',
                            '',
                            'success'
                        );
                    } else {
                        Swal.fire(
                            'สั่งซื้อสินค้าไม่สำเร็จ!',
                            `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                            'error'
                        );

                        console.log(response)
                    }
                }
            });
        } else {
            Swal.fire(
                'สั่งซื้อสินค้าไม่สำเร็จ!',
                `กรุณาเลือกจำนวนสินค้า`,
                'info'
            );
        }
    });

    $(".btn-remove-cart").click(function() {
        const productId = $(this).data("id");

        RemoveCartItem(productId);
    });

    function RemoveCartItem(productId) {
        Swal.fire({
            icon: 'info', 
            title: 'ยืนยันลบสินค้าออกจากคำสั่งซื้อ?', 
            showDenyButton: false, 
            showCancelButton: true, 
            confirmButtonText: 'ตกลง', 
            cancelButtonText: `ยกเลิก`, 
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
                
                $.post(
                    "<?=rootURL();?>action/remove-cart/", 
                    {
                        productId: productId 
                    }, function(response){
                        if (response == "success") {
                            Swal.fire(
                                'นำสินค้าออกเรียบร้อย!',
                                '',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'นำสินค้าออกไม่สำเร็จ!',
                                `กรุณาลองใหม่ หรือติดต่อเจ้าหน้าที่`,
                                'error'
                            );

                            console.log(response)
                        }
                    }
                );
            }
        });
    }
</script>