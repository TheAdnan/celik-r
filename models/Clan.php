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

    }

    function add(){

    }

    function remove(){

    }

    function edit(){

    }
}