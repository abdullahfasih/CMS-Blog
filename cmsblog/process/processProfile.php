<?php

session_start();
require_once '../models/User.php';

$errors = array();

if(isset($_SESSION['objUser'])){
    $objUser = unserialize($_SESSION['objUser']);
} else {
    return header("Location:../");
}


try {
    $objUser->firstName = $_POST['firstName'];
} catch (Exception $ex) {
    $errors['firstName'] = $ex->getMessage();
}
try {
    $objUser->lastName = $_POST['lastName'];
} catch (Exception $ex) {
    $errors['lastName'] = $ex->getMessage();
}

if (count($errors) == 0) {
    if (isset($_POST['updateProfile'])) {
        try {
//            $userID = isset($_SESSION['objUser']->userID) ? $_SESSION['objUser']->userID: 0;
//            $objUser->userID = $userID;
            $objUser->updateUserProfileData();
            $msg = "<p class='alert alert-success'>Account data updated.</p>";
            $_SESSION['msg'] = $msg;
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $_SESSION['msg'] = $msg;
        }
    }
} else {
    $msg = "*Check your errors";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
    $_SESSION['objUser'] = serialize($objUser);
}
header("Location:../editProfile.php");
