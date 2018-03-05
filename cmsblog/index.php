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

                <!-- First Blog Post -->
                <?php
                try {
                    $start = isset($_GET['start']) ? $_GET['start'] : 0;
                    $count = isset($_GET['count']) ? $_GET['count'] : ITEM_PER_PAGE;


                    $posts = Post::getPosts('published', 'DESC', $start, $count);

                    foreach ($posts as $p) {
                        try {
                            $objAuthor = new User();
                            $objAuthor->getUser($p->authorID);
                        } catch (Exception $ex) {
                            echo $ex->getMessage();
                        }

                        echo "<h2>
                        <a href='post.php?post_id=$p->postID'>$p->postName</a>
                    </h2>
                    <p class='lead'>
                        by <a href='author_posts.php?author=$objAuthor->userID'>$objAuthor->userName</a>
                    </p>
                    <!-- p><span class='glyphicon glyphicon-time'></span> Posted on August 28, 2013 at 10:00 PM</p -->

                    <p><span class='glyphicon glyphicon-time'></span> Posted on $p->postDate</p>
                    <hr>
                    <a href='post.php?post_id=$p->postID'>
                        <img class='img-responsive' src='images/posts/$p->postName/$p->postImage' alt='$p->postImage'>
                    </a>
                    <hr>
                    <p>" . (substr($p->description, 0, 250) . '...') . "</p>
                    <a class='btn btn-primary btn-md' href='post.php?post_id=$p->postID'>Read More <span class='glyphicon glyphicon-chevron-right'></span></a>
                    <hr>";
                    }
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                ?>
            </div>

            <!-- ****************************************************** -->

            <!-- Blog Sidebar Widgets Column -->
            <?php
            require_once 'views/sidebar.php';
            ?>

        </div>
        <!-- /.row -->

        <div class="row">
            <ul class="pager">
                <?php
                try {
                    $pNums = Post::pageination(ITEM_PER_PAGE);

                    foreach ($pNums as $pNo => $start) {
                        echo "<li><a href='" . BASE_URL . "index.php?start=$start'>$pNo</a></li>";
                    }
                } catch (Exception $ex) {
                    echo ($ex->getMessage());
                }
                ?>
            </ul>
            <!-- /.pager -->
        </div>


        <hr>

        <!-- Footer -->
        <?php
        require_once 'views/footer.php';
        ?>