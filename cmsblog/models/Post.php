<?php

require_once 'DBConnection.php';

class Post extends DBConnection {

    private $postID;
    private $postName;
    private $authorID;
    private $description;
    private $tags;
    private $commentCount;
    private $viewCount;
    private $postImage;
    private $postDate;
    private $cateogryID;
    private $status;

    public function __construct() {
        
    }

    public function __set($name, $value) {
        $method_name = "set$name";

        if (!method_exists($this, $method_name)) {
            throw new Exception("SET: $name Property not found");
        }

        $this->$method_name($value);
    }

    public function __get($name) {
        $method_name = "get$name";

        if (!method_exists($this, $method_name)) {
            throw new Exception("GET: $name Property not found");
        }

        return $this->$method_name();
    }

    private function setPostID($postID) {

        if (!is_numeric($postID) && $postID <= 0) {
            throw new Exception("Invalid/Missing postID");
        }
        $this->postID = $postID;
    }

    private function getPostID() {
        return $this->postID;
    }

    private function setPostName($postName) {
        $reg = "/^[A-Za-z0-9]+/i";
        if (!preg_match($reg, $postName)) {
            throw new Exception("Invalid/Missing Post Name");
        }

        $this->postName = $postName;
    }

    private function getPostName() {
        return $this->postName;
    }

    private function setAuthorID($authorID) {
        if (!is_numeric($authorID)) {
            throw new Exception("Missing Post author");
        }

        $this->authorID = $authorID;
    }

    private function getAuthorID() {
        return $this->authorID;
    }

    private function getPostDate() {
        return $this->postDate;
    }

    private function setDescription($description) {
        $reg = "/[A-Za-z0-9]+/";
        if (!preg_match($reg, $description)) {
            throw new Exception("Invalid/Missing Description");
        }
        $this->description = $description;
    }

    private function getDescription() {
        return $this->description;
    }

    private function setTags($tags) {
        $reg = "/[a-z]+(,| )/i";
        if (!preg_match($reg, $tags)) {
            throw new Exception("Invalid/Missing tags");
        }
        $this->tags = $tags;
    }

    private function getTags() {
        return $this->tags;
    }

    private function setCommentCount($commentCount) {
        if (!is_numeric($commentCount) && $commentCount <= 0) {
            throw new Exception("Invalid commentCount");
        }
        $this->commentCount = $commentCount;
    }

    private function getCommentCount() {
        return $this->commentCount;
    }

    private function setViewCount($viewCount) {
        if (!is_numeric($viewCount) && $viewCount <= 0) {
            throw new Exception("Invalid viewCount");
        }
        $this->viewCount = $viewCount;
    }

    private function getViewCount() {
        return $this->viewCount;
    }

    private function setStatus($status) {
        $reg = "/^[a-z]+/";
        if (!preg_match($reg, $status)) {
            throw new Exception("Invalid/Missing status");
        }

        $this->status = $status;
    }

    private function getStatus() {
        return $this->status;
    }

    private function setCategoryID($categoryID) {

        if (!is_numeric($categoryID)) {
            throw new Exception("Invalid/Missing category id");
        }

        $this->cateogryID = $categoryID;
    }

    private function getCategoryID() {
        return $this->cateogryID;
    }

    private function setPostImage($postImage) {
        if ($postImage['error'] == 4) {
            throw new Exception("File Missing");
        }
        $imageData = getimagesize($postImage['tmp_name']);
        if (!$imageData) {
            throw new Exception("Invalid Image Format");
        }
        if ($postImage['size'] > 5000000) {
            throw new Exception("Max File size allowed is 5M");
        }
        if ($postImage['type'] != 'image/png') {
            throw new Exception("Only png allowed");
        }
        if ($postImage['type'] != $imageData['mime']) {
            throw new Exception("Corrupt Image");
        }
        if (is_null($this->postName)) {
            throw new Exception("Failed to generate file name");
        }
        $this->postImage = "$this->postName" . time() . ".png";
    }

