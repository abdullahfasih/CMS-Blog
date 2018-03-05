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

    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" name="firstName" class="form-control">
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
        <input type="text" name="lastName" class="form-control">
        <span>
            <?php
            if (isset($errors['lastName'])) {
                echo $errors['lastName'];
            }
            ?>
        </span>
    </div>

    <div class="form-group">
        <select name="userRole" id="" class="form-control">
            <option value="subscriber">Select option</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
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
        <input type="text" name="userName" class="form-control">
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
        <input type="email" name="email" class="form-control">
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
        <input type="password" name="password" class="form-control">
        <span>
            <?php
            if (isset($errors['password'])) {
                echo $errors['password'];
            }
            ?>
        </span>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="addUser" value="Add User">
    </div>

</form>