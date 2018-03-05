<?php

session_start();
require '../../models/Category.php';

$objCat = new Category();
$errors = array();


//query to delete category
if (isset($_GET['delete'])) {
    $cat_id = $_GET['delete'];
    $objCat->categoryID = $cat_id;
    $objCat->deleteCat();
    die(header("Location: ../categories.php"));
}

try {
    $objCat->categoryName = $_POST['categoryName'];
} catch (Exception $ex) {
    $errors['categoryName'] = $ex->getMessage();
}

if (count($errors) == 0) {
    try {
        if (isset($_POST['addCat'])) {
            $objCat->addCat();
        }
        if (isset($_POST['updateCat'])) {
            $cat_id = $_POST['categoryID'];
            $objCat->categoryID = $cat_id;
            $objCat->updateCat();
        }
    } catch (Exception $ex) {
        $msg = $ex->getMessage();
        $_SESSION['msg'] = $msg;
    }
} else {
    $msg = "*Check your errors";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
}
header("Location: ../categories.php");
