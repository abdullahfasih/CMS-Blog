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

<form action="process/processUser.php" method="post" enctype="multipart/form-data">
    <?php
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
        $objUser = new User();
        $objUser->getUser($user_id);
    }
    ?>

    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" name="firstName" value="<?php echo $objUser->firstName; ?>" class="form-control">
        <span>
            <?php
            if (isset($errors['firstName'])) {
                echo $errors['firstName'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" name="lastName" value="<?php echo $objUser->lastName; ?>" class="form-control">
        <span>
            <?php
            if (isset($errors['lastName'])) {
                echo $errors['lastName'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <select name="userRole"  value="" id="" class="form-control">
            <option value="<?php echo $objUser->userRole; ?>"><?php echo $objUser->userRole; ?></option>
            <?php
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
        <span>
            <?php
            if (isset($errors['userRole'])) {
                echo $errors['userRole'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="userName">Username</label>
        <input type="text" name="userName" value="<?php echo $objUser->userName; ?>" class="form-control" disabled>
        <span>
            <?php
            if (isset($errors['userName'])) {
                echo $errors['userName'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo $objUser->email; ?>" class="form-control">
        <span>
            <?php
            if (isset($errors['email'])) {
                echo $errors['email'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" value="" class="form-control" placeholder="Current/New Password">
        <span>
            <?php
            if (isset($errors['password'])) {
                echo $errors['password'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <input type="hidden" name="userID" value="<?php echo $objUser->userID; ?>">
        <input type="submit" class="btn btn-primary" name="updateUser" value="Update User">
    </div>

</form> 