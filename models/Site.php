<?php
/**
 * Created by PhpStorm.
 * User: adnan
 * Date: 9/29/17
 * Time: 11:20 AM
 */

class Site{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function login($user, $pass){
        try{
            $stmt = $this->db->prepare("SELECT * FROM user WHERE username=:uname OR email=:umail LIMIT 1");
            $stmt->execute(array(':uname'=>$user, ':umail'=>$user));
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0)
            {
                if($this->checkPassword($pass, $user['password']))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    private function checkPassword($input, $pass){
        $hash = hash("sha256", $input);
        if($hash === $pass){
            return true;
        }
        return false;
    }
}