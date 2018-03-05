<?php

session_start();
require_once '../models/User.php';

$errors = array();
$objUser = new User();

try {
    $objUser->userName = $_POST['userName'];
} catch (Exception $ex) {
    $errors['userName'] = $ex->getMessage();
}
try {
    $objUser->email = $_POST['email'];
} catch (Exception $ex) {
    $errors['email'] = $ex->getMessage();
}

try {
    $objUser->password = $_POST['password'];
} catch (Exception $ex) {
    $errors['password'] = $ex->getMessage();
}

if (count($errors) == 0) {
    try {
        if ($objUser->checkUserByUsername()) {
            $invalidUsername = "<div class='alert alert-danger'>Username already registered, try with different username</div>";
            $_SESSION['invalidUsername'] = $invalidUsername;
        }
        if ($objUser->checkUserByEmail()) {
            $invalidEmail = "<div class='alert alert-danger'>Email already registered, try with different email</div>";
            $_SESSION['invalidEmail'] = $invalidEmail;
        }
        if (!isset($invalidUsername) && !isset($invalidEmail)) {
            $objUser->addUser();
            $msg = "<p class='alert alert-success'>Your subscrition has been submitted, wait for admin approval.</p>";
            $_SESSION['msg'] = $msg;
        }
    } catch (Exception $ex) {
        $_SESSION['msgErr'] = $ex->getMessage();
    }
} else {
    $msg = "*Check your errors";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
    $_SESSION['objUser'] = serialize($objUser);
}
header("Location:../registration.php");
