<?php
require_once '../models/User.php';
require_once '../models/Category.php';
require_once '../models/Comment.php';
require_once '../models/Post.php';
require_once './views/header.php';
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
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $post_count = Post::postCount();
                                        echo "<div class='huge'>$post_count</div>";
                                        ?>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $comment_count = Comment::commentCount();
                                        echo "<div class='huge'>$comment_count</div>";
                                        ?>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
//                                        $name = '';
                                        $user_count = User::userCount();
                                        echo "<div class='huge'>$user_count</div>";
                                        ?>
                                        <div>Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-align-justify fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $category_count = Category::categoryCount();
                                        echo "<div class='huge'>$category_count</div>";
                                        ?>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <?php
                $post_status = "published";
                $count_published_posts = Post::postCount($post_status);

                $name = "draft";
                $count_draft_posts = Post::postCount($name);

                $comment_status = "unapproved";
                $count_unapproved_comments = Comment::commentCount($comment_status);

                $user_role = 'subscriber';
                $count_subscriber = User::userCount($user_role);
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <script type="text/javascript">
                            google.charts.load('current', {'packages': ['bar']});
                            google.charts.setOnLoadCallback(drawChart);
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Data', 'Count'],
<?php
$element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
$element_count = [$post_count, $count_published_posts, $count_draft_posts, $comment_count, $count_unapproved_comments, $user_count, $count_subscriber, $category_count];

for ($i = 0; $i < 7; $i++) {
    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
}
?>
                                    //                              ['Posts', 1000]

                                ]);

                                var options = {
                                    chart: {
                                        title: 'Zubair Niazi',
                                        subtitle: 'Professional Web Developer - Creator of CMS',
                                    }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                                chart.draw(data, options);
                            }
                        </script>

                        <div id="columnchart_material" style="width: auto; height: 500px;"></div>
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