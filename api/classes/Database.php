<?php
class Database{
    public $conn;
    private $host = "localhost",$db = "assetmis",$user="super",$password="";
    public function getInstance(){
        try{
            $this->conn= new PDO("mysql:host=".$this->host.";dbname=".$this->db, $this->user,$this->password);
//            echo "Connected successful";
        }catch (PDOException $exc){
            echo "failed to connect".$exc->getMessage();
        }
        return $this->conn;
    }
}


?>