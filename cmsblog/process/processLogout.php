<?php

session_start();
require_once '../models/User.php';

$objUser = unserialize($_SESSION['objUser']);

try {
    $objUser->logout();
    $_SESSION['msg'] = "You have logged out";
} catch (Exception $ex) {
    $_SESSION['msgErr'] = $ex->getMessage();
}
header("Location:../index.php");
