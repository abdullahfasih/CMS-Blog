<?php
require_once './models/Category.php';
require_once './models/Comment.php';
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
                    $postID = isset($_GET['post_id']) ? $_GET['post_id'] : 0;

                    $objPost = new Post();
                    $objPost->postID = $postID;
                    $status = 'published';
                    $objPost->getPost($status);

                    try {
                        $objAuthor = new User();
                        $objAuthor->getUser($objPost->authorID);
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }

                    echo "<h2>$objPost->postName</h2>
                    <p class='lead'>by <a href='author_posts.php?author=$objAuthor->userID'>$objAuthor->userName</a></p>
                    <p><span class='glyphicon glyphicon-time'></span> Posted on $objPost->postDate</p>
                    <hr>
                    <img class='img-responsive' src='images/posts/$objPost->postName/$objPost->postImage' alt='$objPost->postImage'>
                    <hr>
                    <p>$objPost->description</p>
                    <hr>";
                    ?>

                    <!-- Blog Comments -->

                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Review:
                            <?php
                            if (isset($_SESSION['msg'])) {
                                $msg = $_SESSION['msg'];
                                echo $msg;
                                unset($_SESSION['msg']);
                            }
                            if (isset($_SESSION['errors'])) {
                                $errors = $_SESSION['errors'];
                                unset($_SESSION['errors']);
                            }
                            ?>
                        </h4>
                        <form action="admin/process/processComment.php" method="post" role="form">
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input type="text" name="author" value="<?php echo $objUser->userName; ?>" class="form-control" >
                                <span>
                                    <?php
                                    if (isset($errors['author'])) {
                                        echo $errors['author'];
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="<?php echo $objUser->email; ?>" class="form-control" >
                                <span>
                                    <?php
                                    if (isset($errors['email'])) {
                                        echo $errors['email'];
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="content">Your Comment</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                                <span>
                                    <?php
                                    if (isset($errors['description'])) {
                                        echo $errors['description'];
                                    }
                                    ?>
                                </span>
                            </div>
                            <input type="hidden" name="postID" value="<?php echo $objPost->postID; ?>">
                            <button type="submit" name="createComment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->
                    <!-- Comment -->
                    <?php
                    $comments = Comment::getComments('approved', $objPost->postID);
                    foreach ($comments as $cm) {
                        echo "<div class='media'>
                                <a class='pull-left' href='#'>
                                  <img class='media-object' src='http://placehold.it/64x64' alt=''>
                                </a>
                             <div class='media-body'>
                                <h4 class='media-heading'>$cm->author<small> $cm->commentDate</small></h4>$cm->description
                             </div>
                             </div>";
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

        <hr>

        <!-- Footer -->
        <?php
        require_once 'views/footer.php';
        ?>