<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:55
 */

namespace models;

use core\ModelCore as ModelCore;
use PDO;

class ModelUser extends ModelCore
{
    public function getUser($userid = 0)
    {
        $query = 'SELECT * FROM user WHERE userid = :userid';
        $sql = $this->db->prepare($query);
        $sql->bindParam(':userid', $userid, PDO::PARAM_INT);

        if (!$sql->execute()) {
            die(json_encode($sql->errorInfo()));
        }
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function checkUserCredentials($username, $password)
    {
        $query = 'SELECT * FROM user WHERE username = :username AND password = :password';
        $sql = $this->db->prepare($query);
        $sql->bindParam(':username', $username, PDO::PARAM_STR);
        $sql->bindParam(':password', $password, PDO::PARAM_STR);

        if (!$sql->execute()) {
            die(json_encode($sql->errorInfo()));
        }
        return $sql->fetch(PDO::FETCH_OBJ);
    }
}