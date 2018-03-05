<?php
require_once '../models/User.php';
require_once '../models/Comment.php';
require_once '../models/Post.php';
require_once 'views/header.php';
?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once 'views/nav.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <?php require_once 'views/onlineUser.php'; ?>
                <!-- /.row -->

                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Author</th>
                                    <th>Comments</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {


                                    $comments = Comment::getComments();
                                    foreach ($comments as $cm) {

                                        echo "<tr>
                                            <td>$cm->commentID</td>
                                            <td>$cm->author</td>
                                            <td>$cm->description</td>
                                            <td>$cm->email</td>
                                            <td>$cm->status</td>
                                            <td>";
                                        try {
                                            $objPost = new Post();
                                            $objPost->postID = $cm->postID;
                                            $objPost->getPost();
                                            echo "<a href='../post.php?post_id=$objPost->postID'>$objPost->postName</a>";
                                        } catch (Exception $ex) {
                                            echo "Post Not found!";
                                        }

                                        echo "  </td>
                                            <td>$cm->commentDate</td>
                                            <td><a href='process/processComment.php?approve=$cm->commentID'>Approve</a></td>
                                            <td><a href='process/processComment.php?unapprove=$cm->commentID'>Unapprove</a></td>
                                            <td><a href='process/processComment.php?delete=$cm->commentID'>Delete</a></td>
                                        </tr>";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php require_once 'views/footer.php'; ?>