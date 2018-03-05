<?php

session_start();
require_once '../models/User.php';

if (isset($_SESSION['objUser'])) {
    $objUser = unserialize($_SESSION['objUser']);
} else {
    return header("Location:../index.php");
}
$errors = array();

try {
    $objUser->password = $_POST['password'];
} catch (Exception $ex) {
    $errors['password'] = $ex->getMessage();
}

try {
    User::comparePasswords($_POST['password'], $_POST['password2']);
} catch (Exception $ex) {
    $errors['password2'] = $ex->getMessage();
}


if (count($errors) == 0) {
    try {
        $objUser->changeForgotPassword($resetCode);
        $msg = "Your password successfully changed.";
        $_SESSION['msg'] = $msg;
    } catch (Exception $ex) {
        $msgErr = $ex->getMessage();
        $_SESSION['msgErr'] = $msgErr;
    }
    header("Location:../profile.php");
} else {
    $msg = "<p class='alert alert-danger'>*Check your error</p>";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
    header("Location: ../changePassword.php");
}
