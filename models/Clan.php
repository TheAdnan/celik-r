<?php
/**
 * Created by PhpStorm.
 * User: adnan
 * Date: 9/29/17
 * Time: 11:20 AM
 */

class Clan{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function get($id){
        try{
            $stmt = $this->db->prepare("SELECT * FROM clan WHERE id=:id LIMIT 1");
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
            $stmt = $this->db->prepare("SELECT * FROM clan");
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

    function add($ime, $prezime){
        try{
            $stmt = $this->db->prepare("INSERT INTO clan (ime, prezime) VALUES (:ime, :prezime)");
            $stmt->bindParam(":ime", $ime);
            $stmt->bindParam(":prezime", $prezime);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function remove($id){
        try{
            $stmt = $this->db->prepare("DELETE FROM clan WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    function edit($id, $ime, $prezime){
        try{
            $stmt = $this->db->prepare("UPDATE clan SET ime=:ime, prezime=:prezime WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":ime", $ime);
            $stmt->bindParam(":prezime", $prezime);
            $stmt->execute();
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}