
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
    <?php
    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];
        $objPost = new Post();
        $objPost->postID = $post_id;
        $objPost->getPost();
        ?>
        <div class="form-group">
            <label for="postName">Post Title</label>
            <input type="text" value="<?php echo $objPost->postName; ?>" name="postName" class="form-control">
            <span>
                <?php
                if (isset($errors['postName'])) {
                    echo $errors['postName'];
                }
                ?>
            </span>
        </div>
        <div class="form-group">
            <label for="categoryID">Post Category</label>
            <select name="categoryID" id="" class="form-control">
                <option value="<?php echo $objPost->categoryID; ?>">select..</option>
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
            <label for="auther">Post Auther</label>
            <select name="authorID" id="auther" class="form-control">
                <option value="<?php echo $objPost->authorID; ?>">select..</option>
                <?php
                $users = User::getUsers();
                foreach ($users as $u) {
                    echo "<option value='$u->userID'>$u->userName</option>";
                }
                ?>
            </select>
            <span>
                <?php
                if (isset($errors['author'])) {
                    echo $errors['author'];
                }
                ?>
            </span>
        </div>

        <div class="form-group">
            <label for="status">Post Status</label>
            <div class="radio">
                <?php
                if ($objPost->status == 'published') {
                    ?>
                    <label><input type="radio" name="status" id="" value="published" checked>Publish</label>
                    <label><input type="radio" name="status" id="" value="draft">Draft</label>
                    <?php
                } else {
                    ?>
                    <label><input type="radio" name="status" id="" value="published">Publish</label>
                    <label><input type="radio" name="status" id="" value="draft" checked>Draft</label>
                    <?php
                }
                ?>
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
            <img src="../images/posts/<?php echo $objPost->postName . "/" . $objPost->postImage; ?>" alt="<?php echo $objPost->postImage; ?>" width="100px">
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
            <input type="text" value="<?php echo $objPost->tags; ?>" name="tags" class="form-control">
            <span>
                <?php
                if (isset($errors['tags'])) {
                    echo $errors['tags'];
                }
                ?>
            </span>
        </div>
        <div class="form-group">
            <label for="description">Post Content</label>
            <textarea name="description" class="form-control" id="" cols="30" rows="10"><?php echo $objPost->description; ?></textarea>
            <span>
                <?php
                if (isset($errors['description'])) {
                    echo $errors['description'];
                }
                ?>
            </span>
        </div>
        <div class="form-group">
            <input type="hidden" name="postID" value="<?php echo $objPost->postID; ?>" >
            <input type="submit" class="btn btn-primary" name="updatePost" value="Update Post">
        </div>
        <?php
    }
    ?>
</form>