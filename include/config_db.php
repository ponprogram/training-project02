<?php
    class dbh{
        protected function connect(){
            $this->servername   = "localhost";
            $this->username     = "id15707954_ponprogram001";
            $this->password     = "P@ssw0rd1Qazxsw2";
            $this->dbname       = "id15707954_db_test";

            $conn = mysqli_connect( $this->servername,$this->username,$this->password, $this->dbname);
            mysqli_set_charset($conn, "utf8");
            return $conn;
        }
    }
?>