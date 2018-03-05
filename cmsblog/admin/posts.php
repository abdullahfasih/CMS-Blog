<?php
require_once '../models/User.php';
require_once '../models/Post.php';
require_once '../models/Comment.php';
require_once '../models/Category.php';
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


                <div class="row">
                    <div class="col-xs-12">
                        <?php
                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }
                        switch ($source) {
                            case 'add_post':
                                include 'views/add_post.php';
                                break;
                            case 'edit_post':
                                include 'views/edit_post.php';
                                break;
                            default:
                                include 'views/view_all_posts.php';
                                break;
                        }
                        ?>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php require_once 'views/footer.php'; ?>