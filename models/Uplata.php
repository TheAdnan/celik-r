<?php
/**
 * Created by PhpStorm.
 * User: adnan
 * Date: 9/29/17
 * Time: 11:20 AM
 */

class Uplata{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function get($id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM uplata WHERE id=:id LIMIT 1");
            $stmt->execute(array(':id'=>$id));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                return $user;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function getAll(){
        try{
            $stmt = $this->db->prepare("SELECT * FROM uplata");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                return $users;
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function pay($user_id, $datum = null){
        if(is_null($datum)){
            $mjesec = date("m");
            $godina = date("Y");
        }
        else{
            $datum = strtotime($datum);
            $mjesec = date("m", $datum);
            $godina = date("Y", $datum);
        }
        try{
            $stmt = $this->db->prepare("INSERT INTO uplata (clan, mjesec, godina) VALUES (:clan, :mjesec, :godina)");
            $stmt->bindParam(":clan", $user_id);
            $stmt->bindParam(":mjesec", $mjesec);
            $stmt->bindParam(":godina", $godina);
            $stmt->execute();
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


}