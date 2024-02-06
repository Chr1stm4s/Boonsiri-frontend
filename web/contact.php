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

    <section class="header-contact">
        <div class="container my-auto">
            <div class="row">
                <div class="col text-center">
                    <h1 class="mb-0 f-shadow text-white">ติดต่อเรา</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=rootURL();?>" class="text-theme-1">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active" aria-current="page">ติดต่อเรา</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-md-6 my-auto">
                    <img src="https://img.freepik.com/free-photo/logistic-center-with-desk-chairs_23-2148943357.jpg?w=826&t=st=1690486563~exp=1690487163~hmac=b01e605f09fa7315962eaad7b378ed1b6cabeb429fa0d81e7cdc980e04530555" alt="" class="img-thumbnail w-100 rounded-4 p-3">
                </div>
                <div class="col-12 col-md-4 mx-auto py-3 py-md-5">
                    <div class="row mx-0 mb-4">
                        <div class="col-auto px-0">
                            <h3 class="border-bottom border-2 border-info">ฟอร์มติดต่อ</h3>
                        </div>
                    </div>
                    <form action="#" method="POST" id="ContactForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">ชื่อผู้ติดต่อ</label>
                            <input type="text" class="form-control" name="name" id="LeadFormName" placeholder="ชื่อผู้ติดต่อ">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">อีเมล</label>
                            <input type="email" class="form-control" name="email" id="LeadFormEmail" inputmode="email" placeholder="youremail@email.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="tel" class="form-control" name="phone" id="LeadFormPhone" inputmode="numeric" placeholder="099-999-9999">
                        </div>
                        <div class="mb-3">
                            <label for="line" class="form-label">LINE ID</label>
                            <input type="text" class="form-control" name="line" id="LeadFormLine" placeholder="LINE ID">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">ข้อความติดต่อ</label>
                            <textarea name="message" id="LeadFormMessage" cols="30" rows="10" class="form-control" placeholder="ข้อความติดต่อ"></textarea>
                        </div>
                        <button type="button" class="btn btn-theme-2" id="SubmitLeadForm">ส่งข้อความ &nbsp;<i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "./footer.php"; ?>
    <?php require_once "./js.php"; ?>

</body>

</html>