<?php
require_once '../models/User.php';
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
                        <?php
                        if (isset($_GET['source'])) {
                            $source = $_GET['source'];
                        } else {
                            $source = '';
                        }

                        switch ($source) {
                            case 'add_user':
                                include 'views/add_user.php';
                                break;
                            case 'edit_user':
                                include 'views/edit_user.php';
                                break;
                            default:
                                include 'views/view_all_users.php';
                                break;
                        }
                        ?>
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