<?php

abstract class DBConnection {

    protected function objDB() {

        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "cmsblog";

        $objDB = new mysqli();
        $objDB->connect($host, $user, $password);

        if ($objDB->connect_errno) {
            throw new Exception("Failed to connect host - $objDB->connect_error - $objDB->connect_errno");
        }
        $objDB->select_db($database);

        if ($objDB->errno) {
            throw new Exception("Failed to select Database - $objDB->error - $objDB->errno");
        }

        return $objDB;
    }

}
