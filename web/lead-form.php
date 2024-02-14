<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-auto ms-auto mt-5">
                <h5 class="fs-3">ติดต่อเรา</h5>
                <ul class="list-unstyled list-lead-form">
                    <li class="my-3 icon-facebook"><a class="text-dark fs-5 text-decoration-none" href="https://www.facebook.com/PlatooGuChat">บุญศิริโฟรเซ่น ปลาทูกู้ชาติ</a></li>
                    <li class="my-3 icon-line"><a class="text-dark fs-5 text-decoration-none" href="https://line.me/ti/p/%40boonsiri">@boonsiri</a></li>
                    <li class="my-3 icon-phone"><a class="text-dark fs-5 text-decoration-none" href="tel:094-698-5555">094-698-5555</a></li>
                </ul>
            </div>
            <div class="col-12 col-md offset-0 offset-md-1">
                <h5 class="fs-1 mb-4 text-center">ข้อมูลให้ติดต่อกลับ</h5>
                <div class="card text-bg-light shadow">
                    <div class="card-body">
                        <form action="#" method="POST" id="ContactForm">
                            <div class="row mx-0 g-3">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="LeadFormName" placeholder="ชื่อผู้ติดต่อ" required aria-required="true">
                                        <label for="name">ชื่อผู้ติดต่อ <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="phone" class="form-control" id="LeadFormPhone" inputmode="numeric" placeholder="เบอร์โทรศัพท์" required aria-required="true">
                                        <label for="phone">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="topic" class="form-control" id="LeadFormTopic" placeholder="เรื่องที่ต้องการติดต่อ" required aria-required="true">
                                        <label for="topic">เรื่องที่ต้องการติดต่อ <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="LeadFormEmail" inputmode="email" placeholder="อีเมล">
                                        <label for="email">อีเมล</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="message" placeholder="รายละเอียด" id="LeadFormMessage" style="height: 250px"></textarea>
                                        <label for="message">รายละเอียด</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mx-0">
                                <div class="col">
                                    <label for="time_start" class="form-label mt-3">ช่วงเวลาที่ต้องการให้ติดต่อกลับ</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md">
                                    <div class="row mx-0">
                                        <div class="col-12 col-md">
                                            <div class="input-group">
                                                <span class="input-group-text" id="time_start">เริ่มตั้งแต่เวลา</span>
                                                <input type="time" class="form-control" placeholder="เริ่มตั้งแต่เวลา" id="time_start" name="timeStart" aria-label="time_start" aria-describedby="time_start" inputmode="time">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-auto px-0 my-auto text-center">
                                            <p class="mb-0"><i class="fa-solid fa-minus"></i></p>
                                        </div>
                                        <div class="col-12 col-md">
                                            <div class="input-group">
                                                <span class="input-group-text" id="time_end">สิ้นสุดระยะเวลา</span>
                                                <input type="time" class="form-control" placeholder="สิ้นสุดระยะเวลา" id="time_end" name="timeEnd" aria-label="time_end" aria-describedby="time_end" inputmode="time">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-auto ps-md-0">
                                    <div class="row mx-0">
                                        <div class="col">
                                            <button type="submit" class="btn btn-theme-4 w-100 px-4 mt-3 mt-md-0">ส่งข้อความ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>