<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input type="text" name="search" class="form-control"> <span class="input-group-btn">
                    <button class="btn btn-default" name="submit" type="submit">
                        <span class="glyphicon glyphicon-search"></span> </button>
                </span>
            </div>
            <!-- /.input-group -->
        </form>
        <!-- /.form -->
    </div>

    <?php
    if (!$objUser->login) {
        ?>

        <!-- Login Form Well -->
        <div class="well">
            <h4>Login</h4>
            <h5>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo "<br>" . $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                if (isset($_SESSION['msgErr'])) {
                    echo ("<br>" . $_SESSION['msgErr']);
                    unset($_SESSION['msgErr']);
                }
                if (isset($_SESSION['errors'])) {
                    $errors = $_SESSION['errors'];
                    unset($_SESSION['errors']);
                }
                if(isset($_SESSION['loginAttempt'])){
                    echo $_SESSION['loginAttempt'];
                    unset($_SESSION['loginAttempt']);
                }
                ?>
            </h5>
            <form action="process/processLogin.php" method="post">
                <div class="form-group">
                    <input type="text" name="userName" class="form-control" placeholder="Enter Username"> 
                    <span>
                        <?php
                        if (isset($errors['userName']))
                            echo $errors['userName'];
                        ?>
                    </span>
                </div>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password"> 
                    <span class="input-group-btn">
                        <input class="btn btn-primary" name="login" type="submit" value="Login">
                    </span> 

                </div>
                <span>
                    <?php
                    if (isset($errors['password']))
                        echo $errors['password'];
                    ?>
                </span>
                <!-- /.input-group -->
            </form>
            <!-- /.form -->
        </div>

        <?php
    }
    ?>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    try {
                        $cat = Category::getCats();
                        foreach ($cat as $c) {
                            echo "<li><a href='category.php?cat_id={$c->categoryID}'>{$c->categoryName}</a></li>";
                        }
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>
</div>