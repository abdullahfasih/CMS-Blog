<?php

require_once 'DBConnection.php';

class Comment extends DBConnection {

    private $commentID;
    private $postID;
    private $author;
    private $description;
    private $email;
    private $status;
    private $commentDate;

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

    private function setCommentID($commentID) {

        if (!is_numeric($commentID) && $commentID <= 0) {
            throw new Exception("Invalid/Missing commentID");
        }
        $this->commentID = $commentID;
    }

    private function getCommentID() {
        return $this->commentID;
    }

    private function setAuthor($author) {
        $reg = "/^[A-Za-z]+/i";
        if (!preg_match($reg, $author)) {
            throw new Exception("Invalid/Missing Comment Name");
        }

        $this->author = $author;
    }

    private function getAuthor() {
        return $this->author;
    }

    private function setPostID($postID) {
        if (!is_numeric($postID) && $postID <= 0) {
            throw new Exception("Missing Post id");
        }

        $this->postID = $postID;
    }

    private function getPostID() {
        return $this->postID;
    }

    private function setDescription($description) {
        $reg = "/^[A-Za-z0-9]+/i";
        if (!preg_match($reg, $description)) {
            throw new Exception("Invalid/Missing Description");
        }
        $this->description = $description;
    }

    private function getDescription() {
        return $this->description;
    }

    private function setEmail($email) {
        $reg = "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zAZ]\.)+[a-zA-Z]{2,4})$/";

        if (!preg_match($reg, $email)) {
            throw new Exception("Invalid/Missing Email");
        }

        $this->email = $email;
    }

    private function getEmail() {
        return $this->email;
    }

    private function setStatus($status) {

        if ($status != 'approved' && $status != 'unapproved') {
            throw new Exception("Invalid/Missing status");
        }

        $this->status = $status;
    }

    private function getStatus() {
        return $this->status;
    }

    // readonly property
    private function getCommentDate() {
        return $this->commentDate;
    }

    public function addComment() {
        $objDB = $this->objDB();

        $queryInsert = "INSERT INTO `comments` "
                . "(`commentID`, `description`, `author`, `email`, "
                . "`commentDate`, `status`, `postID`) "
                . "VALUES "
                . "(NULL, '$this->description', '$this->author', '$this->email', "
                . "now(), 'unapproved', '$this->postID') ";

        $result = $objDB->query($queryInsert);

        if ($objDB->errno) {
            throw new Exception("Failed to insert Comment");
        }
    }

    public static function getComments($status = null, $postID = 0) {
        $objDB = self::objDB();

        $querySelect = "SELECT * FROM comments ";

        if (isset($status)) {
            $querySelect .= " WHERE status = '$status' ";
        } elseif ($postID > 0) {
            $querySelect .= " WHERE postID = $postID";
        }
        if (isset($status) && $postID > 0) {
            $querySelect = "SELECT * FROM comments WHERE postID = $postID and status = 'approved' ";
        }

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to get comments - $objDB->error - $objDB->errno");
        }
        if (!$result->num_rows) {
            throw new Exception("Comment(s) not Found");
        }

        $comments = array();

        while ($data = $result->fetch_object()) {
            $temp = new Comment();
            $temp->commentID = $data->commentID;
            $temp->author = $data->author;
            $temp->description = $data->description;
            $temp->commentDate = $data->commentDate;
            $temp->email = $data->email;
            $temp->status = $data->status;
            $temp->postID = $data->postID;
            $comments[] = $temp;
        }
        return $comments;
    }

    public function updateComment() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE comments "
                . "SET status='$this->status' "
                . "WHERE commentID='$this->commentID' ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Failed to update Comment - $objDB->errno - $objDB->error");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("No comment updated!");
        }
    }

    public function deleteComment() {
        $objDB = $this->objDB();

        $queryDelete = "DELETE FROM comments "
                . "WHERE commentID = $this->commentID ";

        $result = $objDB->query($queryDelete);
        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->error");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("No comment deleted!");
        }
    }

    public static function commentCount($comment_status = NULL, $post_id = 0) {
        $objDB = self::objDB();

        $query_select = "SELECT count(*) 'count' FROM comments";

        if (isset($comment_status)) {
            $query_select .= " WHERE status = '$comment_status' ";
        } elseif ($post_id > 0) {
            $query_select .= " WHERE postID = {$post_id}";
        }

        $result = $objDB->query($query_select);

        if ($objDB->errno) {
            throw new Exception("Failed to get CommentCount");
        }

        if (!$result) {
            throw new Exception("No CommentCount Found");
        }

        $data = $result->fetch_object();
        $comment_count = $data->count;

        return $comment_count;
    }

}
