<?php
require_once './models/Category.php';
require_once './models/User.php';
require_once 'views/header.php';
?>

<body>
    <?php
    if (isset($_SESSION['objUser']->userID)) {
        header('Location:index.php');
    }
    ?>

    <!-- Navigation -->
    <?php
    require_once 'views/nav.php';
    ?>

    <!-- Page Content -->
    <div class="container">

        <section id="login ">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-wrap">
                            <h1>Change Password</h1>
                            <form role="form" action="process/processChangePassword.php" method="post" id="login-form " class="form-group register-form" autocomplete="off">
                                <h5 class="text-center">
                                    <?php
                                    if (isset($_SESSION['msg'])) {
                                        echo ($_SESSION['msg']);
                                        unset($_SESSION['msg']);
                                    }
                                    if (isset($_SESSION['msgErr'])) {
                                        echo ($_SESSION['msgErr']);
                                        unset($_SESSION['msgErr']);
                                    }
                                    if (isset($_SESSION['errors'])) {
                                        $errors = $_SESSION['errors'];
                                        unset($_SESSION['errors']);
                                    }
                                    ?>
                                </h5>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" placeholder="Password" class="form-control">
                                    <span>
<?php
if (isset($errors['password']))
    echo $errors['password'];
?>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="password2" class="sr-only">Confirm Password</label>
                                    <input type="password" name="password2" id="key" placeholder="Confirm Password" class="form-control">
                                    <span>
<?php
if (isset($errors['password2']))
    echo $errors['password2'];
?>
                                    </span>
                                </div>
                                <input type="submit" name="register" id="btn-login" value="Submit" class="btn btn-custom btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- Footer -->
<?php
require_once 'views/footer.php';
?>
