<?php

require_once 'DBConnection.php';

class User extends DBConnection {

    private $userID;
    private $firstName;
    private $lastName;
    private $email;
    private $userName;
    private $password;
    private $profileImage;
    private $isActive;
    private $userRole;
    private $loginStatus;

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

    private function setUserID($userID) {

        if (!is_numeric($userID) || $userID <= 0) {
            throw new Exception("Invalid/Missing userID");
        }
        $this->userID = $userID;
    }

    private function getUserID() {
        return $this->userID;
    }

    private function setFirstName($firstName) {
        $reg = "/^[a-z]+$/i";

        if (!preg_match($reg, $firstName)) {
            throw new Exception("Invalid/Missing First Name");
        }

        $this->firstName = $firstName;
    }

    private function getFirstName() {
        return $this->firstName;
    }

    private function setLastName($lastName) {
        $reg = "/^[a-z]+$/i";

        if (!preg_match($reg, $lastName)) {
            throw new Exception("Invalid/Missing Last Name");
        }

        $this->lastName = $lastName;
    }

    private function getLastName() {
        return $this->lastName;
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

    private function setUserName($userName) {
        $reg = "/^[a-z0-9]{5,19}$/i";

        if (!preg_match($reg, $userName)) {
            throw new Exception("Invaid/Missing User Name");
        }

        $this->userName = $userName;
    }

    private function getUserName() {
        return $this->userName;
    }

    private function setPassword($password) {
        $reg = "/^[a-z0-9]{5,15}$/i";

        if (!preg_match($reg, $password)) {
            throw new Exception("Invalid/Short Password");
        }

        $this->password = sha1($password);
    }

    private function getPassword() {
        return $this->password;
    }

    private function setUserRole($userRole) {
        if ($userRole != 'admin' && $userRole != 'subscriber') {
            throw new Exception("Invalid/Missing userRole");
        }
        $this->userRole = $userRole;
    }

    private function getUserRole() {
        return $this->userRole;
    }

    private function setProfileImage($profileImage) {
        if ($profileImage['error'] == 4) {
            throw new Exception("File Missing");
        }

        $imageData = getimagesize($profileImage['tmp_name']);

//        echo "<pre>";
//        print_r($profileImage);
//        echo "</pre><br><br>";
//
//        echo "<pre>";
//        print_r($imageData);
//        echo "</pre>";
//        die;

        if (!$imageData) {
            throw new Exception("Invalid Image Format");
        }
        if ($profileImage['size'] > 500000) {
            throw new Exception("Max File size allowed is 500KB");
        }
        if ($profileImage['type'] != 'image/jpeg') {
            throw new Exception("Only jpeg allowed");
        }
        if ($profileImage['type'] != $imageData['mime']) {
            throw new Exception("Corrupt Image");
        }
        if (is_null($this->userName)) {
            throw new Exception("Failed to generate file name");
        }
        $this->profileImage = "$this->userName.jpg";
    }

    private function getProfileImage() {
        return $this->profileImage;
    }

    private function getIsActive() {
        return $this->isActive;
    }

    public function checkUserByUsername() {
        // checking username in db
        $objDB = $this->objDB();
        $querySelect = "SELECT * FROM users where username = '$this->userName' ";

        $result = $objDB->query($querySelect);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUserByEmail() {
        // checking username in db
        $objDB = $this->objDB();
        $querySelect = "SELECT * FROM users where email = '$this->email' ";

        $result = $objDB->query($querySelect);

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser() {
        $objDB = $this->objDB();

        $query = "INSERT INTO `users` "
                . "(`userID`, `firstName`, `lastName`, `email`, `userName`, "
                . "`password`, `userRole`) "
                . "VALUES "
                . "(NULL, '$this->firstName', '$this->lastName', '$this->email', '$this->userName', "
                . "'$this->password', '$this->userRole') ";

        $result = $objDB->query($query);

        if ($objDB->errno) {
            throw new Exception("Failed to insert User - $objDB->error - $objDB->errno");
        }

        $this->userID = $objDB->insert_id;
    }

    public function login($remember) {
        $objDB = $this->objDB();

        $querySelect = "SELECT loginFailedTime FROM users WHERE userName = '$this->userName' ";
        $result = $objDB->query($querySelect);
        $data = $result->fetch_object();

        $now = time() - (60*5);
//        echo "<br>";
//        echo $data->loginFailedTime;
//        die;
        if ($data->loginFailedTime > $now) {
            throw new Exception("Account temporary blocked, try again few minutes later.");
        }

        $querySelect = "SELECT userID, firstName, lastName, userRole, email, isActive "
                . "FROM users "
                . "WHERE userName = '$this->userName' "
                . "AND password = '$this->password'";

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to Get Login User - $objDB->error - $objDB->errno");
        }

        if (!$result->num_rows) {
            if ($this->loginFailed()) {
//                throw new Exception("Account temporary blocked, try again few minutes later.");
            } else {
                throw new Exception("Login Failed");
            }
        }

        $data = $result->fetch_object();


        if (!$data->isActive) {
            throw new Exception("Your account is pending activation!");
        }

        $this->userID = $data->userID;
        $this->userRole = $data->userRole;
        $this->email = $data->email;
        $this->password = NULL;
        $this->loginStatus = TRUE;

        $strUser = serialize($this);
        $_SESSION['objUser'] = $strUser;

        if ($remember) {
            $expire = time() + (60 * 60 * 24 * 3);
            setcookie("objUser", $strUser, $expire, "/");
        }

        $queryUpdate = "UPDATE users SET loginFailedTime = 0, loginAttempt = 0 WHERE userName = '$this->username' ";
        $objDB->query($queryUpdate);
    }

    public function loginFailed() {
        $objDB = $this->objDB();
        $querySelect = "SELECT loginAttempt FROM users WHERE userName = '$this->userName' ";
        $result = $objDB->query($querySelect);
        $data = $result->fetch_object();

        if ($data->loginAttempt == 5) {
            $queryUpdate = "UPDATE users SET loginFailedTime = " . time() . " WHERE userName = '$this->userName' ";
            $objDB->query($queryUpdate);
            return true;
        } else {
            $queryUpdate = "UPDATE users SET loginAttempt = loginAttempt + 1 WHERE userName = '$this->userName' ";
            $objDB->query($queryUpdate);
            return false;
        }
    }

    public function logout() {
        if (isset($_SESSION['objUser'])) {
            unset($_SESSION['objUser']);
        }
        if (isset($_COOKIE['objUser'])) {
            setcookie("objUser", "", 1, "/");
        }
    }

    public function getProfileData() {
        $objDB = $this->objDB();

        $querySelect = "SELECT * FROM users where userID = $this->userID";

        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to Get Profile Data - $objDB->error - $objDB->errno");
        }

        if (!$result->num_rows) {
            throw new Exception("No Profile data Found");
        }

        $data = $result->fetch_object();

        $this->userID = $data->userID;
        $this->userName = $data->userName;
        $this->firstName = $data->firstName;
        $this->lastName = $data->lastName;
        $this->userRole = $data->userRole;
        $this->email = $data->email;
        $this->profileImage = $data->profileImage;
        $this->password = NULL;
        $this->loginStatus = TRUE;
    }

    public function getUser($userID) {
        $objDB = $this->objDB();

        $querySelect = "SELECT * FROM users WHERE userID = $userID ";


        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to Get Profile Data - $objDB->error - $objDB->errno");
        }

        if (!$result->num_rows) {
            throw new Exception("No Profile data Found");
        }

        $data = $result->fetch_object();

        $this->userID = $data->userID;
        $this->userName = $data->userName;
        $this->firstName = $data->firstName;
        $this->lastName = $data->lastName;
        $this->userRole = $data->userRole;
        $this->email = $data->email;
    }

