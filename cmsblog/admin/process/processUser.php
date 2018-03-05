<?php

session_start();
require_once '../../models/User.php';

$objUser = new User();
$errors = array();


if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'active') {
        $status = 1;
    } else {
        $status = 0;
    }
    try {
        $objUser->userID = $_GET['userID'];
        $objUser->changeStatus($status);
    } catch (Exception $ex) {
//        echo $ex->getMessage();
    }
    header("Location: ../users.php");
    die;
}

if (isset($_GET['delete'])) {
    try {
        $user_id = $_GET['delete'];
        $objUser->userID = $user_id;
        $objUser->deleteUser();
    } catch (Exception $ex) {
//        echo $msg = $ex->getMessage();
//        $_SESSION['msg'] = $msg;
    }
    header("Location: ../users.php");
    die;
}
if (isset($_GET['admin'])) {
    try {
        $user_id = $_GET['admin'];
        $objUser->userID = $user_id;
        $objUser->userRole = 'admin';
        $objUser->updateAdmin();
    } catch (Exception $ex) {
//        echo $msg = $ex->getMessage();
//        $_SESSION['msg'] = $msg;
    }
    header("Location: ../users.php");
    die;
}
if (isset($_GET['subscriber'])) {
    try {
        $user_id = $_GET['subscriber'];
        $objUser->userID = $user_id;
        $objUser->userRole = 'subscriber';
        $objUser->updateAdmin();
    } catch (Exception $ex) {
//        echo $msg = $ex->getMessage();
//        $_SESSION['msg'] = $msg;
    }
    header("Location: ../users.php");
    die;
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
try {
    $objUser->email = $_POST['email'];
} catch (Exception $ex) {
    $errors['email'] = $ex->getMessage();
}
//try {
//    $objUser->userName = $_POST['userName'];
//} catch (Exception $ex) {
//    $errors['userName'] = $ex->getMessage();
//}
try {
    $objUser->userRole = $_POST['userRole'];
} catch (Exception $ex) {
    $errors['userRole'] = $ex->getMessage();
}
try {
    $objUser->password = $_POST['password'];
} catch (Exception $ex) {
    $errors['password'] = $ex->getMessage();
}

if (count($errors) == 0) {
    if (isset($_POST['addUser'])) {
        try {
            $objUser->addUser();
            $msg = "<p class='bg-success'>User Created: " . " " . "<a href='users.php' class='btn btn-link'>View Users</a></p>";
            $_SESSION['msg'] = $msg;
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $_SESSION['msg'] = $msg;
        }
        header("Location: ../users.php?source=add_user");
    }
    if (isset($_POST['updateUser'])) {
        try {
            $userID = $_POST['userID'];
            $objUser->userID = $userID;
            $objUser->updateUser();
            $msg = "<p class='bg-success'>User Updated: " . " " . "<a href='users.php' class='btn btn-link'>View Users</a></p>";
            $_SESSION['msg'] = $msg;
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $_SESSION['msg'] = $msg;
        }
        header("Location: ../users.php?source=edit_user&user_id=$userID");
    }
    if (isset($_POST['updateProfile'])) {
        try {
            $userID = $_POST['userID'];
            $objUser->userID = $userID;
            $objUser->updateUser();
            $msg = "<p class='bg-success'>Profile Updated: " . " " . "<a href='users.php' class='btn btn-link'>View all Users</a></p>";
            $_SESSION['msg'] = $msg;
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            $_SESSION['msg'] = $msg;
        }
        header("Location: ../profile.php");
    }
} else {
    $msg = "<p class='bg-danger'>*Check your Errors</p>";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;

    if (isset($_POST['addUser'])) {
        header("Location: ../users.php?source=add_user");
    } else if (isset($_POST['updateUser'])) {
        $userID = $_POST['userID'];
        header("Location: ../users.php?source=edit_user&user_id=$userID");
    } else {
        header("Location: ../profile.php");
    }
}
