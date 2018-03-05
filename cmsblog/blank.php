<?php
require_once './models/Category.php';
require_once './models/User.php';
require_once './models/Post.php';
require_once './views/header.php';
?>

<body>
    <!-- Navigation -->
    <?php
    require_once 'views/nav.php';
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php require_once './views/heroHeading.php'; ?>
                
                <!-- ****************************************************** -->
                
                <h1>Placeholder</h1>
                
                <!-- ****************************************************** -->
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
            require_once 'views/sidebar.php';
            ?>

        </div>
        <!-- /.row -->
        <hr>
        <!-- Footer -->
        <?php
        require_once 'views/footer.php';
        ?>