    public static function getUsers() {
        $objDB = self::objDB();

        $querySelect = "SELECT * FROM users ";


        $result = $objDB->query($querySelect);

        if ($objDB->errno) {
            throw new Exception("Failed to Get User Data - $objDB->error - $objDB->errno");
        }

        if (!$result->num_rows) {
            throw new Exception("User(s) not Founds!");
        }

        $users = array();
        while ($data = $result->fetch_object()) {
            $temp = new User();
            $temp->userID = $data->userID;
            $temp->userName = $data->userName;
            $temp->firstName = $data->firstName;
            $temp->lastName = $data->lastName;
            $temp->userRole = $data->userRole;
            $temp->email = $data->email;
            $temp->isActive = $data->isActive;
            $users[] = $temp;
        }
        return $users;
    }

    public function changeStatus($status) {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE users "
                . "SET isActive = '$status' "
                . "WHERE userID = $this->userID ";

        $result = $objDB->query($queryUpdate);
        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->error - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Failed to update status");
        }
    }

    public function deleteUser() {
        $objDB = $this->objDB();

        $queryDelete = "DELETE FROM users "
                . "WHERE userID = $this->userID ";

        $result = $objDB->query($queryDelete);

        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Failed to delete user!");
        }
    }

    public function updateAdmin() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE users "
                . "SET userRole = '$this->userRole' "
                . "WHERE userID = $this->userID ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Failed to update user!");
        }
    }

    public function updateUser() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE users "
                . "SET firstName = '$this->firstName', "
                . "lastName = '$this->lastName', "
                . "userRole = '$this->userRole', "
                . "email = '$this->email', "
                . "password = '$this->password' "
                . "WHERE userID = $this->userID ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Failed to update user!");
        }
    }

    public function updateUserProfileData() {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE users "
                . "SET firstName = '$this->firstName', "
                . "lastName = '$this->lastName' "
                . "WHERE userID = $this->userID and username='$this->userName' ";

        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Query Failed! - $objDB->errno - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Failed to update user!");
        }
        $_SESSION['objUser'] = serialize($this);
    }

    public function uploadProfileImage($sourceFile) {
        $strPath = $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users/$this->userName/$this->profileImage";

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users")) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users")) {
                throw new Exception("Failed to creater folder" . $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users");
            }
        }

        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users/$this->userName")) {
            if (!mkdir($_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users/$this->userName")) {
                throw new Exception("Failed to create folder" . $_SERVER['DOCUMENT_ROOT'] . "/project/cmsblog/images/users/$this->userName");
            }
        }

        // @move_uploaded_file - move file to the destination path, param(source, destination)
        $result = @move_uploaded_file($sourceFile, $strPath);

        if (!$result) {
            throw new Exception("Failed to upload file");
        }

        $this->getProfileData();
    }

    public static function comparePasswords($password1, $password2) {
        if (empty($password2)) {
            throw new Exception("Missing password");
        }

        if ($password1 != $password2) {
            throw new Exception("Mismatched password");
        }
    }

    public function changeForgotPassword($resetCode) {
        $objDB = $this->objDB();

        $queryUpdate = "UPDATE users "
                . "SET password = '$this->password' "
                . "WHERE userID = '$this->userID' ";


        $result = $objDB->query($queryUpdate);

        if ($objDB->errno) {
            throw new Exception("Failed to update query - $objDB->error - $objDB->errno");
        }
        if (!$objDB->affected_rows) {
            throw new Exception("Password did not updated");
        }
    }

    public static function userCount($user_role = NULL) {
        $objDB = self::objDB();

        $query_select = "SELECT count(*) 'count' FROM users";

        if (isset($user_role)) {
            $query_select .= " WHERE userRole = '$user_role' ";
        }

        $result = $objDB->query($query_select);
        $data = $result->fetch_object();
        $user_count = $data->count;

        return $user_count;
    }

    //read-only properties
    private function getLogin() {
        return $this->loginStatus;
    }

}
