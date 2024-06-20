<?php
    require_once "../functions.php";
    
    header('Access-Control-Allow-Origin: *');

    $job_id = $_POST['job_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $line = $_POST['line'];
    $file = $_FILES['resume']['name'];

    $ext = pathinfo($file, PATHINFO_EXTENSION);
    
    $resume = time().".$ext";

    $upload = move_uploaded_file($_FILES['resume']['tmp_name'], "../candidates/$resume");

    if ($upload) {
        $requestData = [
            "jobId" => $job_id,
            "name" => $name,
            "email" => $email,
            "phone" => $phone,
            "line" => $line,
            "resume" => $resume
        ];

        $data = connect_api("{$API_URL}candidate/insert-candidate", $requestData);

        if ($data['responseCode'] === "000") {
            echo "success";
        } else {
            echo "sending";
        }
    } else {
        echo "upload";
    }
?>