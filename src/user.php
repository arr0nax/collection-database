<?php
    class User {
        private $username;
        private $password;


        function __construct($username, $password, $id = null)
        {
            $this->username = $username;
            $this->password = $password;
            $this->id = $id;
        }

        function setusername($username)
        {
            $this->username = (string) $username;
        }

        function getusername()
        {
            return $this->username;
        }

        function setpassword($password)
        {
            $this->password = (string) $password;
        }

        function getpassword()
        {
            return $this->password;
        }

        function setid($id)
        {
            $this->id = $id;
        }

        function getid()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO user_table (username, password) values ('{$this->getusername()}', '{$this->getpassword()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function signIn($username, $password) {
            $returned_combo = $GLOBALS['DB']->query("SELECT * FROM user_table where username = '{$username}';");
            foreach ($returned_combo as $current) {
                $current_username = $current['username'];
                $current_password = $current['password'];
                $id = $current['id'];
                $new_user = new User($current_username, $current_password, $id);
                if ($current_username == $username && $current_password == $password) {
                    return true;
                }
                else {
                    return false;
                }
            }
        }

    }


 ?>
