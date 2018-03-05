<?php
session_start();

define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/project/cmsblog/admin/");

if (isset($_COOKIE['objUser'])) {
    $_SESSION['objUser'] = $_COOKIE['objUser'];
}
if (isset($_SESSION['objUser'])) {
    $objUser = unserialize($_SESSION['objUser']);
} else {
    $objUser = new User();
}

// admin panel restrictions - if admin is not logged in then redirect to home site
if ($objUser->login) {
    if ($objUser->userRole != 'admin') {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Tech Blog - Admin Panel</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo BASE_URL; ?>css/bootstrap.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo BASE_URL; ?>css/sb-admin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo BASE_URL; ?>font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Style CSS -->
        <link href="<?php echo BASE_URL; ?>css/style.css" rel="stylesheet">

        <!-- TinyMCE -->
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>


    </head>
