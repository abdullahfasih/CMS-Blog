
<form action="process/processPost.php" method="post">
    <table class="table table-bordered table-hover table-responsive">
        <div id="bulkOptionContainer" class="col-xs-4">
            <select name="bulkOption" id="" class="form-control">
                <option value="">Select an option</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <input type="submit" class="btn btn-success" value="Apply"> 
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a> 
        </div>
        <thead>
            <tr>
                <th><input type="checkbox" name="" id="checkAllBoxes"></th>
                <th>ID</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Post Views</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $posts = Post::getPosts();
                foreach ($posts as $p) {
                    echo "<tr>
                            <td>
                                <input type='checkbox' name='checkBoxArray[]' value='$p->postID' class='checkBoxes'> </td>
                            <td>$p->postID</td>";

                    echo "<td>";

                    try {
                        $objAuthor = new User();
                        $objAuthor->getUser($p->authorID);
                        echo $objAuthor->userName;
                    } catch (Exception $ex) {
                        echo "Author not found!";
                    }

                    echo "</td>
                         <td>$p->postName</td>
                         <td>";

                    try {
                        $objCat = new Category();
                        $objCat->categoryID = $p->categoryID;
                        $objCat->getCategory();
                        echo $objCat->categoryName;
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }

                    echo "</td>
                          <td>$p->status</td>
                          <td><img src = '../images/posts/$p->postName/$p->postImage' alt = '$p->postImage' width = '100px'></td>
                          <td>$p->tags</td>";

                    $commentCount = Comment::commentCount(null, $p->postID);

                    echo "<td><a href = 'post_comments.php?id=$p->postID'>$commentCount</a></td>
                        <td>$p->postDate</td>
                        <td><a href = '../post.php?post_id=$p->postID'>View Post</a></td>
                        <td><a href = 'posts.php?source=edit_post&post_id=$p->postID'>Edit</a></td>
                        <td><a href = 'process/processPost.php?delete=$p->postID'>Delete</a></td>
                        <td><a href = 'process/processPost.php?reset=$p->postID'>$p->viewCount</a></td>
                        </tr>";
                }
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            ?>
        </tbody>
    </table>
</form>