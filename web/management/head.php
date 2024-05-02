<?php
    require_once "../functions.php";

    if ($_SESSION['admin_id']) {
        $admin_id = $_SESSION['admin_id'];
    } else {
        redirect("./login.php");
    }
?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Boonsiri Management</title>

<link rel="stylesheet" href="<?=rootURL();?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=rootURL();?>sweetalert2.min.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />