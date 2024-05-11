<!doctype html>
<html lang="en">

<head>
    
    <?php
        $page = "dashboard";
    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boonsiri Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
        html, body, section, html > body.swal2-height-auto {
            height: 100% !important;
        }

        html, body, section {
            background-image: url('https://img.freepik.com/free-photo/top-view-fresh-seafood-table_23-2148290490.jpg?w=1380&t=st=1705101388~exp=1705101988~hmac=47888721845dbcd6c2e916f13d2456a2e0cf48f2413df94911ef34de3b895c67');
            background-size: cover;
        }
    </style>
</head>

<body class="bg-theme-main">

    <section class="d-flex h-100">
        <div class="container my-auto">
            <div class="row">
                <div class="col-auto mx-auto d-flex flex-column">
                    <div class="card text-bg-dark">
                        <div class="card-body text-center">
                            <img src="../images/logo.png" alt="Boonsiri" height="60" class="mx-auto mb-4">
                            <form id="LoginForm">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="userCode" id="userCode" placeholder="userCode">
                                    <label for="userCode">userCode</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                                <button type="button" class="btn btn-light w-100" id="Login">LOGIN</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#Login").click(function() {
            Swal.fire({
                title: 'กำลังตรวจสอบ...',
                showDenyButton: false,
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post(
                "./check-login.php", 

                $('#LoginForm').serialize(),

                function(data, status){
                    if (data == "success") {
                        Swal.fire(
                            'Success!',
                            '',
                            'success'
                        ).then(function() {
                            Swal.fire({
                                title: 'กำลังเข้าสู่ระบบ...',
                                showDenyButton: false,
                                showConfirmButton: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            window.location = "./"
                        });
                    } else {
                        Swal.fire(
                            'Login failed!',
                            '',
                            'error'
                        )

                        console.log(data)
                    }
                }
            );
        });
    </script>
</body>

</html>