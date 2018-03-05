<?php

session_start();
require_once '../../models/Comment.php';

$objComment = new Comment();
$errors = array();


if (isset($_GET['approve'])) {
    $comment_id = $_GET['approve'];
    $objComment->commentID = $comment_id;
    $objComment->status = 'approved';
    try {
        $objComment->updateComment();
    } catch (Exception $ex) {
        $ex->getMessage();
    }

    header("Location: ../comments.php");
} else if (isset($_GET['unapprove'])) {
    $comment_id = $_GET['unapprove'];
    $objComment->commentID = $comment_id;
    $objComment->status = 'unapproved';
    try {
        $objComment->updateComment();
    } catch (Exception $ex) {
        $ex->getMessage();
    }

    header("Location: ../comments.php");
} else if (isset($_GET['delete'])) {
    $comment_id = $_GET['delete'];
    $objComment->commentID = $comment_id;
    try {
        $objComment->deleteComment();
    } catch (Exception $ex) {
        $ex->getMessage();
    }

    header("Location: ../comments.php");
}

try {
    $objComment->postID = $_POST['postID'];
} catch (Exception $ex) {
    $errors['postID'] = $ex - getMessage();
}

try {
    $objComment->author = $_POST['author'];
} catch (Exception $ex) {
    $errors['author'] = $ex - getMessage();
}

try {
    $objComment->email = $_POST['email'];
} catch (Exception $ex) {
    $errors['email'] = $ex - getMessage();
}

try {
    $objComment->description = $_POST['description'];
} catch (Exception $ex) {
    $errors['description'] = $ex->getMessage();
}


if (count($errors) == 0) {
    try {
        $postID = $_POST['postID'];
        $objComment->addComment();
        $msg = "Comment has been submitted, wait for approvel!";
        $_SESSION['msg'] = $msg;
    } catch (Exception $ex) {
        $msgErr = $ex->getMessage();
        $_SESSION['msg'] = $msgErr;
    }
} else {
    $msg = "*Check your errors!";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
    $postID = $_POST['postID'];
}
header("Location: ../../post.php?post_id=$postID");













