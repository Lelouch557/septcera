<?php
session_start();
require_once("Database.backend");
class map_Controller extends Database{
    function getMap(){
        $sql = "SELECT * FROM `cells` LEFT JOIN village Using(Cell_ID)";
        return
        parent::custom(
            $sql,
            [],
            true
        );
    }
    function newFort($id){
        parent::custom("INSERT INTO storage (`Timestamp`) VALUES(:ts)",
            [
                ':ts' => time()
            ],false
        );
        $storage_id = parent::lastid();
        $nam = $_SESSION['User_Name']."'s ".$id;
        parent::custom(
            "INSERT into village (class, Cell_ID, storage_id,`Name`) VALUES(:class,:cell,:storage,:nam)",
            [
                ':class' => 1,
                ':cell' => $id,
                ':storage' => $storage_id,
                ':nam' => $nam
            ]
        );
        $village_id = parent::lastid();
        parent::custom(
            "INSERT into user_village (`user_id`, village_id) VALUES(:u_id,:vid)",
            [
                ':u_id' => $_SESSION['User_ID'],
                ':vid' => $village_id
            ]
        );
    }
    
    function newVillage($id){
        parent::custom("INSERT INTO storage (`Timestamp`) VALUES(:ts)",
            [
                ':ts' => time()
            ],false
        );
        $storage_id = parent::lastid();
        parent::custom("INSERT INTO resource_storage (`resource_id`,storage_id,increment,`time_stamp`) VALUES(:r_id,:s_id,:increment,:ts)",
            [
                ':r_id'=> 3,
                ':s_id' => $storage_id,
                ':increment' => 100,
                ':ts' => time()
            ],false
        );
        $nam = $_SESSION['User_Name']."'s ".$id;
        parent::custom(
            "INSERT into village (Cell_ID, storage_id,`Name`) VALUES(:cell,:storage,:nam)",
            [
                ':cell' => $id,
                ':storage' => $storage_id,
                ':nam' => $nam
            ]
        );
        $village_id = parent::lastid();
        parent::custom(
            "INSERT into user_village (`user_id`, village_id) VALUES(:u_id,:vid)",
            [
                ':u_id' => $_SESSION['User_ID'],
                ':vid' => $village_id
            ]
        );
    }
}