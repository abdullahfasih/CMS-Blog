<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> 
                <span class="sr-only">Toggle navigation</span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
                <span class="icon-bar"></span> 
            </button> 
            <a class="navbar-brand" href="index.php">Tech Blog</a> </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                try {
                    $cat = Category::getCats();
                    foreach ($cat as $c) {
                        echo "<li><a href='category.php?cat_id=$c->categoryID'>{$c->categoryName}</a></li>";
                    }
                } catch (Exception $ex) {
//                    echo "<li><a href=''>{$ex->getMessage()}</a></li>";
                }

                if (!$objUser->login) {
                    echo "<li> <a href = 'registration.php'>Register Now</a> </li>";
                }

                if ($objUser->userRole == 'admin') {
                    if (isset($_GET['post_id'])) {
                        $post_id = $_GET['post_id'];
                        echo "<li><a href='admin/posts.php?source=edit_post&post_id={$post_id}'>Edit Post</a></li>";
                    }
                }
                ?>
            </ul>

            <?php if ($objUser->userRole == 'admin') { ?>
                <!-- Top Menu Items -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                            <?php echo $objUser->userName; ?> 
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="admin"><i class="fa fa-fw fa-dashboard"></i> Admin Panel</a>
                            </li>
                            <li>
                                <a href="admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="process/processLogout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php } else if ($objUser->userRole != 'admin' && $objUser->userID > 0) { ?>
                <!-- Top Menu Items -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 
                            <?php
                            echo $objUser->userName;
                            ?> 
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="process/processLogout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>  

            <?php } ?>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>