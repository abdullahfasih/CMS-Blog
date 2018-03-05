
<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
if (isset($_SESSION['msgErr'])) {
    echo $_SESSION['msgErr'];
    unset($_SESSION['msgErr']);
}
?>
<form action="process/processPost.php" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="postName">Post Title</label>
        <input type="text" name="postName" class="form-control">
        <span>
            <?php
            if (isset($errors['postName'])) {
                echo $errors['postName'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="post_cat_id">Post Category</label>
        <select name="categoryID" id="categoryID" class="form-control">
            <option value="">select..</option>
            <?php
            $cat = Category::getCats();

            foreach ($cat as $c) {
                echo "<option value='$c->categoryID'>$c->categoryName</option>";
            }
            ?>
        </select>
        <span>
            <?php
            if (isset($errors['categoryID'])) {
                echo $errors['categoryID'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="authorID">Post Auther</label>
        <select name="authorID" id="authorID" class="form-control">
            <option value="">select..</option>
            <?php
            $users = User::getUsers();
            foreach ($users as $u) {
                echo "<option value='$u->userID'>$u->userName</option>";
            }
            ?>
        </select>
        <span>
            <?php
            if (isset($errors['authorID'])) {
                echo $errors['authorID'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="status">Post Status</label>
        <div class="radio">
            <label>
                <input type="radio" name="status" id="blankRadio1" value="published" aria-label="...">Publish
            </label>
            <label>
                <input type="radio" name="status" id="blankRadio1" value="draft" aria-label="...">Draft
            </label>

        </div>
        <span>
            <?php
            if (isset($errors['status'])) {
                echo $errors['status'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="postImage">Post Image</label>
        <input type="file" name="postImage" class="">
        <span>
            <?php
            if (isset($errors['postImage'])) {
                echo $errors['postImage'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" name="tags" class="form-control">
        <span>
            <?php
            if (isset($errors['tags'])) {
                echo $errors['tags'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <label for="description">Post Description</label>
        <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
        <span>
            <?php
            if (isset($errors['description'])) {
                echo $errors['description'];
            }
            ?>
        </span>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="addPost" value="Add Post">
    </div>

</form>