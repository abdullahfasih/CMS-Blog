<?php

require_once 'DBConnection.php';

class Category extends DBConnection {

    private $categoryID;
    private $categoryName;

    public function __construct() {
        
    }

    public function __set($name, $value) {
        $method_name = "set$name";

        if (!method_exists($this, $method_name)) {
            throw new Exception("SET: $name property not found");
        }

        $this->$method_name($value);
    }

    public function __get($name) {
        $method_name = "get$name";

        if (!method_exists($this, $method_name)) {
            throw new Exception("GET: $name property not found");
        }

        return $this->$method_name();
    }

    private function setCategoryID($categoryID) {

        if (!is_numeric($categoryID) && $categoryID <= 0) {
            throw new Exception("Invalid/Missing categoryID");
        }

        $this->categoryID = $categoryID;
    }

    private function getCategoryID() {
        return $this->categoryID;
    }

    private function setCategoryName($categoryName) {
        $reg = "/[A-Za-z]+/";

        if (!preg_match($reg, $categoryName)) {
            throw new Exception("Invalid/Missing categoryName");
        }

        $this->categoryName = $categoryName;
    }

    private function getCategoryName() {
        return $this->categoryName;
    }

    public function addCat() {
        $objDB = $this->objDB();

        $queryInsert = "INSERT INTO `categories` "
                . "(`CategoryId`, `CategoryName`) "
                . "VALUES "
                . "(NULL, '$this->categoryName') ";

        $result = $objDB->query($queryInsert);

        if ($objDB->errno) {
            throw new Exception("Failed to insert category - $objDB->error - $objDB->errno");
        }

        $this->categoryID = $objDB->insert_id;
    }

    public static function getCats() {
        $objDB = self::objDB();

        $querySelect = "SELECT * FROM categories ";

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to get category - $objDB->error - $objDB->errno");
        }
        if (!$result->num_rows) {
            throw new Exception("Category(s) not Found");
        }

        $cats = array();

        while ($data = $result->fetch_object()) {
            $temp = new Category();
            $temp->categoryID = $data->categoryID;
            $temp->categoryName = $data->categoryName;
            $cats[] = $temp;
        }
        return $cats;
    }

    public function getCategory() {
        $objDB = $this->objDB();

        $querySelect = "SELECT * FROM categories where categoryID = $this->categoryID ";

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to get category - $objDB->error - $objDB->errno");
        }
        if (!$result->num_rows) {
            throw new Exception("Category not Found");
        }

        $data = $result->fetch_object();
        $this->categoryName = $data->categoryName;
    }

    public function deleteCat() {
        $objDB = $this->objDB();

        $queryDelete = "DELETE FROM categories "
                . "WHERE categoryID='$this->categoryID' ";

        $result = $objDB->query($queryDelete);

        if ($objDB->errno) {
            throw new Exception("Failed to delete category");
        }

        if (!$objDB->affected_rows) {
            throw new Exception("No record deleted");
        }
    }

    public function updateCat() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE categories "
                . "SET categoryName='$this->categoryName' "
                . "WHERE categoryID='$this->categoryID' ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Failed to update category");
        }
    }

    public static function categoryCount() {
        $objDB = self::objDB();

        $query_select = "SELECT count(*) 'count' FROM categories";

        $result = $objDB->query($query_select);
        $data = $result->fetch_object();
        $category_count = $data->count;

        return $category_count;
    }

}
