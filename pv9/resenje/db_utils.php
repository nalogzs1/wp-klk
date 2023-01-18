<?php
require_once("constants.php");

class Database
{
    private $hashing_salt = "dsaf7493^&$(#@Kjh";

    private $conn;

    public function __construct($configFile = "config.ini")
    {
        if ($config = parse_ini_file($configFile)) {
            $host = $config["host"];
            $database = $config["database"];
            $user = $config["user"];
            $password = $config["password"];
            $this->conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function __destruct()
    {
        $this->conn = null;
    }

    function insertUser($username, $password, $name, $profession, $address, $birthday, $gender)
    {
        try {
            $sql_existing_user = "SELECT * FROM " . TBL_USER . " WHERE " . COL_USER_USERNAME . "= :username";
            $st = $this->conn->prepare($sql_existing_user);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            if ($st->fetch()) {
                return false;
            }
            
            $hashed_password = crypt($password, $this->hashing_salt);
            $avatar = $gender == "z" ? "images/avatar_female.png" : "images/avatar_male.png";

            $sql_insert = "INSERT INTO " . TBL_USER . " (".COL_USER_USERNAME.","
                                                          .COL_USER_PASSWORD.","
                                                          .COL_USER_NAME.","
                                                          .COL_USER_AVATAR.","
                                                          .COL_USER_PROFESSION.","
                                                          .COL_USER_ADDRESS.","
                                                          .COL_USER_BIRTHDAY.","
                                                          .COL_USER_GENDER.")"
                        ." VALUES (:username, :password, :name, :avatar, :profession, :address, :birthday, :gender)";

            $st = $this->conn->prepare($sql_insert);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("password", $hashed_password, PDO::PARAM_STR);
            $st->bindValue("name", $name, PDO::PARAM_STR);
            $st->bindValue("avatar", $avatar, PDO::PARAM_STR);
            $st->bindValue("profession", $profession, PDO::PARAM_STR);
            $st->bindValue("address", $address, PDO::PARAM_STR);
            $st->bindValue("birthday", $birthday, PDO::PARAM_STR);
            $st->bindValue("gender", $gender, PDO::PARAM_STR);
            
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getPosts($userId)
    {
        try {
            $sql = "SELECT * FROM " . TBL_POST . " WHERE " . COL_POST_USERID . "=:user";
            $st = $this->conn->prepare($sql);
            $st->bindValue("user", $userId, PDO::PARAM_INT);
            $st->execute();
            return $st->fetchAll();
        } catch (PDOException $e) {
            return array();
        }
    }

    public function checkLogin($username, $password)
    {
        try {
            $hashed_password = crypt($password, $this->hashing_salt);
            $sql = "SELECT * FROM " . TBL_USER . " WHERE " . COL_USER_USERNAME . "=:username and " . COL_USER_PASSWORD . "=:password";
            $st = $this->conn->prepare($sql);
            $st->bindValue("username", $username, PDO::PARAM_STR);
            $st->bindValue("password", $hashed_password, PDO::PARAM_STR);
            $st->execute();
            return $st->fetch();
        } catch (PDOException $e) {
            return null;
        }
    }

    public function insertPost($content, $userId)
    {
        try {
            $sql = "INSERT INTO " . TBL_POST . " (".COL_POST_TIME.","
                                                          .COL_POST_CONTENT.","
                                                          .COL_POST_USERID.")"
                          ."VALUES (:time, :content, :userId)";
            
            $time = date("d.m.Y H:i:s");
            
            $st = $this->conn->prepare($sql);
            $st->bindValue("time", $time, PDO::PARAM_STR);
            $st->bindValue("content", $content, PDO::PARAM_STR);
            $st->bindValue("userId", $userId, PDO::PARAM_INT);
            return $st->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

}