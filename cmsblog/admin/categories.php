<?php
require_once '../models/User.php';
require_once '../models/Category.php';
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
                    <div class="col-xs-6">
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
                        <form action="process/processCategory.php" method="post">
                            <div class="form-group">
                                <label for="categoryName">Add Category</label>
                                <input type="text" name="categoryName" class="form-control">
                                <span>
                                    <?php
                                    if (isset($errors['categoryName'])) {
                                        echo $errors['categoryName'];
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="addCat" value="Add Category" class="btn btn-primary">
                            </div>
                            <?php
                            if (isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];
                                $objCat = new Category();
                                $objCat->categoryID = $cat_id;
                                $objCat->getCategory();
                                ?>
                                <div class="form-group">
                                    <label for="category">Edit Category</label>
                                    <input type="text" name="categoryName" value="<?php echo $objCat->categoryName; ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="categoryID" value="<?php echo $objCat->categoryID; ?>">
                                    <input type="submit" name="updateCat" value="Update Category" class="btn btn-primary">
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                    <!-- /.col-xs-6 -->
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $cat = Category::getCats();

                                    foreach ($cat as $c) {
                                        echo "<tr>
                                            <td>$c->categoryID</td>
                                            <td>$c->categoryName</td>
                                            <td><a href='categories.php?edit=$c->categoryID'>Edit</td>
                                            <td><a href='process/processCategory.php?delete=$c->categoryID'>Delete</td>
                                        </tr>";
                                    }
                                } catch (Exception $ex) {
                                    echo $ex->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col-xs-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php require_once 'views/footer.php'; ?>