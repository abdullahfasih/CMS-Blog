<?php

session_start();
require_once '../../models/Post.php';

$objPost = new Post();
$errors = array();

if (isset($_GET['reset'])) {

    $post_id = $_GET['reset'];
    $objPost->postID = $post_id;
    $objPost->resetPostViews();

    die(header("Location: ../posts.php"));
} else if (isset($_GET['delete'])) {

    $postID = $_GET['delete'];
    $objPost->postID = $postID;
    $objPost->deletePost();
    die(header("Location: ../posts.php"));
} else if (isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $postValueID) {
        $bulkOption = $_POST['bulkOption'];
        $objPost->bulkPost($bulkOption, $postValueID);
    }
    die(header("Location: ../posts.php"));
}


try {
    $objPost->postName = $_POST['postName'];
} catch (Exception $ex) {
    $errors['postName'] = $ex->getMessage();
}
try {
    $objPost->categoryID = $_POST['categoryID'];
} catch (Exception $ex) {
    $errors['categoryID'] = $ex->getMessage();
}
try {
    $objPost->authorID = $_POST['authorID'];
} catch (Exception $ex) {
    $errors['authorID'] = $ex->getMessage();
}
try {
    $objPost->status = $_POST['status'];
} catch (Exception $ex) {
    $errors['status'] = $ex->getMessage();
}
try {
    $objPost->postImage = $_FILES['postImage'];
} catch (Exception $ex) {
    $errors['postImage'] = $ex->getMessage();
}
try {
    $objPost->tags = $_POST['tags'];
} catch (Exception $ex) {
    $errors['tags'] = $ex->getMessage();
}
try {
    $objPost->description = $_POST['description'];
} catch (Exception $ex) {
    $errors['description'] = $ex->getMessage();
}

if (isset($_POST['updatePost'])) {
    $postID = $_POST['postID'];
    $objPost->postID = $postID;
    $objPost->updatePost();
    $msg = "<p class='bg-success'>Post Updated. <a href='../post.php?post_id=$objPost->postID'> View Post</a> | <a href='posts.php'> Edit more Posts</a> </p>";
    $_SESSION['msg'] = $msg;
    $objPost->uploadPostImage($_FILES['postImage']['tmp_name']);
    header("Location: ../posts.php?source=edit_post&post_id=$objPost->postID");
}


if (count($errors) == 0) {
    try {
        if (isset($_POST['addPost'])) {
            $objPost->addPost();
            $msg = "<p class='bg-success'>Post Created. <a href='../post.php?post_id=$objPost->postID'> View Post</a>"
                    . " | <a href='posts.php'> Edit more Posts</a> </p>";
            $_SESSION['msg'] = $msg;
            $objPost->uploadPostImage($_FILES['postImage']['tmp_name']);
        }
    } catch (Exception $ex) {
        $msgErr = $ex->getMessage();
        $_SESSION['msgErr'] = $msgErr;
    }
} else {
    $msg = "<p class='bg-danger'>*Check your Errors</p>";
    $_SESSION['msg'] = $msg;
    $_SESSION['errors'] = $errors;
}
header("Location: ../posts.php?source=add_post");
