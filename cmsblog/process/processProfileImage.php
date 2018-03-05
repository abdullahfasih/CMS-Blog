<?php

session_start();
require_once '../models/User.php';

$errors = array();

if (isset($_SESSION['objUser'])) {
    $objUser = unserialize($_SESSION['objUser']);
} else {
    return header("Location:../profile.php");
}


try {
    $objUser->profileImage = $_FILES['profileImage'];
} catch (Exception $ex) {
    $errors['profileImage'] = $ex->getMessage();
}

if (count($errors) == 0) {
    try {
        $objUser->uploadProfileImage($_FILES['profileImage']['tmp_name']);
        $msg = "<p class='alert alert-success'>Profile Image updated.</p>";
        $_SESSION['msg'] = $msg;
    } catch (Exception $ex) {
        $msg = $ex->getMessage();
        $_SESSION['msg'] = $msg;
    }
} else {
    $msg = "*Check your errors";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
    $_SESSION['objUser'] = serialize($objUser);
}
header("Location:../profile.php");