    private function getPostImage() {
        return $this->postImage;
    }

    public function addPost() {
        $objDB = $this->objDB();

        $queryInsert = "INSERT INTO `posts` "
                . "(`postID`, `categoryID`, `postName`, `authorID`, `postDate`, "
                . "`postImage`, `description`, `tags`, `commentCount`, `status`, "
                . "`viewCount`) "
                . "VALUES "
                . "(NULL, '$this->cateogryID', '$this->postName', '$this->authorID', "
                . "now(), '$this->postImage', '$this->description', '$this->tags', "
                . "'$this->commentCount', '$this->status', '$this->viewCount'); ";

        $result = $objDB->query($queryInsert);

        if ($objDB->errno) {
            throw new Exception("Failed to insert Post");
        }

        $this->postID = $objDB->insert_id;
    }

    public function uploadPostImage($sourceFile) {
        $strPath = $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts/$this->postName/$this->postImage";

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts")) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts")) {
                throw new Exception("Failed to creater folder" . $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts");
            }
        }

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts/$this->postName")) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts/$this->postName")) {
                throw new Exception("Failed to create folder" . $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/posts/$this->postName");
            }
        }

        $result = @move_uploaded_file($sourceFile, $strPath);

        if (!$result) {
            throw new Exception("Failed to upload file");
        }
    }

    public static function getPosts($status = null, $postOrder = 'DESC', $start = -1, $perPage = 0, $catID = 0, $authorID = null, $search = null) {
        $objDB = self::objDB();

        $querySelect = "SELECT * FROM posts ";

        if (isset($status)) {
            $querySelect .= " WHERE status = '$status' ";
        }
        if ($catID > 0) {
            $querySelect .= " and categoryID = {$catID} ";
        }
        if ($authorID > 0) {
            $querySelect .= " and authorID = {$authorID} ";
        }
        if (isset($search)) {
            $querySelect .= " and tags LIKE '%{$search}%' ";
        }
        if (isset($postOrder)) {
            $querySelect .= " ORDER BY postID {$postOrder} ";
        }
        if ($start > -1 && $perPage > 0) {
            $querySelect .= " LIMIT {$start}, {$perPage} ";
        }

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to get posts - $objDB->error - $objDB->errno");
        }
        if (!$result->num_rows) {
            throw new Exception("Post(s) not Found");
        }

        $posts = array();

        while ($data = $result->fetch_object()) {
            $temp = new Post();
            $temp->postID = $data->postID;
            $temp->postName = $data->postName;
            $temp->authorID = $data->authorID;
            $temp->description = $data->description;
            $temp->postDate = $data->postDate;
            $temp->tags = $data->tags;
            $temp->commentCount = $data->commentCount;
            $temp->viewCount = $data->viewCount;
            $temp->postImage = $data->postImage;
            $temp->status = $data->status;
            $temp->categoryID = $data->categoryID;
            $posts[] = $temp;
        }
        return $posts;
    }

    public function getPost($status = NULL) {
        $objDB = $this->objDB();

        $querySelect = "SELECT * FROM posts "
                . "WHERE postID='$this->postID' ";

        if (isset($status)) {
            $querySelect .= " and status = '$status' ";
        }

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to get post - $objDB->error - $objDB->errno");
        }
        if (!$result->num_rows) {
            throw new Exception("No record found against - post_id: $this->postID");
        }


        $data = $result->fetch_object();

        $this->postID = $data->postID;
        $this->postName = $data->postName;
        $this->description = $data->description;
        $this->authorID = $data->authorID;
        $this->postDate = $data->postDate;
        $this->tags = $data->tags;
        $this->commentCount = $data->commentCount;
        $this->viewCount = $data->viewCount;
        $this->postImage = $data->postImage;
        $this->status = $data->status;
        $this->categoryID = $data->categoryID;


        $queryUpdate = "UPDATE posts "
                . "SET viewCount = viewCount + 1 "
                . "WHERE postID = $this->postID ";

        $objDB->query($queryUpdate);
    }

    public function updatePost() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE posts "
                . "SET postName='$this->postName', description='$this->description', "
                . "authorID = '$this->authorID', tags='$this->tags', "
                . "postImage='$this->postImage', "
                . "status='$this->status', categoryID='$this->cateogryID' "
                . "WHERE postID='$this->postID' ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Failed to update Post");
        }
    }

    public function deletePost() {
        $objDB = $this->objDB();

        $queryDelete = "DELETE FROM posts WHERE postID = $this->postID ";

        $resutl = $objDB->query($queryDelete);

        if ($objDB->errno) {
            throw new Exception("Failed to delete Post");
        }
    }

    public static function pageination($itemPerPage = 4, $catID = 0, $authorID = 0, $search = null) {
        $objDB = self::objDB();

        $querySelect = "select count(*) 'count'  from posts where status = 'published' ";

        if ($catID > 0) {
            $querySelect .= " and categoryID = $catID ";
        }
        if ($authorID > 0) {
            $querySelect .= " and authorID = $authorID ";
        }
        if (isset($search)) {
            $querySelect .= " and tags LIKE '%{$search}%' ";
        }


        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to Get Posts Count - $objDB->error - $objDB->errno");
        }

        if (!$result->num_rows) {
            throw new Exception("Post(s) not Found");
        }

        $data = $result->fetch_object();

        $totalItems = $data->count;
        $totalPages = ceil($totalItems / $itemPerPage);

        $pNums = array();

        for ($i = 1, $j = 0; $i <= $totalPages; $i++, $j += $itemPerPage) {
            $pNums[$i] = $j;
        }

        return $pNums;
    }

    public static function postCount($post_status = NULL, $post_cat_id = 0, $post_author_id = 0, $search = null) {
        $objDB = self::objDB();

        $query_select = "SELECT count(*) 'count' FROM posts ";

        if (isset($post_status)) {
            $query_select .= " WHERE status = '$post_status' ";
        }
        if ($post_cat_id > 0) {
            $query_select .= " and categoryID = '{$post_cat_id}' ";
        }
        if ($post_author_id > 0) {
            $query_select .= " and authorID = {$post_author_id} ";
        }
        if (isset($search)) {
            $query_select .= " and tags LIKE '%$search%' ";
        }

        $result = $objDB->query($query_select);
        $data = $result->fetch_object();
        $post_count = $data->count;

        return $post_count;
    }

    public function bulkPost($bulk_option = NULL, $postValueID) {
        $objDB = $this->objDB();

        switch ($bulk_option) {
            case 'published' :
                $query_update = "UPDATE posts SET status = '{$bulk_option}' WHERE postID = {$postValueID} ";
                $update_to_published = $objDB->query($query_update);

                if ($objDB->errno) {
                    die("Query Failed! - $objDB->errno - $objDB->error ");
                }

                break;

            case 'draft' :
                $query_update = "UPDATE posts SET status = '{$bulk_option}' WHERE postID = {$postValueID} ";
                $update_to_draft = $objDB->query($query_update);

                if ($objDB->errno) {
                    die("Query Failed! - $objDB->errno - $objDB->error ");
                }

                break;

            case 'delete' :
                $this->postID = $postValueID;
                $this->deletePost();

                break;

            case 'clone' :
                $this->postID = $postValueID;
                $this->getPost();
                $this->addPost();

                break;
        }// switch end
    }

    // reset post views
    public function resetPostViews() {
        $objDB = $this->objDB();

        $query_update = "UPDATE posts "
                . "SET viewCount = 0 "
                . "WHERE postID = {$this->postID} ";

        $objDB->query($query_update);

        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->error ");
        }
    }

}
